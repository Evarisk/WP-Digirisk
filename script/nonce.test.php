<?php
/**
* @author: Jimmy Latour jimmy.eoxia@gmail.com
*/

require_once( '../task-manager/script/wp-emulator.script.php' );

DEFINE( 'WPEO_TASKMANAGER_PATH', str_replace( "\\", "/", plugin_dir_path( __FILE__ ) ) . '../' );

require_once( WPEO_TASKMANAGER_PATH . 'core/wpeo_util.01.php' );
require_once( WPEO_TASKMANAGER_PATH . 'core/wpeo_template.01.php' );

require_once( WPEO_TASKMANAGER_PATH . '/core/taskmanager/taskmanager.controller.01.php' );
require_once( WPEO_TASKMANAGER_PATH . '/core/taskmanager/taskmanager.action.01.php' );

taskmanager\util\wpeo_util::install_module( 'wpeo_model' );
taskmanager\util\wpeo_util::install_in( 'core' );
taskmanager\util\wpeo_util::install_in( 'module' );

require_once( WPEO_TASK_WPSHOP_PATH . '/controller/task_wpshop.controller.01.php' );
require_once( WPEO_TASK_WPSHOP_PATH . '/controller/task_wpshop.action.01.php' );


echo "[+] Starting Nonce Tests" . PHP_EOL . PHP_EOL;

// Search for test files
$unitList = search_files('../', "/^.*\.php$/");
$string_post_unsecured = array();
$total_unsecured_line = 0;

// Loop on unitList
foreach($unitList as $test)
{
	// echo "[+] Testing -> " . $test . PHP_EOL;
  if ( $test != '../task-manager/script/request.test.php' || $test != '../task-manager/script/nonce.test.php' ) {
    $content = file_get_contents( $test );

    $pattern = '/class ([a-z0-9_]+) (extends .* {|{)/';
    preg_match( $pattern, $content, $matches );

    $namespace_pattern = '/namespace (.*);/';
    preg_match( $namespace_pattern, $content, $matches_namespace );

    if ( !empty( $matches ) && !empty( $matches[1] ) ) {
      $class_name = !empty( $matches_namespace ) && !empty( $matches_namespace[1] ) ? $matches_namespace[1] . '\\' : '';
      $class_name .= $matches[1];
      $class = new ReflectionClass( $class_name );
      $methods = $class->getMethods();

      $list_ajax_method = array();

      if ( !empty( $methods ) ) {
        foreach ( $methods as $element ) {
          if ( $element->name == '__construct' ) {
            $list_ajax_method = get_list_ajax_method($class, $element->name);

            if ( !empty( $list_ajax_method ) ) {
              foreach ( $list_ajax_method as $method_name ) {
                if ( !check_nonce( $class, $method_name ) ) {
                  $string_post_unsecured[$matches[1]][] = $method_name;
                  $total_unsecured_line++;
                }
              }
            }
          }
        }
      }
    }
  }
}

echo "[+] Total unsecured nonce : " . $total_unsecured_line . PHP_EOL . '<br />';

if ( !empty( $string_post_unsecured ) ) {
  foreach ( $string_post_unsecured as $name_file => $file ) {
    if ( !empty( $file ) ) {
      echo "[+] File : " . $name_file . ' => Unsecured nonce ' . count( $file ) . PHP_EOL . '<br />';
      foreach ( $file as $fonction_name => $content ) {
        echo "[+] Not found nonce on : " . $content . PHP_EOL . '<br />';
      }
    }
  }
}

if ( $total_unsecured_line != 0 )
  trigger_error( "[+] Total unsecured nonce : " . $total_unsecured_line, E_USER_ERROR );

echo "[+] Nonce Tests Finished" . PHP_EOL;

function search_files($folder, $pattern)
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

function get_list_ajax_method( $class, $name ) {
  $content = getMethodContent( $class, $name );
  preg_match_all( '#add_action\( *(\'|")wp_ajax_(nopriv_)?.+(\'|"),.+(\'|")(.+)(\'|").+\)#isU', $content, $matches );
  return ( !empty( $matches ) && !empty( $matches[5] ) ) ? $matches[5] : array();
}

function check_nonce( $class, $name ) {
  $content = getMethodContent( $class, $name );

  if ( !preg_match( '#wp_verify_nonce#', $content ) &&
	 	!preg_match( '#check_ajax_referer#', $content ) ) {
      return false;
	}

  return $name;
}

function getMethodContent($class, $name) {
  $method = $class->getMethod( $name );
  $filename = $method->getFileName();
  $start_line = $method->getStartLine() - 1; // it's actually - 1, otherwise you wont get the function() block
  $end_line = $method->getEndLine();
  $length = $end_line - $start_line;

  $source = file($filename);
  $body = implode("", array_slice($source, $start_line, $length));
  return $body;
}
