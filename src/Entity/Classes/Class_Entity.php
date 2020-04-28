<?php

namespace ShrinkPress\Index\Entity\Classes;

interface Class_Entity extends \JsonSerializable
{
	function className();

	function load(array $data);
}
