<?php

namespace ShrinkPress\Index\Entity\Files;

use ShrinkPress\Index\Entity;

class PHP_File Extends File_Abstract
{
	protected $classes = array();

	function addClass(Entity\Classes\Class_Entity $class)
	{
		$this->classes[ $class->className() ] = $class->startLine;
		return $this;
	}

	function getClasses()
	{
		return array_keys($this->classes);
	}

	protected $functions = array();

	function addFunction(Entity\Funcs\Function_Entity $func)
	{
		$this->functions[ $func->functionName() ] = $func->startLine;
		return $this;
	}

	protected $globals = array();

	function addGlobal(Entity\Globals\Global_Entity $global, $line)
	{
		$this->globals[ $global->globalName() ] = (int) $line;
		return $this;
	}

	protected $includes = array();

	function addInclude(Entity\Includes\Include_Entity $include, $line)
	{
		$this->includes[ $include->includedFile() ] = (int) $line;
		return $this;
	}
}
