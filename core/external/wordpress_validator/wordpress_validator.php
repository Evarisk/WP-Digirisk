<?php

require './wordpress_validator.config.php';
require './script/wp-emulator.script.php';
require './class/file.class.php';
require './test/request.test.php';
require './test/functional.test.php';

require_once( PLUGIN_PATH . 'core/util/singleton.util.php' );
require_once( PLUGIN_PATH . 'core/util/include.util.php' );


$file_class = new file_class();
// $list_all_php_file = $file_class->get_list_file( PLUGIN_PATH, array( 'php' ) );
// $request_test = new request_test( $list_all_php_file );
// // $request_test->execute();
$file_class->inc( PLUGIN_PATH . 'core/wpeo_model', array( 'class', 'model' ) );
$file_class->inc( PLUGIN_PATH . 'core/wpdigi-utils', array( 'class', 'model' ) );
$file_class->inc( PLUGIN_PATH , array( 'config', 'util', 'model', 'class', 'action', 'filter', 'shortcode' ) );

$list_file = $file_class->get_list_file( PLUGIN_PATH, array( 'class' ));
$functional_test = new functional_test( $list_file );
$functional_test->execute();

?>
