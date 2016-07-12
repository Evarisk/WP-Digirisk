<?php

require './wordpress_validator.config.php';
require './script/wp-emulator.script.php';
require './class/file.class.php';
require './test/request.test.php';
require './test/functional.test.php';

require_once( PLUGIN_PATH . 'core/util/singleton.util.php' );
require_once( PLUGIN_PATH . 'core/util/include.util.php' );
require_once( PLUGIN_PATH . 'core/external/ReflectionDocBlock/DocBlockFactoryInterface.php' );
require_once( PLUGIN_PATH . 'core/external/ReflectionDocBlock/DocBlock/Tag.php' );
require_once( PLUGIN_PATH . 'core/external/ReflectionDocBlock/DocBlock/TagFactory.php' );
require_once( PLUGIN_PATH . 'core/external/ReflectionDocBlock/DocBlock/Tags/BaseTag.php' );
require_once( PLUGIN_PATH . 'core/external/ReflectionDocBlock/DocBlock/Tags/Factory/StaticMethod.php' );
require_once( PLUGIN_PATH . 'core/external/ReflectionDocBlock/DocBlock/Tags/Factory/Strategy.php' );
require_once( PLUGIN_PATH . 'core/external/ReflectionDocBlock/DocBlock/Tags/Formatter.php' );


$file_class = new file_class();

// $list_all_php_file = $file_class->get_list_file( PLUGIN_PATH, array( 'php' ) );
// $request_test = new request_test( $list_all_php_file );
// // $request_test->execute();

$file_class->inc( PLUGIN_PATH . 'core/wpeo_model', array( 'class', 'model' ) );
$file_class->inc( PLUGIN_PATH . 'core/wpdigi-utils', array( 'class', 'model' ) );
$file_class->inc( PLUGIN_PATH . 'core/external/webmozart', array( ) );
$file_class->inc( PLUGIN_PATH . 'core/external/TypeResolver', array( ) );
$file_class->inc( PLUGIN_PATH . 'core/external/ReflectionDocBlock', array( ) );
$file_class->inc( PLUGIN_PATH , array( 'config', 'util', 'model', 'class', 'action', 'filter', 'shortcode' ) );

$list_file = $file_class->get_list_file( PLUGIN_PATH, array( 'class', 'shortcode' ) );
$functional_test = new functional_test( $list_file );
$functional_test->set_exclude_path( array(
	PLUGIN_PATH . 'core\wpeo_model\class\comment.class.php',
	PLUGIN_PATH . 'core\wpeo_model\class\constructor_data.class.php',
	PLUGIN_PATH . 'core\wpeo_model\class\post.class.php',
	PLUGIN_PATH . 'core\wpeo_model\class\user.class.php',
	PLUGIN_PATH . 'core\wpeo_model\class\term.class.php',
) );
$functional_test->execute();

?>
