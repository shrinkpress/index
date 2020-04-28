<?php

namespace ShrinkPress\Index\Parse\Visitor;

use PhpParser\Node;
use PhpParser\NodeVisitorAbstract;

use ShrinkPress\Index\Storage;
use ShrinkPress\Index\Entity;

abstract class Visitor_Abstract extends NodeVisitorAbstract
{
	protected $filename;
	protected $index;

	function load( $filename, Storage\Storage_Abstract $index)
	{
		$this->filename = (string) $filename;
		$this->index = $index;
	}

	protected $result = array();

	function beforeTraverse(array $nodes)
	{
		$this->result = array();
	}

	abstract function flush(array $result, Storage\Storage_Abstract $index);

	function afterTraverse(array $nodes)
	{
		if ($this->result)
		{
			$this->flush($this->result, $this->index);
			$this->result = array();
		}
	}
}
