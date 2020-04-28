<?php

namespace ShrinkPress\Index\Parse\Visitor;

use PhpParser\Node;
use ShrinkPress\Index\Assist;
use ShrinkPress\Index\Entity;
use ShrinkPress\Index\Storage;

class Calls extends Visitor_Abstract
{
	function leaveNode(Node $node)
	{
		if (!$node instanceof Node\Expr\FuncCall)
		{
			return;
		}

		if (!$node->name instanceOf Node\Name)
		{
			return;
		}

		$functionName = (string) $node->name;
		if (Assist\Internal::isInternal( $functionName ))
		{
			return;
		}

		$this->result[ $functionName ][] = $node->getLine();
	}

	function flush(array $result, Storage\Storage_Abstract $index)
	{
		foreach($result as $functionName => $lines)
		{
			$entity = $index->readFunction( $functionName );
			$index->readCalls($entity);

			foreach ($lines as $line)
			{
				Assist\Verbose::log(
					"Calls {$functionName}() at {$this->filename}:{$line}",
					2);
				$entity->addCall($this->filename, $line);
			}

			$index->writeCalls($entity);
		}
	}
}
