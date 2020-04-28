<?php

namespace ShrinkPress\Index\Parse\Visitor;

use PhpParser\Node;

use ShrinkPress\Index\Assist;
use ShrinkPress\Index\Storage;

class Functions extends Visitor_Abstract
{
	function leaveNode(Node $node)
	{
		if (!$node instanceof Node\Stmt\Function_)
		{
			return;
		}

		$functionName = (string) $node->name;
		$found = array(
			'filename' => $this->filename,
			'startLine' => $node->getStartLine(),
			'endLine' => $node->getEndLine(),
			'docCommentLine' => 0,
		);

		if ($docComment = $node->getDocComment())
		{
			$found['docCommentLine'] = $docComment->getLine();
		}

		$this->result[ $functionName ] = $found;
	}

	function flush(array $result, Storage\Storage_Abstract $index)
	{
		$file = $index->readFile( $this->filename );

		foreach($result as $functionName => $found)
		{
			Assist\Verbose::log(
				"Function: {$functionName}() at "
				 	. $this->filename . ':'
					. $found['startLine'],
				1);

			$entity = $index->readFunction( $functionName )->load( $found );
			$index->writeFunction( $entity );
			$file->addFunction( $entity );
		}

		$index->writeFile( $file );
	}
}
