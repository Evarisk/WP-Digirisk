<?php
/**
* @author: Jimmy Latour lelabodudev@gmail.com
*/

class request_test {
	private $string_post_unsecured = array();
	private $total_unsecured_line = 0;
	private $exclude_path = array();

	public function __construct( $list_file ) {
		$this->list_file = $list_file;
		$this->exclude_path[] = PLUGIN_PATH . 'core\external\wordpress_validator\test\request.test.php';
	}

	public function execute() {
		echo "[+] Starting request tests" . PHP_EOL . PHP_EOL;

		echo "<pre>"; print_r($this->exclude_path); echo "</pre>";

		if ( !empty( $this->list_file ) ) {
		  foreach ( $this->list_file as $file_path ) {
				$file_path = str_replace( '/', '\\', $file_path );
				if ( !in_array( $file_path, $this->exclude_path ) ) {
					$lines = file( $file_path );
					$string_post_unsecured[$file_path] = array();

					if ( !empty( $lines ) ) {
						$lines = $this->delete_not_request_line( $lines );
						$this->search_fail( $file_path, $lines );
					}
				}
		  }
		}

		$this->display();

		echo "[+] End request tests" . PHP_EOL . PHP_EOL;
	}

	private function delete_not_request_line( $lines ) {
		$pattern = '\$_POST|\$_GET|\$_REQUEST';
		if ( !empty( $lines ) ) {
		  foreach ( $lines as $k => $line ) {
				if ( !preg_match_all( '#' . $pattern . '#', $line ) ) {
					unset($lines[$k]);
					// $lines[$k] = preg_replace( '#!empty\(.+?(' . $pattern . ')\[\'.+\'\].+?\) \?#isU', '', $lines[$key] );
				}
		  }
		}

		return $lines;
	}

	private function search_fail( $file_path, $lines ) {
		if ( !empty( $lines ) ) {
		  foreach ( $lines as $k => $line ) {
				if ( !preg_match( '#sanitize_.+#', $lines[$k] ) &&
	        !preg_match( '#esc_.+#', $lines[$k] ) &&
					!preg_match( '#\*#', $lines[$k] ) &&
					!preg_match( '#\\/\/#', $lines[$k] ) &&
					!preg_match( '#\( ?int ?\)#', $lines[$k] ) &&
					!preg_match( '#\( ?array ?\)#', $lines[$k] ) &&
					!preg_match( '#\( ?float ?\)#', $lines[$k] ) &&
					!preg_match( '#\( ?bool ?\)#', $lines[$k] ) &&
					!preg_match( '#intval#', $lines[$k] ) &&
					!preg_match( '#varSanitizer#', $lines[$k] ) ) {
					  $this->string_post_unsecured[$file_path][$k + 1] = htmlentities( $lines[$k] );
					  $this->total_unsecured_line++;
				  }

			  if ( preg_match( '#(\$_POST|\$_GET|\$_REQUEST)\[\'.+\'\].+?\=#isU', $lines[$k] ) &&
        !preg_match( '#\* @#', $lines[$k] ) &&
        !preg_match( '#\\/\/#', $lines[$k] ) &&
        !preg_match( '#\*#', $lines[$k] ) ) {
  				$this->string_post_unsecured[$file_path][$k + 1] = htmlentities( $lines[$k] );
  				$this->total_unsecured_line++;
			  }
		  }
		}
	}

	private function display() {
		echo "[+] Total unsecured line : " . $this->total_unsecured_line . PHP_EOL;

		if ( !empty( $this->string_post_unsecured ) ) {
		  foreach ( $this->string_post_unsecured as $file_path => $lines ) {
				if ( !empty( $lines ) ) {
					echo "[+] File : " . $file_path . ' => Unsecured $_POST|$_GET|$_REQUEST ' . count( $lines ) . PHP_EOL;

					foreach( $lines as $line => $content ) {
		        echo "[+]Line : " . $line . " => " . trim($content) . PHP_EOL;
					}
				}
		  }
		}
	}
}
//
// if ( !function_exists( 'search_files' ) ) {
// 	function search_files($folder, $pattern) {
// 		$dir = new RecursiveDirectoryIterator($folder);
// 		$ite = new RecursiveIteratorIterator($dir);
// 		$files = new RegexIterator($ite, $pattern, RegexIterator::GET_MATCH);
// 		$fileList = array();
// 		foreach($files as $file)
// 		{
// 			$fileList[] = $file[0];
// 		}
// 		return $fileList;
// 	}
// }
//
// echo "[+] Starting Request Tests" . PHP_EOL . PHP_EOL;
//
// // Search for test files
// $unitList = search_files('../', "/^.*\.php$/");
// $string_post_unsecured = array();
// $total_unsecured_line = 0;
// $pattern = '#\$_POST|\$_GET|\$_REQUEST#';
//
// // Loop on unitList
// foreach ( $unitList as $file_path )
// {
// 	// echo "[+] Testing -> " . $file_url . PHP_EOL;
// 	$lines = file( $file_url );
// 	$string_post_unsecured[$file_url] = array();
//
//
// 	if ( !empty( $lines ) ) {
// 		foreach ( $lines as $key => $line ) {
// 	    if ( preg_match( $pattern, $line ) ) {
// 	      $lines[$key] = preg_replace( '#!empty\(.+?(\$_POST|\$_GET|\$_REQUEST)\[\'.+\'\].+?\) \?#isU', '', $lines[$key] );
//
// 			if ( $file_url != "../Digirisk/script/request.test.php" && $file_url != "..\\Digirisk\\script\\request.test.php" ) {
// 			  if ( !preg_match( '#sanitize_.+#', $lines[$key] ) &&
//         !preg_match( '#esc_.+#', $lines[$key] ) &&
// 				!preg_match( '#\*#', $lines[$key] ) &&
// 				!preg_match( '#\\/\/#', $lines[$key] ) &&
// 				!preg_match( '#\( ?int ?\)#', $lines[$key] ) &&
// 				!preg_match( '#\( ?array ?\)#', $lines[$key] ) &&
// 				!preg_match( '#\( ?float ?\)#', $lines[$key] ) &&
// 				!preg_match( '#\( ?bool ?\)#', $lines[$key] ) &&
// 				!preg_match( '#intval#', $lines[$key] ) &&
// 				!preg_match( '#varSanitizer#', $lines[$key] ) ) {
// 				  $string_post_unsecured[$file_url][$key + 1] = htmlentities( $lines[$key] );
// 				  $total_unsecured_line++;
// 			  }
//
// 			  if ( preg_match( '#(\$_POST|\$_GET|\$_REQUEST)\[\'.+\'\].+?\=#isU', $lines[$key] ) &&
//         !preg_match( '#\* @#', $lines[$key] ) &&
//         !preg_match( '#\\/\/#', $lines[$key] ) &&
//         !preg_match( '#\*#', $lines[$key] ) ) {
//   				$string_post_unsecured[$file_url][$key + 1] = htmlentities( $lines[$key] );
//   				$total_unsecured_line++;
// 			  }
// 			}
// 		}
// 	}
//   }
// }
//
// echo "[+] Total unsecured line : " . $total_unsecured_line . PHP_EOL . '<br />';
//
// if ( !empty( $string_post_unsecured ) ) {
//   foreach ( $string_post_unsecured as $file_url => $file ) {
//     if ( !empty( $file ) ) {
//       echo "[+] File : " . $file_url . ' => Unsecured $_POST|$_GET|$_REQUEST ' . count( $file ) . PHP_EOL . '<br />';
//       foreach ( $file as $line => $content ) {
//         $color = "black";
//         if ( preg_match( '#\$_POST#', trim($content) ) ) {
//           $color = "#ea6153";
//         }
//         else if( preg_match( '#\$_GET#', trim($content) ) ) {
//           $color = "#3498db";
//         }
//         else if( preg_match( '#\$_REQUEST#', trim($content) ) ) {
//           $color = "#2ecc71";
//         }
//         else if( preg_match( '#\$_SESSION#', trim($content) ) ) {
//           $color = "#f1c40f";
//         }
//
//         echo "[+]Line : " . $line . " => " . trim($content) . PHP_EOL;
//       }
//     }
//   }
// }
//
// if ( $total_unsecured_line != 0 )
//   trigger_error( "[+] Total unsecured line : " . $total_unsecured_line, E_USER_ERROR );
//
// echo "[+] Request Tests Finished" . PHP_EOL;
