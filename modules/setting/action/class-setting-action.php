<?php
/**
 * Les actions relatives aux réglages de DigiRisk.
 *
 * @author Evarisk <dev@evarisk.com>
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
	 */
	public function __construct() {
		add_action( 'admin_menu', array( $this, 'admin_menu' ) );
		add_action( 'admin_post_update_accronym', array( $this, 'callback_update_accronym' ) );
		add_action( 'wp_ajax_save_capability', array( $this, 'callback_save_capability' ) );

		add_action( 'display_setting_user', array( $this, 'callback_display_setting_user' ), 10, 2 );
		add_action( 'wp_ajax_paginate_setting_page_user', array( $this, 'callback_paginate_setting_page_user' ) );

		add_action( 'wp_ajax_save_general_settings_digirisk', array( $this, 'ajax_save_general_settings_digirisk' ) );

		add_action( 'wp_ajax_update_accronym', array( $this, 'callback_update_accronym' ) );

		add_action( 'display_user_capacity', array( $this, 'callback_display_user_capacity' ), 10, 1 );

		add_action( 'wp_ajax_save_htpasswd', array( $this, 'callback_save_htpasswd' ) );
	}

	/**
	 * La fonction de callback de l'action admin_menu de WordPress
	 *
	 * @since 6.0.0
	 */
	public function admin_menu() {
		$digirisk_core = get_option( \eoxia\Config_Util::$init['digirisk']->core_option );

		if ( ! empty( $digirisk_core['installed'] ) ) {
			add_options_page( 'Réglages', 'DigiRisk', 'manage_setting', 'digirisk-setting', array( $this, 'add_option_page' ) );
		}
	}

	/**
	 * Appelle la vue main du module setting avec la liste des accronymes
	 * et la liste des catégories de risque prédéfinies.
	 *
	 * @since 6.0.0
	 */
	public function add_option_page() {
		$default_tab = ! empty( $_GET['tab'] ) ? sanitize_text_field( $_GET['tab'] ) : 'digi-general'; // WPCS: var input ok.

		global $eo_search;

		$eo_search->register_search( 'user_list_capacity', array(
			'icon'        => 'fa-search',
			'type'        => 'user',
			'name'        => 'user_list',
			'next_action' => 'display_user_capacity',
		) );

		$general_options = get_option( \eoxia\Config_Util::$init['digirisk']->general_options, Setting_Class::g()->default_general_options );

		$list_accronym = get_option( \eoxia\Config_Util::$init['digirisk']->accronym_option );
		$list_accronym = ! empty( $list_accronym ) ? json_decode( $list_accronym, true ) : array();

		global $wpdb;

		$preset_risks_id = $wpdb->get_col(
			"SELECT RISK.ID FROM {$wpdb->posts} AS RISK
				JOIN {$wpdb->postmeta} AS RISK_META ON RISK.ID=RISK_META.post_id
			WHERE RISK_META.meta_key = '_wpdigi_preset'
				AND RISK_META.meta_value = 1" );

		$dangers_preset = array();

		if ( ! empty( $preset_risks_id ) ) {
			$dangers_preset = Risk_Class::g()->get( array(
				'post__in' => $preset_risks_id,
				'order'    => 'ASC',
			) );
		}

		// Retravaille l'ordre pour respecter celui de l'INRS.
		uasort( $dangers_preset, function( $a, $b ) {
			if ( $a->data['risk_category']->data['position'] === $b->data['risk_category']->data['position'] ) {
				return 0;
			}

			if ( $a->data['risk_category']->data['position'] > $b->data['risk_category']->data['position'] ) {
				return 1;
			}

			return 0;
		} );

		$can_edit_risk_category     = (bool) get_option( 'edit_risk_category', false );
		$can_edit_type_cotation     = (bool) get_option( 'edit_type_cotation', false );
		$require_unique_security_id = (bool) get_option( 'require_unique_security_id', false );
		$unique_security_id         = get_option( \eoxia\Config_Util::$init['digirisk']->child->security_id_key, false );
		$sites                      = get_option( \eoxia\Config_Util::$init['digirisk']->child->site_parent_key, array() );

		$prefix = Setting_Class::g()->get_all_prefix();

		foreach( $prefix as $element ){
			$list_accronym[ $element[ 'element' ] ] = array(
				'description' => $element[ 'title' ],
				'to'          => $element[ 'value' ],
				'element'     => $element[ 'element' ],
				'page'        => $element[ 'page' ]
			);
		}

		require PLUGIN_DIGIRISK_PATH . '/core/view/main-navigation.view.php';

		\eoxia\View_Util::exec( 'digirisk', 'setting', 'main', array(
			'list_accronym'              => $list_accronym,
			'dangers_preset'             => $dangers_preset,
			'default_tab'                => $default_tab,
			'can_edit_risk_category'     => $can_edit_risk_category,
			'can_edit_type_cotation'     => $can_edit_type_cotation,
			'require_unique_security_id' => $require_unique_security_id,
			'unique_security_id'         => $unique_security_id,
			'sites'                      => $sites,
			'general_options'            => $general_options
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
		check_ajax_referer( 'update_accronym' );
		$list_accronym = $_POST['list_accronym'];
		$list_prefix   = $_POST['list_prefix'];

		if ( ! empty( $list_accronym ) ) {
			foreach ( $list_accronym as &$element ) {
				$element['to']          = sanitize_text_field( $element['to'] );
				$element['description'] = sanitize_text_field( stripslashes( $element['description'] ) );
			}
		}
		update_option( \eoxia\Config_Util::$init['digirisk']->accronym_option, wp_json_encode( $list_accronym ) );

		Setting_Class::g()->save_prefix_settings_digirisk( $list_prefix );

		wp_send_json_success( array(
			'namespace'        => 'digirisk',
			'module'           => 'setting',
			'callback_success' => 'savePrefixSettingsDigiriskSuccess',
			'text_info'        => esc_html__( 'Sauvegardé avec succés', 'digirisk' )
		) );
	}

	/**
	 * Rajoutes la capacité "manager_digirisk" à tous les utilisateurs ou $have_capability est à true.
	 *
	 * @since 6.4.0
	 */
	public function callback_save_capability() {
		check_ajax_referer( 'save_capability' );

		if ( ! empty( $_POST['users'] ) ) {
			foreach ( $_POST['users'] as $user_id => $data ) {
				$user = new \WP_User( $user_id );

				if ( ! empty( $data['capability'] ) ) {
					foreach ( $data['capability'] as $key => $capability ) {
						$capability = $capability == 'true' ? true : false;
						if ( $capability ) {
							$user->add_cap( $key );
						} else {
							$user->remove_cap( $key );
						}
					}
				}


			}
		}

		wp_send_json_success( array(
			'namespace'        => 'digirisk',
			'module'           => 'setting',
			'callback_success' => 'savedCapability',
		) );
	}

	/**
	 * Méthode appelé par le champs de recherche dans la page "digirisk-epi"
	 *
	 * @param  integer $id L'ID de la société.
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
	 */
	public function callback_paginate_setting_page_user() {
		Setting_Class::g()->display_user_list_capacity();
		wp_die();
	}

	/**
	 * Sauvegardes le domaine de l'email dans la page "Digirisk" dans le menu "Utilisateurs" de WordPress.
	 *
	 * @since 6.0.0
	 */
	public function ajax_save_general_settings_digirisk() {
		check_ajax_referer( 'save_general_settings_digirisk' );

		$domain_mail                = ! empty( $_POST['domain_mail'] ) ? sanitize_text_field( $_POST['domain_mail'] ) : '';
		$can_edit_risk_category     = ( isset( $_POST['edit_risk_category'] ) && 'true' == $_POST['edit_risk_category'] ) ? true : false;
		$can_edit_type_cotation     = ( isset( $_POST['edit_type_cotation'] ) && 'true' == $_POST['edit_type_cotation'] ) ? true : false;
		$require_unique_security_id = ( isset( $_POST['require_unique_security_id'] ) && 'true' == $_POST['require_unique_security_id'] ) ? true : false;
		$general_data_options       = ! empty( $_POST['general_options'] ) ? (array) $_POST['general_options'] : array();

		$general_options = get_option( \eoxia\Config_Util::$init['digirisk']->general_options, Setting_Class::g()->default_general_options );

		if ( $require_unique_security_id ) {
			$security_id_key    = \eoxia\Config_Util::$init['digirisk']->child->security_id_key;
			$security_id_option = get_option( $security_id_key, false );

			if ( ! $security_id_option ) {
				$security_id = Child_Class::g()->generate_security_id();

				update_option( \eoxia\Config_Util::$init['digirisk']->child->security_id_key, array(
					'security_id' => $security_id,
					'used'        => false,
				) );
			}
		}

		update_option( 'digirisk_domain_mail', $domain_mail );
		update_option( 'edit_risk_category', $can_edit_risk_category );
		update_option( 'edit_type_cotation', $can_edit_type_cotation );
		update_option( 'require_unique_security_id', $require_unique_security_id );

		$general_options['required_duer_day'] = $general_data_options['required_duer_day'];

		update_option( \eoxia\Config_Util::$init['digirisk']->general_options, $general_options );

		wp_send_json_success( array(
			'namespace'        => 'digirisk',
			'module'           => 'setting',
			'callback_success' => 'generalSettingsSaved',
			'url'              => admin_url( 'options-general.php?page=digirisk-setting' ),
		) );
	}

	/**
	 * Méthode appelé par le champs de recherche des utilisateurs dans les
	 * réglages.
	 *
	 * @since 7.5.0
	 *
	 * @param array $data
	 */
	public function callback_display_user_capacity( $data ) {
		$list_user_id = array();

		if ( ! empty( $data['users'] ) ) {
			foreach ( $data['users'] as $key => &$user ) {
				$list_user_id[] = $user->data['id'];
			}
		}

		ob_start();
		Setting_Class::g()->display_user_list_capacity( $list_user_id );
		wp_send_json_success( array(
			'view'   => ob_get_clean(),
			'output' => '.settings-users-content',
		) );
	}

	public function callback_save_htpasswd() {
		$login     = ! empty( $_POST['login'] ) ? sanitize_text_field( $_POST['login'] ) : '';
		$password  = ! empty( $_POST['password'] ) ? sanitize_text_field( $_POST['password'] ) : '';
		$rpassword = ! empty( $_POST['repeat_password'] ) ? sanitize_text_field( $_POST['repeat_password'] ) : '';

		$error_message = '';

		if ( empty( $login ) || empty( $password ) || empty( $rpassword ) ) {
			$error_message = __( 'Tous les champs doivent être renseignés.', 'digirisk' );
		}

		if ( $password != $rpassword ) {
			$error_message = __( 'Les mots de passe ne sont pas identique.', 'digirisk' );
		}

		if ( ! empty( $error_message ) ) {
			$error_message .= __( ' Aucune modification n\'a était apporté', 'digirisk' );
		} else {
			$content_htaccess_to_add = 'AuthName "Veuillez-vous identifiez"
			AuthType Basic
			AuthUserFile "' . get_home_path() . '.htpasswd"
			Require valid-user';
			$htaccess_info = Setting_Class::g()->get_htaccess_info();

			// Check if htaccess have Auth Basic line
			$htaccess_file         = fopen( $htaccess_info['htaccess_path'], "r" );
			$htaccess_file_content = fread( $htaccess_file, filesize( $htaccess_info['htaccess_path'] ) );
			fclose( $htaccess_file );

			if ( ! strpos( $htaccess_file_content, 'AuthType Basic' ) ) {
				// Add line.
				file_put_contents( $htaccess_info['htaccess_path'], PHP_EOL . $content_htaccess_to_add, FILE_APPEND );
			}

			$password = crypt_apr1_md5( $password );

			$new_content = $login . ':' . $password;
			$fh = fopen( get_home_path() . '.htpasswd', 'w' );
			fwrite( $fh, $new_content );
			fclose($fh);
		}

		ob_start();
		Setting_Class::g()->display_htpasswd( $error_message );
		wp_send_json_success( array(
			'view'             => ob_get_clean(),
			'namespace'        => 'digirisk',
			'module'           => 'setting',
			'callback_success' => 'savedHtpasswd',
		) );
	}
}

new Setting_Action();
