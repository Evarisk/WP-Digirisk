<?php
/**
 * Gestion des fichiers ZIP.
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

if ( ! class_exists( '\eoxia\ZIP_Util' ) ) {
	/**
	 * Gestion des fichiers ZIP
	 */
	class ZIP_Util extends \eoxia\Singleton_Util {

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
		 * Dézippes l'archive $zip_path dans $destination_path
		 * Retournes tous les noms des fichiers contenus dans l'archive
		 *
		 * @since 0.1.0
		 * @version 1.0.0
		 *
		 * @param  string $zip_path         Le chemin vers l'archive.
		 * @param  string $destination_path Le chemin d'extraction des fichiers.
		 * @return array {
		 * 			Les propriétés du tableau retourné.
		 *
		 * 			@type boolean state True ou False.
		 * 			@type array $list_file Contenant plusieurs index avec le nom des fichiers dézippés.
		 * }
		 */
		public function unzip( $zip_path, $destination_path ) {
			$zip = new \ZipArchive;
			$data = array( 'state' => true, 'list_file' => array() );

			if ( $zip->open( $zip_path ) === true ) {
				if ( ! $zip->extractTo( $destination_path ) ) {
					$data['state'] = false;
				}

				// Récupérations de tous les fichiers.
				for ( $i = 0; $i < $zip->numFiles; $i++ ) {
					$filename = $zip->getNameIndex( 0 );

					if ( isset( $filename ) ) {
						$data['list_file'][] = $filename;
					}
				}

				$zip->close();
			} else {
				$data['state'] = false;
			}

			return $data;
		}
	}
} // End if().
