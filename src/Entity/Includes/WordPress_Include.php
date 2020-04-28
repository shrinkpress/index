<?php

namespace ShrinkPress\Index\Entity\Includes;

use ShrinkPress\Index\Entity;

class WordPress_Include implements Include_Entity
{
	use Entity\Load;

	protected $includedFile;

	function __construct($includedFile)
	{
		$this->includedFile = (string) $includedFile;
	}

	function includedFile()
	{
		return $this->includedFile;
	}

	protected $includes = array();

	function getIncludes()
	{
		return array_values($this->includes);
	}

	const TYPE_INCLUDE = 'include';
	const TYPE_INCLUDE_ONCE = 'include_once';
	const TYPE_REQUIRE = 'require';
	const TYPE_REQUIRE_ONCE = 'require_once';

	function addInclude(Entity\Files\File_Entity $file, $line, $docCommentLine, $includeType = self::TYPE_REQUIRE_ONCE)
	{
		$filename = $file->filename();
		$line = (int) $line;
		$docCommentLine = (int) $docCommentLine;

		$include = "{$filename}:{$line}";
		$this->includes[ $include ] = array($filename, $line, $docCommentLine, $includeType);

		$file->addInclude( $this, $line );
	}

}
