<?php
// define("UNIT_TESTING", 1);
// include wp emulation
include('wp-emulator.script.php');

require_once( '../digirisk.config.php' );
require_once( '../core/util/singleton.util.php' );
require_once( '../core/util/include.util.php' );

include_util::inc( WPDIGI_PATH . 'core/wpeo_model', array( 'class', 'model' ) );
include_util::inc( WPDIGI_PATH . 'core/wpdigi-utils', array( 'class', 'model' ) );
include_util::inc( WPDIGI_PATH , array( 'config', 'util', 'model', 'class', 'action', 'filter', 'shortcode' ) );

define('END_TEST', "/^.*\.test\.php$/");

echo "[+] Starting Unit Tests" . PHP_EOL . PHP_EOL;

// Search for test files
$unitList = searchFiles('../', END_TEST);

// Loop on unitList
foreach($unitList as $test)
{
	echo "[+] Testing -> " . $test . PHP_EOL . '<br />';
	include($test);
}

echo "[+] Unit Tests Finished" . PHP_EOL;

/* Recursively search files
	folder = string => where to search
	patter = string => regexp for what to search
*/
function searchFiles($folder, $pattern)
{
	$dir = new RecursiveDirectoryIterator($folder);
	$ite = new RecursiveIteratorIterator($dir);
	$files = new RegexIterator($ite, $pattern, RegexIterator::GET_MATCH);
	$fileList = array();
	foreach($files as $file)
	{
		$fileList[] = $file[0];
	}
	return $fileList;
}
?>
