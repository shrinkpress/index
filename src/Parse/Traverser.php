<?php

namespace ShrinkPress\Index\Parse;

use PhpParser\Node;
use PhpParser\NodeTraverser;
use PhpParser\ParserFactory;

use ShrinkPress\Index\Assist;
use ShrinkPress\Index\Storage;
use ShrinkPress\Index\Parse\Visitor;

class Traverser
{
	use Assist\Instance;

	protected $parser;
	protected $traverser;

	protected $visitors = array();

	function __construct()
	{
		$this->visitors[] = new Visitor\Functions;
		$this->visitors[] = new Visitor\Calls;
		$this->visitors[] = new Visitor\Hooks;
		$this->visitors[] = new Visitor\Classes;
		$this->visitors[] = new Visitor\Globals;
		$this->visitors[] = new Visitor\Includes;

		$this->traverser = new NodeTraverser;
		$this->parser = (new ParserFactory)
			->create(ParserFactory::PREFER_PHP7);
	}

	function traverse( $filename, array $nodes, Storage\Storage_Abstract $index)
	{
		$traverser = $this->traverser;
		foreach ($this->visitors as $visitor)
		{
			$visitor->load( $filename, $index );

			$traverser->addVisitor( $visitor );
			$traverser->traverse( $nodes );
			$traverser->removeVisitor( $visitor );
		}
	}

	function parse($code)
	{
		return $this->parser->parse($code);
	}
}
