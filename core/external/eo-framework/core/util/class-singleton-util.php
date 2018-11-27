<?php
/**
 * Classe abstract pour gérer les instances.
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

if ( ! class_exists( '\eoxia\Singleton_Util' ) ) {
	/**
	 * Le singleton
	 */
	abstract class Singleton_Util {
		/**
		 * L'instance courant du singleton
		 *
		 * @var \eoxia\Singleton_Util
		 */
		protected static $instance;

		/**
		 * Appelle le constructeur parent
		 *
		 * @since 0.1.0
		 * @version 1.0.0
		 */
		protected final function __construct() {
			$this->construct();
		}

		/**
		 * Le constructeur pour les enfants
		 *
		 * @since 0.1.0
		 * @version 1.0.0
		 *
		 * @return void
		 */
		abstract protected function construct();

		/**
		 * Récupères l'instance courante
		 *
		 * @since 0.1.0
		 * @version 1.0.0
		 *
		 * @return \eoxia\Singleton_Util L'instance courante
		 */
		final public static function g() {
			if ( ! isset( self::$instance ) || get_called_class() !== get_class( self::$instance ) ) {
				$class_name = get_called_class();
				$new_instance = new $class_name();
				// extending classes can set $instance to any value, so check to make sure it's still unset before giving it the default value.
				if ( ! isset( self::$instance ) || get_called_class() !== get_class( self::$instance ) ) {
					self::$instance = $new_instance;
				}
			}
			return self::$instance;
		}
	}
} // End if().
