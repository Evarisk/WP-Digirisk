<?php
/**
 * La classe principale de EO-Framework
 *
 * @author Jimmy Latour <dev@eoxia.com>
 * @since 1.0.0
 * @version 1.0.0
 * @copyright 2015-2017 Eoxia
 * @package EO_Framework
 */

namespace eoxia001;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! class_exists( '\eoxia001\Core_Class' ) ) {

	/**
	 * La classe principale de EO-Framework
	 */
	class Core_Class extends \eoxia001\Singleton_Util {
		/**
		 * Le constructeur obligatoirement pour utiliser la classe \eoxia001\Singleton_Util
		 *
		 * @since 1.0.0
		 * @version 1.0.0
		 */
		protected function construct() {}

		/**
		 * Renvoies les données pour les scripts JS.
		 *
		 * @since 1.0.0
		 * @version 1.0.0
		 *
		 * @return array {
		 * }.
		 */
		public function get_localize_script_data() {
			ob_start();
			require( \eoxia001\Config_Util::$init['eo-framework']->path . 'core/view/modal.view.php' );
			$view_modal = ob_get_clean();

			ob_start();
			require( \eoxia001\Config_Util::$init['eo-framework']->path . 'core/view/modal-buttons.view.php' );
			$view_modal_buttons = ob_get_clean();

			$data = array(
				'modalView'          => $view_modal,
				'modalDefautButtons' => $view_modal_buttons,
			);

			return $data;
		}
	}
} // End if().
