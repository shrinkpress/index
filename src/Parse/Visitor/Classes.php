<?php

namespace ShrinkPress\Index\Parse\Visitor;

use PhpParser\Node;

use ShrinkPress\Index\Assist;
use ShrinkPress\Index\Storage;

class Classes extends Visitor_Abstract
{
	protected $namespace = '';

	function enterNode(Node $node)
	{
		if ($node instanceof Node\Stmt\Namespace_)
		{
			$this->namespace = (string) $node->name;
			return;
		}
	}

	function leaveNode(Node $node)
	{
		if ($node instanceof Node\Stmt\Namespace_)
		{
			$this->namespace = '';
			return;
		}

		if (!$node instanceof Node\Stmt\Class_)
		{
			return;
		}

		$className = (string) $node->name;
		$found = array(
			'namespace' => $this->namespace,
			'extends' => '',
			'filename' => $this->filename,
			'startLine' => $node->getStartLine(),
			'endLine' => $node->getEndLine(),
			'docCommentLine' => 0,
		);

		if ($docComment = $node->getDocComment())
		{
			$found['docCommentLine'] = $docComment->getLine();
		}

		if (!empty($node->extends))
		{
			$found['extends'] = (string) $node->extends;
		}

		$this->result[ $className ] = $found;
	}

	function flush(array $result, Storage\Storage_Abstract $index)
	{
		$file = $index->readFile( $this->filename );

		foreach($result as $className => $found)
		{
			$fullClassName = (!empty($found['namespace'])
				? $found['namespace'] . '\\'
				: '') . $className;

			Assist\Verbose::log(
				"Class: {$fullClassName} at "
				 	. $this->filename . ':'
					. $found['startLine'],
				1);

			$entity = $index->readClass( $fullClassName )->load( $found );
			$index->writeClass( $entity );
			$file->addClass( $entity );
		}

		$index->writeFile( $file );
	}
}
