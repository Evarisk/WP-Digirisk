<?php if ( !defined( 'ABSPATH' ) ) exit;

/**
 * @author Jimmy Latour <jimmy.eoxia@gmail.com>
 * @version 1.0
 * Abstract Singleton class for PHP.  Extending classes must define a protected static $instance member.
 */

class include_util extends singleton_util {
  protected function construct() {}
  /**
  * Include all files in $folder that respects the extension specified in $list_extension
  * This function can be recursive.
  *
  * @param string $folder : The folder Name. If empty, search in the current folder.
  * @param array $list_type : The list of extention. Can be ['class', 'action', 'util', 'deprecated', 'essential'].
  * If empty, nothing be loaded.
  * @param bool $recursive : Recursive or not. Default : false
  * @return bool True/False
  */
  public static function inc( $folder, $list_extension, $recursive = false ) {
		/**	Check if the defined directory exists for reading and including the different modules	*/
    $list_file = self::g()->get_list_file( $folder, $list_extension );
		$list_exclude_dir = array( 'core\\\external' );
    $ordered_file = array();

		$plugin_dir_path = plugin_dir_path( __FILE__ );
		$plugin_dir_path = str_replace( '\\', '/', substr( $plugin_dir_path, 0, count( $plugin_dir_path ) - 11) );

  	foreach ( $list_file as $file ) {
      if ( !empty( $file[0] ) && !empty( $file[1] ) && is_file($file[0]) )  {
				$file[0] = str_replace( '\\', '/', $file[0] );
				$file_path = str_replace($plugin_dir_path, '', $file[0]);
				$file_path = explode('/', $file_path);
				$module_name = "";
				if (!empty( $file_path ) && !empty( $file_path[1] ) ) {
					$module_name = $file_path[1];
				}
				if ( !preg_match( '/' . implode( '|', $list_exclude_dir ) . '/', $file[0] ) ) {
        	$ordered_file[$module_name][$file[1]][] = $file[0];
				}
      }
    }

    foreach ( $list_extension as $extension ) {
			foreach ( $ordered_file as $module_name => $array_extension )
      if ( !empty( $array_extension[$extension] ) ) {
        foreach ( $array_extension[$extension] as $file ) {
					if (!empty( $module_name ) && defined( strtoupper( $module_name ) . '_STATE' ) ) {
						if ( constant( strtoupper( $module_name ) . '_STATE' ) ) {
							require_once ( $file );
						}
					}
					else {
	          require_once ( $file );
					}
        }
      }
    }

    return true;
  }

	public function callback_before_admin_enqueue_scripts() {
		wp_enqueue_script( 'jquery' );
		wp_enqueue_script( 'jquery-form' );
		wp_enqueue_script( 'jquery-ui-datepicker' );
		wp_enqueue_script( 'jquery-ui-autocomplete' );
		wp_enqueue_media();
	}

  public function callback_admin_enqueue_scripts() {
		$end_extension_js = WPDIGI_DEBUG ? "backend.js" : "min.js";
    $this->enqueue_script( $this->get_list_file( WPDIGI_PATH, array(), false, $end_extension_js ) );
    $this->enqueue_style( $this->get_list_file( WPDIGI_PATH, array(), false, 'css' ) );
  }

  public function callback_admin_print_scripts() {
    $this->print_scripts( $this->get_list_file( WPDIGI_PATH, array(), false, 'js.php' ) );
  }

  private function enqueue_script( $list_file ) {
    foreach ( $list_file as $file ) {
      $filename = explode( '\\', $file[0] );
      $filename = $filename[count($filename) - 1];
			if ( $filename !== 'no-back-page.backend.js' ) {
	      $http_file = explode( 'wp-content', str_replace( '\\', '/', $file[0] ) );
	      wp_enqueue_script( 'eo-' . $filename, '/wp-content' . $http_file[1], array(), WPDIGI_VERSION, false );
			}
    }
  }

  private function enqueue_style( $list_file ) {
    foreach ( $list_file as $file ) {
      $filename = explode( '\\', $file[0] );
      $filename = $filename[count($filename) - 1];
			if ( $filename !== 'font-awesome.min.css' ) {
	      $http_file = explode( 'wp-content', str_replace( '\\', '/', $file[0] ) );
	      wp_register_style( 'eo-' . $filename, '/wp-content' . $http_file[1], array(), WPDIGI_VERSION );
	      wp_enqueue_style( 'eo-' . $filename );
			}
    }
  }

  private function print_scripts( $list_file ) {
    foreach ( $list_file as $file ) {
      require_once( $file[0] );
    }
  }

  private function get_list_file( $folder, $list_extension, $after = true, $end_ext = 'php' ) {
    $dir = new RecursiveDirectoryIterator( $folder );
    $ite = new RecursiveIteratorIterator( $dir );
    $regex = '/^.*\\';
    $regex .= !empty( $list_extension ) ? '.(' . implode( '|', $list_extension ) . ')' : '';
    $regex .= $after ? '.' : '.';
    $regex .= !empty( $end_ext ) ? $end_ext . '$/' : '';
    $list_file = new RegexIterator( $ite, $regex, RegexIterator::GET_MATCH );
    return $list_file;
  }
}
