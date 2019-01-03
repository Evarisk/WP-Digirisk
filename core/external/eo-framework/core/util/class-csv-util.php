<?php
/**
 * Méthodes utilitaires pour les fichiers CSV.
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

if ( ! class_exists( '\eoxia\CSV_Util' ) ) {

	/**
	 * Méthodes utilitaires pour les fichiers CSV.
	 */
	class CSV_Util extends \eoxia\Singleton_Util {
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
		 * Lit un fichier CSV et forme un tableau 2D selon $list_index
		 *
		 * @since 0.1.0
		 * @version 1.0.0
		 *
		 * @param string $csv_path   Le chemin vers le fichier .csv.
		 * @param array  $list_index Les index personnalisés.
		 * @return array 						 Le tableau 2D avec les données du csv
		 *
		 * @todo: Est-ce utile ? Utilisé par quel plugin ?
		 */
		public function read_and_set_index( $csv_path, $list_index = array() ) {
			if ( empty( $csv_path ) ) {
				return false;
			}

			$data = array();
			$csv_content = file( $csv_path );
			if ( ! empty( $csv_content ) ) {
				foreach ( $csv_content as $key => $line ) {
					if ( 0 !== $key ) {
						$data[ $key ] = str_getcsv( $line );
						foreach ( $data[ $key ] as $i => $entry ) {
							if ( ! empty( $list_index[ $i ] ) ) {
								$data[ $key ][ $list_index[ $i ] ] = $entry;
							}
						}
					}
				}
			}

			return $data;
		}
	}
} // End if().
