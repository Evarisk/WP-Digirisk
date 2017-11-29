<?php
/**
 * Méthodes utiles pour les logs
 *
 * @author Jimmy Latour <dev@eoxia.com>
 * @since 1.3.0
 * @version 1.3.0
 * @copyright 2015-2017 Eoxia
 * @package WPEO_Util
 */

namespace eoxia;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! class_exists( '\eoxia\LOG_Util' ) ) {
	define( 'EO_NOTICE', 'EO_NOTICE' );
	define( 'EO_RESPONSE_ERROR', 'EO_RESPONSE_ERROR' );
	define( 'EO_RESPONSE_SUCCESS', 'EO_RESPONSE_SUCCESS' );

	/**
	 * Méthodes utiles pour les fichiers JSON.
	 */
	class LOG_Util extends \eoxia\Singleton_Util {
		/**
		 * Le constructeur obligatoirement pour utiliser la classe \eoxia\Singleton_Util
		 *
		 * @return void nothing
		 */
		protected function construct() {}

		/**
		 * Méthode pour loggué.
		 *
		 * @since 1.3.0
		 * @version 1.3.0
		 *
		 * @param string $text      Votre texte de log.
		 * @param string $file_name Le nom de votre fichier sans l'extension.
		 * @param string $level     Le niveau d'erreur. Par défaut EO_NOTICE. {
		 *                          EO_NOTICE = Pour une informations
		 *                          EO_RESPONSE_ERROR = Si la réponse de la requête est une erreur.
		 *                          EO_RESPONSE_SUCCESS = Si la réponse de la requête est correcte.
		 * }.
		 *
		 * @return void
		 */
		public static function log( $text, $file_name, $level = EO_NOTICE ) {
			$bt = debug_backtrace();

			if ( empty( $file_name ) ) {
				error_log( 'Les logs sont enregistrés dans wp-content/uploads/logs/__PLUGIN_NAME__.' );
				self::log_wp_content( $text, $file_name, $level, $bt );
			} else {
				if ( false === ini_get( 'error_log' ) ) {
					error_log( 'Les logs sont enregistrés dans wp-content/uploads/logs/__PLUGIN_NAME__.' );
					self::log_wp_content( $text, $file_name, $level, $bt );
				} else {
					$path = dirname( ini_get( 'error_log' ) );

					if ( ! is_dir( $path ) ) {
						error_log( 'Les logs sont enregistrés dans wp-content/uploads/logs/__PLUGIN_NAME__.' );
						self::log_wp_content( $text, $file_name, $level, $bt );
					} else {
						error_log( current_time( '[d-M-Y H:i:s e]' ) . " PHP {$level}: {$text} in " . str_replace( '\\', '/', $bt[0]['file'] ) . " line  {$bt[0]['line']}\n", 3, $path . '/' . $file_name . '.log' );
					}
				}
			}
		}

		/**
		 * Méthode pour loggué dans un fichier dans le dossier 'wp-content/uploads' de WordPress.
		 *
		 * @since 1.3.0
		 * @version 1.3.0
		 *
		 * @param string $text      Votre texte de log.
		 * @param string $file_name Le nom de votre fichier sans l'extension.
		 * @param string $level     Le niveau d'erreur. Par défaut EO_NOTICE. {
		 *                          EO_NOTICE = Pour une informations
		 *                          EO_RESPONSE_ERROR = Si la réponse de la requête est une erreur.
		 *                          EO_RESPONSE_SUCCESS = Si la réponse de la requête est correcte.
		 * }.
		 * @param array  $bt         Le contexte de débogage.
		 *
		 * @return void          [description]
		 */
		public static function log_wp_content( $text, $file_name, $level = EO_NOTICE, $bt = array() ) {
			if ( empty( $bt ) ) {
				$bt = debug_backtrace();
			}

			$wp_upload_dir = wp_upload_dir();
			$file = fopen( $wp_upload_dir['path'] . '/' . $file_name . '.log', 'a' );
			fwrite( $file, current_time( '[d-M-Y H:i:s e]' ) . " PHP {$level}: {$text} in " . str_replace( '\\', '/', $bt[0]['file'] ) . " line  {$bt[0]['line']}\n" );
			fclose( $file );
		}
	}

} // End if().
