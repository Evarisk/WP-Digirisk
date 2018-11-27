<?php
/**
 * Méthodes utiles pour les fichiers JSON.
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

if ( ! class_exists( '\eoxia\JSON_Util' ) ) {
	/**
	 * Méthodes utiles pour les fichiers JSON.
	 */
	class JSON_Util extends \eoxia\Singleton_Util {
		/**
		 * Le constructeur obligatoirement pour utiliser la classe \eoxia\Singleton_Util
		 *
		 * @return void nothing
		 */
		protected function construct() {}

		/**
		 * Ouvres et décode le fichier JSON $path_to_json
		 *
		 * @since 0.1.0
		 * @version 1.0.0
		 *
		 * @param  string $path_to_json Le chemin vers le fichier JSON.
		 * @param  string $output       Peut être STDCLASS ou ARRAY_A ou ARRAY_N. Défault STDCLASS.
		 *
		 * @return array              	Les données du fichier JSON
		 */
		public function open_and_decode( $path_to_json, $output = 'STDCLASS' ) {
			if ( ! file_exists( $path_to_json ) ) {
				return new \WP_Error( 'broke', __( 'Enabled to load JSON file', 'eoxia' ) );
			}

			$config_content = file_get_contents( $path_to_json );

			if ( 'STDCLASS' === $output ) {
				$data = json_decode( $config_content );
			} elseif ( 'ARRAY_A' === $output ) {
				$data = json_decode( $config_content, true );
			}

			if ( null === $data && json_last_error() !== JSON_ERROR_NONE ) {
				return new \WP_Error( 'broke', __( 'Error in JSON file', 'eoxia' ) );
			}

			return $data;
		}

		/**
		 * Décodes la chaine de caractère $json_to_decode
		 *
		 * @since 0.1.0
		 * @version 1.0.0
		 *
		 * @param  string $json_to_decode La chaine de caractère JSON.
		 * @return array              		Les données décodées
		 */
		public function decode( $json_to_decode ) {
			if ( ! is_string( $json_to_decode ) ) {
				return $json_to_decode;
			}

			$json_decoded = json_decode( $json_to_decode, true );

			if ( ! $json_decoded ) {
				$json_to_decode = str_replace( '\\', '', $json_to_decode );
				$json_decoded   = json_decode( $json_to_decode, true );

				if ( ! $json_decoded ) {
					return $json_to_decode;
				}
			}

			return $json_decoded;
		}
	}
} // End if().
