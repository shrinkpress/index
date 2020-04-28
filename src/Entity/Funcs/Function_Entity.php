<?php

namespace ShrinkPress\Index\Entity\Funcs;

interface Function_Entity extends \JsonSerializable
{
	function functionName();

	function load(array $data);
}
