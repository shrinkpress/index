<?php
include __DIR__ . '/vendor/autoload.php';
ini_set('xdebug.max_nesting_level', 3000);

/////////////////////////////////////////////////////////////////////////////

use ShrinkPress\Index;

$wp_source = __DIR__ . '/wordpress';
Index\Assist\Verbose::level(4);

$index = new Index\Storage\Storage_Stash(
	new Index\Assist\Umbrella(__DIR__ . '/parsed')
	);

if (in_array('clean', $argv))
{
	$index->clean();
}

$source = new Index\Parse\Source(__DIR__ . '/wordpress');
$scanner = new Index\Parse\Scanner($source, $index);
$scanner->scanFolder('');

echo "Files: ", count( $index->getFiles() ), " found\n";
echo "Packages: ", count( $index->getPackages() ), " found\n";
echo "Functions: ", count( $index->getFunctions() ), " found\n";
echo "Classes: ", count( $index->getClasses() ), " found\n";
echo "Globals: ", count( $index->getGlobals() ), " found\n";
echo "Included: ", count( $index->getIncludes() ), " found\n";
