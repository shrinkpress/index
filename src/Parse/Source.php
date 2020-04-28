<?php

namespace ShrinkPress\Index\Parse;

use ShrinkPress\Index\Assist;

class Source Extends Assist\Umbrella
{
	function write($filename, $contents)
	{
		throw new \RuntimeException(
			'You are not allowed to write files '
		);
	}

       function unlink($filename)
       {
		throw new \RuntimeException(
			'You are not allowed to delete files '
		);
       }
}
