<?php

namespace ShrinkPress\Index\Assist;

class Code
{
	static function extractPackage($code, $entity)
	{
		$doccomment = substr($code, 0, 1024);

		if (preg_match('~\s*\*\s+@package\s+(.+)\s+\*~Uis', $doccomment, $R))
		{
			$entity->docPackage = $R[1];
		}

		if (preg_match('~\s*\*\s+@subpackage\s+(.+)\s+\*~Uis', $doccomment, $R))
		{
			$entity->docSubPackage = $R[1];
		}

		return $entity;
	}

}
