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
  public static function inc() {
		// /**	Check if the defined directory exists for reading and including the different modules	*/
    // $list_file = self::g()->get_list_file( $folder );
		//
		// if ( !empty( $list_file ) ) {
		//   foreach ( $list_file as $path_file ) {
		// 		echo "<pre>"; print_r($path_file); echo "</pre>";
		//   }
		// }
		//

		$module_name = "wpeo_model";
		$module_path = WPDIGI_PATH  . 'core/external/' . $module_name . '/';
		$module_config_path = WPDIGI_PATH  . 'core/external/' . $module_name . '/' . $module_name . '.config.json';
		// Vérifie si le fichier .config existe
		if ( !file_exists( $module_config_path ) ) {
			eo_log( 'digi_inc_module_' . $module_name, array(
				'message' => 'Le fichier ' . $module_name . '.config est inexistant.'
			), 2 );
			return false;
		}

		$config_content = file_get_contents( $module_config_path );
		$config_data = json_decode( $config_content );

		if ( empty( $config_data->state ) ) {
			eo_log( 'digi_inc_module_' . $module_name, array(
				'message' => 'La define ' . strtoupper($module_name) . '_STATE est inexistant.'
			), 2);
			return false;
		}

		if ( $config_data->state ) {
			eo_log( 'digi_inc_module_' . $module_name, array(
				'message' => 'Le module ' . $module_name . ' n\'est pas inclus, car le module est désactivé.'
			), 1);
		}

		include_util::g()->inc_dependencies( $module_name, $module_path, $config_data->dependencies );

    return true;
  }

	public function inc_dependencies( $module_name, $module_path, $list_dependencies ) {
		if ( !$list_dependencies ) {
			eo_log( 'digi_inc_module_' . $module_name, array(
				'message' => 'Le module ' . $module_name . ' est sans dépendance. Seulement le fichier .config est inclus'
			), 1);
			return false;
		}

		$timestamp_start = microtime(true);

		if ( !empty( $list_dependencies ) ) {
		  foreach ( $list_dependencies as $element ) {
				$list_file = scandir( $module_path . '/' . $element );

				if ( !empty( $list_file ) ) {
				  foreach ( $list_file as $file_name ) {
						$realpath = realpath( $module_path . '/' . $element . '/' . $file_name );

						if ( is_file( $realpath ) && $file_name != 'index.php' ) {
							require_once( $realpath );
						}
				  }
				}
		  }
		}

		$timestamp_end = microtime(true);
		$diff_time = $timestamp_end - $timestamp_start;

		eo_log( 'digi_inc_module_' . $module_name, array(
			'message' => 'Inclusion de toutes les dépendances du module ' . $module_name . ' en ' . $diff_time . ' sec'
		), 0);
	}

	public function callback_before_admin_enqueue_scripts() {
		$timestamp_start = microtime(true);

		wp_enqueue_script( 'jquery' );
		wp_enqueue_script( 'jquery-form' );
		wp_enqueue_script( 'jquery-ui-datepicker' );
		wp_enqueue_script( 'jquery-ui-autocomplete' );
		wp_enqueue_media();

		$timestamp_end = microtime(true);
		$diff_ms = $timestamp_end - $timestamp_start;
		eo_log( 'digi_inc_wordpress', array(
			'message' => 'Inclus les scripts de WordPress jquery, jquery-form, jquery-ui-datepicker, jquery-ui-autocomplete et enqueue_media en ' . $diff_ms . ' sec'
		));

	}

  public function callback_admin_enqueue_scripts() {
		$end_extension_js = WPDIGI_DEBUG ? "backend.js" : "min.js";
		$end_extension_css = WPDIGI_DEBUG ? ".css" : ".min.css";
    $this->enqueue_script( $this->get_list_file( WPDIGI_PATH, array(), false, $end_extension_js ) );
    $this->enqueue_style( $this->get_list_file( WPDIGI_PATH, array(), false, $end_extension_css ) );
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
				eo_log( 'digi_enqueue_script', array(
					'message' => 'Inclus le fichier JS ou CSS : ' . $filename . ' avec le chemin /wp-content' . $http_file[1]
				));
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
				eo_log( 'digi_print_scripts', array(
					'message' => 'Inclus le fichier CSS : ' . $filename . ' avec le chemin /wp-content' . $http_file[1]
				));
	      wp_register_style( 'eo-' . $filename, '/wp-content' . $http_file[1], array(), WPDIGI_VERSION );
	      wp_enqueue_style( 'eo-' . $filename );
			}
    }
  }

  private function print_scripts( $list_file ) {
		eo_log( 'digi_print_scripts', array(
			'message' => 'Inclus le fichier JS ou CSS : ' . $filename . ' avec le chemin /wp-content' . $http_file[1]
		));
    foreach ( $list_file as $file ) {
      require_once( $file[0] );
    }
  }

  private function get_list_file( $folder, $list_extension, $after = true, $end_ext = 'php' ) {
		$timestamp_start = microtime(true);
		$regex = 'action.php';
		$directory = new RecursiveDirectoryIterator( $folder );
		$iterator = new RecursiveIteratorIterator( $directory );
		$list_file = new RegexIterator( $iterator, '/^.+\.action.php$/i', RecursiveRegexIterator::GET_MATCH);
		$timestamp_end = microtime(true);
		$diff_ms = $timestamp_end - $timestamp_start;
		eo_log( 'digi_get_list_file', array(
			'message' => 'Recherche des fichiers ' . $regex . ' dans le dossier ' . $folder . ' en ' . $diff_ms . ' secondes'
		));
    return $list_file;
  }
}
