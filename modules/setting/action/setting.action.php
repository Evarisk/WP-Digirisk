<?php
/**
 * Les actions relatives aux réglages de DigiRisk.
 *
 * @author Jimmy Latour <jimmy@evarisk.com>
 * @since 6.0.0
 * @version 6.4.0
 * @copyright 2015-2017 Evarisk
 * @package DigiRisk
 */

namespace digi;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Les actions relatives aux réglages de DigiRisk.
 */
class Setting_Action {

	/**
	 * Le constructeur
	 *
	 * @since 6.0.0
	 * @version 6.4.0
	 */
	public function __construct() {
		add_action( 'admin_menu', array( $this, 'admin_menu' ) );
		add_action( 'admin_post_update_accronym', array( $this, 'callback_update_accronym' ) );
		add_action( 'wp_ajax_save_capability', array( $this, 'callback_save_capability' ) );

		add_action( 'display_setting_user', array( $this, 'callback_display_setting_user' ), 10, 2 );
		add_action( 'wp_ajax_paginate_setting_page_user', array( $this, 'callback_paginate_setting_page_user' ) );
	}

	/**
	 * La fonction de callback de l'action admin_menu de WordPress
	 *
	 * @return void
	 *
	 * @since 6.0.0
	 * @version 6.3.0
	 */
	public function admin_menu() {
		add_options_page( 'DigiRisk', 'DigiRisk', 'manage_digirisk', 'digirisk-setting', array( $this, 'add_option_page' ) );
	}

	/**
	 * Appelle la vue main du module setting avec la liste des accronymes
	 * et la liste des catégories de risque prédéfinies.
	 *
	 * @since 6.0.0
	 * @version 6.4.0
	 */
	public function add_option_page() {
		$default_tab = ! empty( $_GET['tab'] ) ? sanitize_text_field( $_GET['tab'] ) : 'digi-capability';

		$list_accronym = get_option( \eoxia\Config_Util::$init['digirisk']->accronym_option );
		$list_accronym = ! empty( $list_accronym ) ? json_decode( $list_accronym, true ) : array();

		global $wpdb;

		$preset_risks_id = $wpdb->get_col(
			"SELECT RISK.ID FROM {$wpdb->posts} AS RISK
				JOIN {$wpdb->postmeta} AS RISK_META ON RISK.ID=RISK_META.post_id
			WHERE RISK.post_status != 'trash'
				AND RISK_META.meta_key = '_wpdigi_preset'
				AND RISK_META.meta_value = 1" );

		$dangers_preset = Risk_Class::g()->get( array(
			'include' => $preset_risks_id,
			'order' => 'ASC',
		) );

		// Retravaille l'ordre pour respecter celui de l'INRS.
		uasort( $dangers_preset, function( $a, $b ) {
			if ( $a->risk_category->position === $b->risk_category->position ) {
				return 0;
			}

			if ( $a->risk_category->position > $b->risk_category->position ) {
				return 1;
			}

			return 0;
		} );

		\eoxia\View_Util::exec( 'digirisk', 'setting', 'main', array(
			'list_accronym' => $list_accronym,
			'dangers_preset' => $dangers_preset,
			'default_tab' => $default_tab,
		) );
	}

	/**
	 * Met à jour la liste des acronymes reçu par le formulaire.
	 *
	 * @return void
	 *
	 * @since 6.0.0
	 * @version 6.2.9
	 */
	public function callback_update_accronym() {
		$list_accronym = $_POST['list_accronym'];

		if ( ! empty( $list_accronym ) ) {
			foreach ( $list_accronym as &$element ) {
				$element['to'] = sanitize_text_field( $element['to'] );
				$element['description'] = sanitize_text_field( stripslashes( $element['description'] ) );
			}
		}

		update_option( \eoxia\Config_Util::$init['digirisk']->accronym_option, wp_json_encode( $list_accronym ) );
		wp_safe_redirect( admin_url( 'options-general.php?page=digirisk-setting&tab=digi-accronym' ) );
	}

	/**
	 * Rajoutes la capacité "manager_digirisk" à tous les utilisateurs ou $have_capability est à true.
	 *
	 * @since 6.4.0
	 * @version 6.4.0
	 *
	 * @return void
	 */
	public function callback_save_capability() {
		check_ajax_referer( 'save_capability' );

		if ( ! empty( $_POST['users'] ) ) {
			foreach ( $_POST['users'] as $user_id => $data ) {
				$user = new \WP_User( $user_id );

				if ( 'true' == $data['capability'] ) {
					$user->add_cap( 'manage_digirisk' );
				} else {
					$user->remove_cap( 'manage_digirisk' );
				}
			}
		}

		wp_send_json_success( array(
			'namespace' => 'digirisk',
			'module' => 'setting',
			'callback_success' => 'savedCapability',
		) );
	}

	/**
	 * Méthode appelé par le champs de recherche dans la page "digirisk-epi"
	 *
	 * @param  integer $id           L'ID de la société.
	 * @param  array   $list_user_id Le tableau des ID des évaluateurs trouvés par la recherche.
	 * @return void
	 *
	 * @since 6.4.0
	 * @version 6.4.0
	 */
	public function callback_display_setting_user( $id, $list_user_id ) {
		ob_start();
		Setting_Class::g()->display_user_list_capacity( $list_user_id );

		wp_send_json_success( array(
			'template' => ob_get_clean(),
		) );
	}

	/**
	 * Gestion de la pagination
	 *
	 * @since 6.4.0
	 * @version 6.4.0
	 *
	 * @return void
	 */
	public function callback_paginate_setting_page_user() {
		Setting_Class::g()->display_user_list_capacity();
		wp_die();
	}
}

new Setting_Action();
