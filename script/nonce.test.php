<?php
/**
* @author: Jimmy Latour jimmy.eoxia@gmail.com
*/

require_once( '../Digirisk/script/wp-emulator.script.php' );

DEFINE( 'WPDIGI_PATH', str_replace( "\\", "/", plugin_dir_path( __FILE__ ) ) . '../' );
DEFINE( 'EVA_PLUGIN_VERSION', 'test' );

include_once( WPDIGI_PATH . '/core/module_management/module_management.php');

/**	Appel automatique des modules présent dans le plugin / Install automatically modules into module directory	*/
digi_module_management::extra_modules();


require_once( WPDIGI_PATH . '/core/digirisk/digirisk.ctr.01.php' );
require_once( WPDIGI_PATH . '/core/digirisk/digirisk.action.01.php' );

echo "[+] Starting Nonce Tests" . PHP_EOL . PHP_EOL;

// Search for test files
$unitList = search_files('../', "/^.*\.php$/");
$string_post_unsecured = array();
$total_unsecured_line = 0;

// Loop on unitList
foreach($unitList as $test)
{
	// echo "[+] Testing -> " . $test . PHP_EOL;
  if ( $test != '../Digirisk/script/request.test.php' || $test != '../Digirisk/script/nonce.test.php' ) {
		echo "[+] test : " . $test . PHP_EOL;
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
