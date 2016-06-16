<?php if ( !defined( 'ABSPATH' ) ) exit;
/**
 * Fichier du controller pour installer digirisk
 *
 * @author Evarisk development team <dev@evarisk.com>
 * @version 6.0
 */

/**
 * Fichier du controller pour installer digirisk
 *
 * @author Evarisk development team <dev@evarisk.com>
 * @version 6.0
 */
class wpdigi_installer_action_01 extends wp_digirisk_installer {

	/**
	 * CORE - Instanciation des actions ajax pour l'installer
	 */
	public function __construct() {
		add_action( 'wp_ajax_wpdigi-installer-step-1', array( $this, 'ajax_installer_step_1' ) );

		add_action( 'wp_ajax_wpdigi-installer-add-user', array( $this, 'ajax_installer_add_user' ) );
		add_action( 'wp_ajax_wpdigi-installer-load-user', array( $this, 'ajax_installer_load_user' ) );
		add_action( 'wp_ajax_wpdigi-installer-edit-user', array( $this, 'ajax_installer_edit_user' ) );
		add_action( 'wp_ajax_wpdigi-installer-delete-user', array( $this, 'ajax_installer_delete_user' ) );

		add_action( 'admin_post_wpdigi-installer-import-staff', array( $this, 'admin_post_installer_import_staff' ) );

		add_action( 'wp_ajax_save_domain_mail', array( $this, 'ajax_save_domain_mail' ) );

		add_action( 'admin_post_last_step', array( $this, 'admin_post_last_step' ) );
	}

	public function ajax_installer_step_1() {
		wpdigi_utils::check( 'ajax_installer_step_1' );

		$post_code = '';

		if ( !empty( $_POST['address']['postcode'] ) ) {
			$postcode = (int) $_POST['address']['postcode'];
			if ( strlen( $postcode ) > 5 )
				$postcode = substr( $postcode, 0, 5 );
		}

		$date = date( 'Y-m-d', strtotime( str_replace( '/', '-', sanitize_text_field( $_POST['groupement']['date'] ) ) ) );

		global $wpdigi_address_ctr;
		$address = array(
			'date' => $date,
			'option' => array(
				'address' => sanitize_text_field( $_POST['address']['address'] ),
				'additional_address' => sanitize_text_field( $_POST['address']['additional_address'] ),
				'postcode' => $postcode,
				'town' => sanitize_text_field( $_POST['address']['town'] ),
			),
		);
		$address = $wpdigi_address_ctr->create( $address );

		global $wpdigi_group_ctr;
		// On récupère le last unique key
		$last_unique_key = wpdigi_utils::get_last_unique_key( 'post', $wpdigi_group_ctr->get_post_type() );
		$last_unique_key++;
		if ( empty( $last_unique_key ) ) $last_unique_key = 1;

		$groupment = array(
			'title' => sanitize_text_field( $_POST['groupement']['title'] ),
			'content' => sanitize_text_field( $_POST['groupement']['content'] ),
			'date' => $date,
			'option' => array(
				'unique_key' => $last_unique_key,
				'unique_identifier' => $wpdigi_group_ctr->element_prefix . $last_unique_key,
				'identity' => array(
					'siren' => sanitize_text_field( $_POST['groupement']['option']['identity']['siren'] ),
					'siret' => sanitize_text_field( $_POST['groupement']['option']['identity']['siret'] ),
				),
				'contact' => array(
					'phone' => array( sanitize_text_field( $_POST['groupement']['option']['contact']['phone'] ) ),
					'address' => array( $address->id ),
				),
			),
		);

		if ( !empty( $_POST['owner_id'] ) ) {
      $owner_id = (int) $_POST['owner_id'];
      $groupment->option['user_info']['owner_id'] = $owner_id;
    }

		$groupement = $wpdigi_group_ctr->create( $groupment );

		/** On crée les dangers */
		global $wpdigi_danger_ctr;
		$wpdigi_danger_ctr->create_default_data();

		global $digi_recommendation_controller;
		$digi_recommendation_controller->create_default_data();
		//
		global $wpdigi_evaluation_method_controller;
		$wpdigi_evaluation_method_controller->create_default_data();

		/** Définition des modèles de documents / Define document model to use */
		$document_controller_01 = new document_controller_01();
		$document_controller_01->set_default_document( WPDIGI_PATH . 'core/assets/document_template/document_unique.odt', 'document_unique' );
		$document_controller_01->set_default_document( WPDIGI_PATH . 'core/assets/document_template/fiche_de_poste.odt', 'fiche_de_poste' );

		// Met à jours l'option pour dire que l'installation est terminée
		update_option( WPDIGI_CORE_OPTION_NAME, array( 'installed' => true, 'db_version' => 1 ) );

		wp_send_json_success();
	}

	public function ajax_installer_add_user() {
		wpdigi_utils::check( 'ajax_installer_add_user' );

		global $wpdigi_user_ctr;

		$user = array(
			'email' => sanitize_email( $_POST['user']['email'] ),
			'option' => array(
				'user_info' => array(
					'lastname' => sanitize_text_field( $_POST['user']['option']['user_info']['lastname'] ),
					'firstname' => sanitize_text_field( $_POST['user']['option']['user_info']['firstname'] ),
				)
			),
		);

		$user['login'] = trim( strtolower( remove_accents( sanitize_user( $user['option']['user_info']['firstname'] . '.' . $user['option']['user_info']['lastname'] ) ) ) );

		$user = $wpdigi_user_ctr->create( $user );

		ob_start();
		require_once( wpdigi_utils::get_template_part( DIGI_INSTAL_DIR, DIGI_INSTAL_TEMPLATES_MAIN_DIR, 'backend', 'list', 'item' ) );
		wp_send_json_success( array( 'template' => ob_get_clean() ) );
	}

	public function ajax_installer_load_user() {
		if ( 0 === (int)$_POST['user_id'] )
			wp_send_json_error( );
		else
			$user_id = (int)$_POST['user_id'];

		wpdigi_utils::check( 'ajax_installer_load_user_' . $user_id );

		global $wpdigi_user_ctr;

		$user = $wpdigi_user_ctr->show( $user_id );

		ob_start();
		require_once( wpdigi_utils::get_template_part( DIGI_INSTAL_DIR, DIGI_INSTAL_TEMPLATES_MAIN_DIR, 'backend', 'list-item-edit' ) );
		$template = ob_get_clean();

		wp_send_json_success( array( 'template' => $template ) );
	}

	public function ajax_installer_edit_user() {
		if ( 0 === (int)$_POST['user_id'] )
			wp_send_json_error( );
		else
			$user_id = (int)$_POST['user_id'];

		wpdigi_utils::check( 'ajax_installer_edit_user_' . $user_id );

		global $wpdigi_user_ctr;

		$user = $wpdigi_user_ctr->show( $user_id );

		$user->email = sanitize_email( $_POST['user']['email'] );
		$user->option['user_info']['lastname'] = sanitize_text_field( $_POST['user']['option']['user_info']['lastname'] );
		$user->option['user_info']['firstname'] = sanitize_text_field( $_POST['user']['option']['user_info']['firstname'] );
		$user->login = trim( strtolower( remove_accents( sanitize_user( $user->option['user_info']['firstname'] . '.' . $user->option['user_info']['lastname'] ) ) ) );

		$user = $wpdigi_user_ctr->update( $user );

		ob_start();
		require_once( wpdigi_utils::get_template_part( DIGI_INSTAL_DIR, DIGI_INSTAL_TEMPLATES_MAIN_DIR, 'backend', 'list', 'item' ) );
		wp_send_json_success( array( 'template' => ob_get_clean() ) );
	}

	public function ajax_installer_delete_user() {
		if ( 0 === (int)$_POST['user_id'] )
			wp_send_json_error();
		else
			$user_id = (int)$_POST['user_id'];

		wpdigi_utils::check( 'ajax_installer_delete_user_' . $user_id );

		global $wpdigi_user_ctr;

		$wpdigi_user_ctr->delete( $user_id );

		wp_send_json_success();
	}

	public function ajax_save_domain_mail() {
		check_ajax_referer( 'save_domain_mail' );

		$domain_mail = !empty( $_POST['domain_mail'] ) ? sanitize_text_field( $_POST['domain_mail'] ) : '';

		if ( $domain_mail === '' ) {
			wp_send_json_error();
		}

		update_option( 'digirisk_domain_mail', $domain_mail );

		wp_send_json_success();
	}

	public function admin_post_installer_import_staff() {
		if ( ( empty( $_FILES ) || empty( $_FILES['csv' ] ) || $_FILES['csv']['error'] != 0 ) && empty( $_POST['content_csv'] ) )
			wp_safe_redirect( admin_url( 'users.php?page=digirisk-users' ) );

		global $wpdigi_user_ctr;

		if ( !empty( $_POST['content_csv'] ) ) {
			$content_csv = preg_split('/\r\n|[\r\n]/', $_POST['content_csv'] );

			if ( !empty( $content_csv ) ) {
			  foreach ( $content_csv as $csv ) {
					$data = explode( ';', $csv );
					$wpdigi_user_ctr->add_user( $data );
			  }
			}
		}
		else {
			$wpdigi_user_ctr->open_csv( $_FILES['csv']['tmp_name'] );
		}

		wp_safe_redirect( admin_url( 'users.php?page=digirisk-users' ) );
	}

	public function admin_post_last_step() {
		if( empty( $_GET['_wpnonce'] ) ) {
			wp_safe_redirect( wp_get_referer() );
			die();
		}
		$wpnonce = sanitize_text_field( $_GET['_wpnonce'] );

		if ( !wp_verify_nonce( $wpnonce, 'last_step' ) ) {
			wp_safe_redirect( admin_url( 'users.php?page=digirisk-users' ) );
		}

		wp_safe_redirect( admin_url( 'users.php?page=digirisk-users' ) );
	}
}

new wpdigi_installer_action_01();
