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
		$this->exclude_path[] = PLUGIN_DIGIRISK_PATH . 'core\external\wordpress_validator\test\request.test.php';
	}

	public function execute() {
		echo "[+] Starting request tests" . PHP_EOL . PHP_EOL;

		if ( !empty( $this->list_file ) ) {
		  foreach ( $this->list_file as $file_path ) {
				// $file_path = str_replace( '/', '\\', $file_path );
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
				if ( !preg_match_all( '#' . $pattern . '#', $line, $matches ) ) {
					unset($lines[$k]);
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
