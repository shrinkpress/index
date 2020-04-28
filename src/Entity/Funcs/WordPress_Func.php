<?php

namespace ShrinkPress\Index\Entity\Funcs;

use ShrinkPress\Index\Entity;

class WordPress_Func extends Function_Abstract
{
	protected $callbacks = array();

	function addCallback($filename, $line, $hook, $caller)
	{
		$callback = array(
			(string) $filename,
			(int) $line,
			(string) $hook,
			(string) $caller
			);

		$this->callbacks[ "{$callback[0]}:{$callback[1]}" ] = $callback;

		return $this;
	}

	function getCallbacks()
	{
		return $this->callbacks;
	}
}
