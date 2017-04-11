<?php
/**
 * Les actions relatives à la page "Risques"
 *
 * @author Jimmy Latour <jimmy@evarisk.com>
 * @since 1.0
 * @version 6.2.7.0
 * @copyright 2015-2017 Evarisk
 * @package risk
 * @subpackage action
 */

namespace digi;

if ( ! defined( 'ABSPATH' ) ) { exit; }

/**
 * Les actions relatives à la page "Risques"
 */
class Risk_Page_Action {

	/**
	 * Le constructeur
	 *
	 * @since 0.1
	 * @version 6.2.4.0
	 */
	public function __construct() {
		add_action( 'admin_menu', array( $this, 'callback_admin_menu' ), 12 );
		add_action( 'can_update', array( $this, 'callback_can_update' ), 10, 0 );

		add_action( 'wp_ajax_paginate_risk', array( $this, 'callback_paginate_risk' ) );
	}

	/**
	 * Définition du sous menu "Risques" dans le menu "Digirisk" de WordPress
	 *
	 * @since 1.0
	 * @version 6.2.7.0
	 */
	public function callback_admin_menu() {
		$hook = add_submenu_page( 'digirisk-simple-risk-evaluation', __( 'Risques', 'digirisk' ), __( 'Risques', 'digirisk' ), 'manage_digirisk', 'digirisk-handle-risk', array( Risk_Page_Class::g(), 'display' ), PLUGIN_DIGIRISK_URL . 'core/assets/images/favicon2.png', 4 );
		add_action( 'load-' . $hook, array( $this, 'callback_add_screen_option' ) );
	}

	/**
	 * Ajoutes le bouton "Option de l'écran" en haut de la page.
	 *
	 * @since 6.2.7.0
	 * @version 6.2.7.0
	 */
	public function callback_add_screen_option() {
		add_screen_option(
			'per_page',
			array(
				'label' 	=> _x( 'Risques', 'Risque par page' ),
				'default' => Risk_Page_Class::g()->limit_risk,
				'option' 	=> Risk_Page_Class::g()->option_name,
			)
		);
	}

	/**
	 * Vérifie que la variable $_POST "can_update" existe.
	 * Si celle-ci existe, et qu'elle est à "false", stop l'action AJAX pour ne pas modifier le risque
	 *
	 * @return void
	 *
	 * @since 1.0
	 * @version 6.2.4.0
	 */
	public function callback_can_update() {
		// Met à true si la variable $_POST "can_update" n'existe pas. Permet de continuer l'exécution de l'action AJAX.
		$can_update = isset( $_POST['can_update'] ) ? ( ( 'on' === $_POST['can_update'] ) ? true : '' ) : true;

		// Si la variable est à false, on stop l'action AJAX pour ne pas modifier le risque.
		if ( ! $can_update ) {
			wp_send_json_error();
		}
	}

	public function callback_paginate_risk() {
		ob_start();
		Risk_Page_Class::g()->display();
		wp_die( ob_get_clean() );
	}
}

new Risk_Page_Action();
