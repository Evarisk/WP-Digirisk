<?php
/**
 * Classe gérant les actions principales de DigiRisk.
 *
 * Elle ajoute les styles et scripts JS principaux pour le bon fonctionnement de DigiRisk.
 * Elle ajoute également les textes de traductions (fichiers .mo)
 * Elle déclare la page principale "DigiRisk".
 *
 * @author    Evarisk <dev@evarisk.com>
 * @copyright (c) 2006 2018 Evarisk <dev@evarisk.com>.
 *
 * @license   AGPLv3 <https://spdx.org/licenses/AGPL-3.0-or-later.html>
 *
 * @package   DigiRisk\Classes
 *
 * @since     6.0.0
 */

namespace digi;

defined( 'ABSPATH' ) || exit;
use \eoxia\Custom_Menu_Handler as CMH;


/**
 * Classe gérant les actions principales de l'application.
 */
class Digirisk_Action {

	/**
	 * Constructeur.
	 *
	 * @since 7.0.0
	 */
	public function __construct() {
		$page = ( ! empty( $_REQUEST['page'] ) ) ? sanitize_text_field( wp_unslash( $_REQUEST['page'] ) ) : ''; // WPCS: input var ok, CSRF ok.
		if ( in_array( $page, \eoxia\Config_Util::$init['digirisk']->insert_scripts_pages_css, true ) ) {
			add_action( 'admin_enqueue_scripts', array( $this, 'callback_before_admin_enqueue_scripts_css' ), 10 );
			add_action( 'admin_enqueue_scripts', array( $this, 'callback_admin_enqueue_scripts_css' ), 11 );
			add_action( 'admin_print_scripts', array( $this, 'callback_admin_print_scripts_css' ) );
		}
			if ( in_array( $page, \eoxia\Config_Util::$init['digirisk']->insert_scripts_pages_js, true ) ) {
			add_action( 'admin_enqueue_scripts', array( $this, 'callback_before_admin_enqueue_scripts_js' ), 10 );
			add_action( 'admin_enqueue_scripts', array( $this, 'callback_admin_enqueue_scripts_js' ), 11 );
			add_action( 'admin_print_scripts', array( $this, 'callback_admin_print_scripts_js' ) );
		}

		add_action( 'admin_enqueue_scripts', array( $this, 'callback_before_admin_enqueue_scripts_js_global' ), 10 );
		add_action( 'init', array( $this, 'callback_plugins_loaded' ), 1 );
		add_action( 'admin_menu', array( $this, 'callback_admin_menu' ), 12 );
		add_action( 'admin_init', array( $this, 'redirect_to' ) );

		add_action( 'wp_ajax_have_patch_note', array( $this, 'have_patch_note' ) );
		add_action( 'wp_ajax_close_change_log', array( $this, 'callback_close_change_log' ) );

		add_action( 'switch_to_user', array( $this, 'switch_to' ), 10, 4 );
		add_action( 'switch_back_user', array( $this, 'switch_back' ), 10, 4 );

		add_action( 'wp_ajax_set_default_app', array( $this, 'set_default_app' ) );
	}

	/**
	 * Initialise les fichiers JS inclus dans WordPress (jQuery, wp.media et thickbox)
	 *
	 * @since 6.0.0
	 */
	public function callback_before_admin_enqueue_scripts_js() {
		wp_enqueue_script( 'jquery');
		wp_enqueue_script( 'jquery-form' );
		wp_enqueue_script( 'jquery-ui-sortable' );
		wp_enqueue_script( 'jquery-ui-accordion' );
		wp_enqueue_script( 'jquery-ui-autocomplete' );
		wp_enqueue_script( 'jquery-ui-draggable' );
		wp_enqueue_script( 'jquery-ui-droppable' );
		wp_enqueue_media();
		add_thickbox();
	}

	/**
	 * Initialise le fichier style.min.css et backend.min.js du plugin DigiRisk.
	 *
	 * @since 6.0.0

	 */
	public function callback_admin_enqueue_scripts_js() {
		wp_enqueue_script( 'signature-pad', PLUGIN_DIGIRISK_URL . 'core/assets/js/signature-pad.min.js', array( 'jquery' ), \eoxia\Config_Util::$init['digirisk']->version, false );
		wp_enqueue_script( 'digi-autosize-script', PLUGIN_DIGIRISK_URL . 'core/assets/js/autosize.min.js', array(), \eoxia\Config_Util::$init['digirisk']->version, false );
		wp_enqueue_script( 'digi-script', PLUGIN_DIGIRISK_URL . 'core/assets/js/backend.min.js', array(), \eoxia\Config_Util::$init['digirisk']->version, false );
		wp_enqueue_script( 'digi-script-owl-carousel', PLUGIN_DIGIRISK_URL . 'core/assets/js/owl.carousel.min.js', array(), \eoxia\Config_Util::$init['digirisk']->version, false );
		wp_enqueue_script( 'digi-script-treetable', PLUGIN_DIGIRISK_URL . 'core/assets/js/jquery.treetable.js', array(), \eoxia\Config_Util::$init['digirisk']->version, false );
	}

	/**
	 * Initialise en php le fichier permettant la traduction des variables string JavaScript.
	 *
	 * @since 6.0.0
	 */
	public function callback_admin_print_scripts_js() {
		require PLUGIN_DIGIRISK_PATH . '/core/assets/js/define-string.js.php';
	}

	/**
	 * Initialise les fichiers JS inclus dans WordPress (jQuery, wp.media et thickbox)
	 *
	 * @since 6.0.0
	 */
	public function callback_before_admin_enqueue_scripts_css() {}

	/**
	 * Initialise le fichier style.min.css et backend.min.js du plugin DigiRisk.
	 *
	 * @since 6.0.0
	 */
	public function callback_admin_enqueue_scripts_css() {
		wp_enqueue_style( 'digi-style', PLUGIN_DIGIRISK_URL . 'core/assets/css/style.css', array(), \eoxia\Config_Util::$init['digirisk']->version );
		wp_enqueue_style( 'digi-treetable', PLUGIN_DIGIRISK_URL . 'core/assets/css/jquery.treetable.css', array(), \eoxia\Config_Util::$init['digirisk']->version );
		wp_enqueue_style( 'digi-treetable-default', PLUGIN_DIGIRISK_URL . 'core/assets/css/jquery.treetable.theme.default.css', array(), \eoxia\Config_Util::$init['digirisk']->version );
		wp_enqueue_style( 'digi-owl-carousel', PLUGIN_DIGIRISK_URL . 'core/assets/css/owl.carousel.min.css', array(), \eoxia\Config_Util::$init['digirisk']->version );
	}

	/**
	 * Initialise en php le fichier permettant la traduction des variables string JavaScript.
	 *
	 * @since 6.0.0
	 */
	public function callback_admin_print_scripts_css() {}

	/**
	 * Initialise le fichier MO
	 * Initialise les capabilities des roles.
	 *
	 * @since 6.0.0
	 */
	public function callback_plugins_loaded() {
		if( isset( \eoxia\Config_Util::$init['task-manager'] ) ){
			\eoxia\Config_Util::$init['task-manager']->insert_scripts_pages[] = 'digirisk-causerie';
			\eoxia\Config_Util::$init['task-manager']->insert_scripts_pages[] = 'digirisk_page_digirisk-du';
		}

		load_plugin_textdomain( 'digirisk', false, PLUGIN_DIGIRISK_DIR . '/core/assets/languages/' );

		$cap_init = get_option( 'digi_cap_init' );

		if ( ! empty( \eoxia\Config_Util::$init['digirisk']->default_capabilities ) && ! $cap_init ) {
			foreach ( \eoxia\Config_Util::$init['digirisk']->default_capabilities as $role => $capabilities ) {
				$wp_role = get_role( $role );

				if ( $wp_role ) {
					if ( ! empty( $capabilities ) ) {
						foreach ( $capabilities as $capability ) {
							if ( $wp_role && ! $wp_role->has_cap( $capability ) ) {
								$wp_role->add_cap( $capability );
							}
						}
					}
				}
			}
			update_option( 'digi_cap_init', true );
		}
	}

	/**
	 * Définition du menu dans l'administration de WordPress pour Digirisk
	 *
	 * @since 6.0.0
	 */
	public function callback_admin_menu() {
		$digirisk_core = get_option( \eoxia\Config_Util::$init['digirisk']->core_option );


		if ( ! empty( $digirisk_core['installed'] ) ) {
			CMH::register_container( 'DigiRisk', 'DigiRisk', 'read', 'digirisk', '', PLUGIN_DIGIRISK_URL . '/core/assets/images/favicon2.png', 21 );
			CMH::add_logo( 'digirisk', PLUGIN_DIGIRISK_URL . '/core/assets/images/favicon_hd.png', admin_url( 'admin.php?page=digirisk' ) );
			CMH::register_menu( 'digirisk', __( 'Bienvenue sur DigiRisk', 'digirisk' ), __( 'DigiRisk', 'digirisk' ), 'read', 'digirisk', array( Digirisk::g(), 'display' ), 'fa fa-home', 'bottom' );
			CMH::register_others_menu( 'others', 'digirisk-dashboard', __( 'DigiRisk', 'digirisk' ), __( 'DigiRisk', 'digirisk' ), 'read', 'digirisk', array( Digirisk::g(), 'display' ), PLUGIN_DIGIRISK_URL . '/core/assets/images/favicon_hd.png', 'bottom' );
		}
	}

	/**
	 * Permet de redirigé l'utilisateur vers la page de DigiRisk.
	 *
	 * @since 7.5.0
	 */
	public function redirect_to() {
		$user_information = get_the_author_meta( 'digirisk_user_information_meta', get_current_user_id() );
		$auto_connect     = isset( $user_information['auto_connect'] ) ? $user_information['auto_connect'] : false;

		if ( $auto_connect ) {
			$_pos = strlen($_SERVER['REQUEST_URI']) - strlen('/wp-admin/');

			if (strpos($_SERVER['REQUEST_URI'], '/wp-admin/') !== false && strpos($_SERVER['REQUEST_URI'], '/wp-admin/') == $_pos) {
				$digirisk_core = get_option(\eoxia\Config_Util::$init['digirisk']->core_option);

				if ( ! empty( $digirisk_core['installed'] ) ) {
					wp_redirect( admin_url( 'admin.php?page=digirisk' ) );
				} else {
					wp_redirect( admin_url( 'admin.php?page=digi-setup' ) );
				}

				die();
			}
		}
	}

	public function have_patch_note() {
		$result = DigiRisk::g()->get_patch_note();

		ob_start();
		require PLUGIN_DIGIRISK_PATH . '/core/view/patch-note.view.php';
		wp_send_json_success( array(
			'status'  => false,//$result['status'],
			'result'  => $result,
			'view'    => ob_get_clean(),
		) );
	}

	/**
	 * Lors de la fermeture de la notification de la popup.
	 * Met la metadonnée '_wpdigi_user_change_log' avec le numéro de version actuel à true.
	 *
	 * @since 6.0.0
	 */
	public function callback_close_change_log() {
		check_ajax_referer( 'close_change_log' );

		$version = ! empty( $_POST['version'] ) ? sanitize_text_field( wp_unslash( $_POST['version'] ) ) : ''; // WPCS: input var ok.

		if ( empty( $version ) ) {
			wp_send_json_error();
		}

		$meta = get_user_meta( get_current_user_id(), '_wpdigi_user_change_log', true );

		if ( empty( $meta ) ) {
			$meta = array();
		}

		$meta[ $version ] = true;
		update_user_meta( get_current_user_id(), '_wpdigi_user_change_log', $meta );

		wp_send_json_success();
	}

	public function callback_before_admin_enqueue_scripts_js_global(){
		$screen = get_current_screen();
		wp_enqueue_script( 'digirisk-chart', 'https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.7.3/Chart.min.js' );
		if( isset( \eoxia\Config_Util::$init['task-manager'] ) ){
			wp_enqueue_script( 'digirisk-user-page', PLUGIN_DIGIRISK_URL . 'modules/user/asset/js/user.page.js', array(), \eoxia\Config_Util::$init['digirisk']->version );
		}
	}

	public function switch_to( $user_id, $old_user_id, $new_token, $old_token ) {
		wp_redirect( admin_url( 'admin.php?page=digirisk' ) );
		exit;
	}

	public function switch_back( $user_id, $old_user_id, $new_token, $old_token ) {
		wp_redirect( admin_url('admin.php?page=digirisk' ) );
		exit;
	}

	public function set_default_app() {
		$ask_again   = ( isset( $_POST['ask_again'] ) && 'on' == $_POST['ask_again'] ) ? true : false;
		$set_default = ( isset( $_POST['set_default'] ) && 'true' == $_POST['set_default'] ) ? true : false;

		if ( $set_default ) {
			$ask_again = false;
		}

		$user_information = get_the_author_meta( 'digirisk_user_information_meta', get_current_user_id() );
		if ( empty( $user_information ) ) {
			$user_information = array();
		}

		$user_information['auto_connect']     = $set_default;
		$user_information['ask_auto_connect'] = $ask_again;

		update_user_meta( get_current_user_id(), 'digirisk_user_information_meta', $user_information );
		wp_send_json_success( array(
			'namespace'        => 'digirisk',
			'module'           => 'core',
			'callback_success' => 'settedDefaultApp',
		));
	}
}

new Digirisk_Action();
