<?php

namespace ShrinkPress\Index\Entity\Files;

interface File_Entity extends \JsonSerializable
{
	function filename();

	function load(array $data);
}
