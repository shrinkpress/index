<?php

namespace ShrinkPress\Index\Entity\Packages;

interface Package_Entity extends \JsonSerializable
{
	function packageName();

	function load(array $data);
}
