<?php

namespace ShrinkPress\Index\Entity\Includes;

interface Include_Entity extends \JsonSerializable
{
	function includedFile();

	function load(array $data);
}
