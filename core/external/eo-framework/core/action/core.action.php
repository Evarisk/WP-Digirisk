<?php
/**
 * Inclusions de wpeo_assets
 *
 * @author Eoxia <dev@eoxia.com>
 * @since 1.0.0
 * @version 1.0.0
 * @copyright 2015-2018 Eoxia
 * @package EO_Framework\Core\Action
 */

namespace eoxia;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Inclusions de wpeo_assets
 */
class Core_Action {

	/**
	 * Le constructeur ajoutes les actions WordPress suivantes:
	 * admin_enqueue_scripts (Pour appeller les scripts JS et CSS dans l'admin)
	 * wp_enqueue_script (Pour appeller les scripts JS et CSS dans le frontend)
	 *
	 * @since 1.0.0
	 * @version 1.0.0
	 */
	public function __construct() {
		add_action( 'admin_enqueue_scripts', array( $this, 'callback_mixed_enqueue_scripts' ), 9 );
		add_action( 'wp_enqueue_scripts', array( $this, 'callback_mixed_enqueue_scripts' ), 9 );
		add_action( 'init', array( $this, 'callback_plugins_loaded' ) );
	}

	/**
	 * Initialise les fichiers JS inclus dans WordPress (jQuery, wp.media et thickbox)
	 *
	 * @since 1.0.0
	 * @version 1.0.0
	 *
	 * @return void
	 */
	public function callback_mixed_enqueue_scripts() {
		wp_register_script( 'wpeo-assets-scripts', Config_Util::$init['eo-framework']->core->url . 'assets/js/dest/wpeo-assets.js', array( 'jquery' ), \eoxia\Config_Util::$init['eo-framework']->version, false );
		wp_enqueue_script( 'wpeo-assets-datepicker-js', Config_Util::$init['eo-framework']->core->url . 'assets/js/dest/jquery.datetimepicker.full.js', array( 'jquery' ), \eoxia\Config_Util::$init['eo-framework']->version, false );

		wp_enqueue_style( 'wpeo-font-awesome-free', Config_Util::$init['eo-framework']->core->url . 'assets/css/fontawesome/fontawesome-all.min.css', array(), \eoxia\Config_Util::$init['eo-framework']->version );
		wp_enqueue_style( 'wpeo-assets-styles', Config_Util::$init['eo-framework']->core->url . 'assets/css/style.min.css', \eoxia\Config_Util::$init['eo-framework']->version );
		wp_enqueue_style( 'wpeo-assets-datepicker', Config_Util::$init['eo-framework']->core->url . 'assets/css/jquery.datetimepicker.css', array(), \eoxia\Config_Util::$init['eo-framework']->version );

		wp_localize_script( 'wpeo-assets-scripts', 'wpeo_framework', $this->get_localize_script_data() );
		wp_enqueue_script( 'wpeo-assets-scripts' );
	}

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
		require \eoxia\Config_Util::$init['eo-framework']->path . 'core/view/modal.view.php';
		$view_modal = ob_get_clean();

		ob_start();
		require \eoxia\Config_Util::$init['eo-framework']->path . 'core/view/modal-title.view.php';
		$view_modal_title = ob_get_clean();

		ob_start();
		require \eoxia\Config_Util::$init['eo-framework']->path . 'core/view/modal-buttons.view.php';
		$view_modal_buttons = ob_get_clean();

		$data = array(
			'modalDefaultTitle'   => $view_modal_title,
			'modalView'           => $view_modal,
			'modalDefaultButtons' => $view_modal_buttons,
		);

		return $data;
	}

	/**
	 * Initialise le fichier MO
	 *
	 * @since 1.0.0
	 * @version 1.0.0
	 */
	public function callback_plugins_loaded() {
		$plugin_dir       = str_replace( '\\', '/', WP_PLUGIN_DIR );
		$full_plugin_path = str_replace( '\\', '/', \eoxia\Config_Util::$init['main']->full_plugin_path );
		$path             = str_replace( $plugin_dir, '', $full_plugin_path );
		load_plugin_textdomain( 'eoxia', false, $path . 'core/external/' . PLUGIN_EO_FRAMEWORK_DIR . '/core/assets/languages/' );
	}
}

new Core_Action();
