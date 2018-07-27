<?php
/**
 * Méthodes utiles pour WPEO_Model.
 *
 * @author Jimmy Latour <dev@eoxia.com>
 * @since 0.1.0
 * @version 1.0.0
 * @copyright 2015-2017 Eoxia
 * @package WPEO_Util
 * @todo: Est-ce utilisé ?
 */

namespace eoxia001;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! class_exists( '\eoxia001\Model_Util' ) ) {
	/**
	 * Méthodes utiles pour WPEO_Model.
	 */
	class Model_Util extends \eoxia001\Singleton_Util {
		public static $namespace = '';
		/**
		 * Le constructeur obligatoirement pour utiliser la classe \eoxia001\Singleton_Util
		 *
		 * @return void nothing
		 */
		protected function construct() {}

		public function set_namespace( $namespace ) {
			self::$namespace = $namespace;
		}

		public function get_namespace() {
			return self::$namespace . '\\';
		}

		public static function exec_callback( $object, $functions ) {
			if ( ! empty( $functions ) ) {
				foreach ( $functions as $function ) {
					$object = call_user_func( $function, $object );
				}
			}

			return $object;
		}
	}
}
