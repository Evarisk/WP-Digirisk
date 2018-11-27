<?php
/**
 * Gestion des inclusions.
 *
 * @author Eoxia <dev@eoxia.com>
 * @since 0.1.0
 * @version 1.0.0
 * @copyright 2015-2018 Eoxia
 * @package EO_Framework\Core\Util
 */

namespace eoxia;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! class_exists( '\eoxia\Include_Util' ) ) {
	/**
	 * Gestion des inclusions.
	 */
	class Include_Util extends \eoxia\Singleton_Util {
		/**
		 * Le constructeur obligatoirement pour utiliser la classe \eoxia\Singleton_Util
		 *
		 * @since 0.1.0
		 * @version 1.0.0
		 *
		 * @return void
		 */
		protected function construct() {}

		/**
		 * Récupères les fichiers dans le dossier $folder_path
		 *
		 * @since 0.1.0
		 * @version 1.0.0
		 *
		 * @param  string $folder_path Le chemin du dossier.
		 * @return void
		 */
		public function in_folder( $folder_path ) {
			$list_file_name = scandir( $folder_path );

			if ( ! empty( $list_file_name ) ) {
				foreach ( $list_file_name as $file_name ) {
					if ( '.' !== $file_name && '..' !== $file_name && 'index.php' !== $file_name && '.git' !== $file_name && 'README.md' !== $file_name ) {

						$file_path = realpath( $folder_path . $file_name );
						$file_success = require_once( $file_path );
					}
				}
			}

		}
	}
} // End if().
