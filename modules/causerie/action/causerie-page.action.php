<?php
/**
 * Gestion des actions de la page principale des Causeries.
 *
 * @author    Evarisk <dev@evarisk.com>
 * @since     6.6.0
 * @version   6.6.0
 * @copyright 2018 Evarisk.
 * @package   DigiRisk
 */

namespace digi;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Gestion des actions de la page principale des Causeries.
 */
class Causerie_Page_Action {

	/**
	 * Le constructeur appelle une action personnalisée
	 */
	public function __construct() {
		add_action( 'admin_menu', array( $this, 'callback_admin_menu' ), 12 );

		add_action( 'wp_ajax_causerie_load_tab', array( $this, 'callback_causerie_load_tab' ) );
		add_action( 'wp_ajax_load_modal_participants', array( $this, 'callback_load_modal_participants' ) );

		add_action( 'admin_post_start_causerie', array( $this, 'callback_start_causerie' ) );

		add_action( 'wp_ajax_delete_started_causerie', array( $this, 'callback_delete_started_causerie' ) );
	}

	/**
	 * Ajoutes la page "Causerie" dans le sous menu "DigiRisk".
	 *
	 * @since   6.6.0
	 * @version 6.6.0
	 *
	 * @return  void
	 */
	public function callback_admin_menu() {
		add_submenu_page( 'digirisk-simple-risk-evaluation', __( 'Causeries', 'digirisk' ), __( 'Causeries', 'digirisk' ), 'manage_causerie', 'digirisk-causerie', array( Causerie_Page_Class::g(), 'display' ), PLUGIN_DIGIRISK_URL . 'core/assets/images/favicon2.png', 4 );
	}

	/**
	 * Gestion des onglets dans la page principale.
	 *
	 * Appel la function selon le slug $tab.
	 *
	 * @since   6.6.0
	 * @version 6.6.0
	 *
	 * @return  void
	 */
	public function callback_causerie_load_tab() {
		/*check_ajax_referer( 'causerie_load_tab' );
		$tab = ! empty( $_POST['tab'] ) ? sanitize_text_field( $_POST['tab'] ) : '';

		if ( empty( $tab ) ) {
			wp_send_json_error();
		}

		ob_start();
		call_user_func( array( Causerie_Page_Class::g(), 'display_' . $tab ) );
		wp_send_json_success( array(
			'view' => ob_get_clean(),
		) );*/
	}

	/**
	 * Charges la modal contenant le tableau des participants d'une causerie finalisée.
	 *
	 * Appel la vue contenant un tableau avec le nom, la date et la signature de tous les participants de la causerie.
	 *
	 * @since   6.6.0
	 * @version 6.6.0
	 *
	 * @return  void
	 */
	public function callback_load_modal_participants() {
		check_ajax_referer( 'load_modal_participants' );

		$id = ! empty( $_POST['id'] ) ? (int) $_POST['id'] : 0;

		if ( empty( $id ) ) {
			wp_send_json_error();
		}

		$causerie_intervention = Causerie_Intervention_Class::g()->get( array( 'id' => $id ), true );

		if ( ! empty( $causerie_intervention->participants ) ) {
			foreach ( $causerie_intervention->participants as &$participant ) {
				if ( ! empty( $participant['user_id'] ) ) {
					$participant['rendered'] = User_Class::g()->get( array( 'id' => $participant['user_id'] ), true );
				}
			}
		}

		ob_start();
		\eoxia\View_Util::exec( 'digirisk', 'causerie', 'dashboard/modal-participants-list', array(
			'causerie' => $causerie_intervention,
		) );

		wp_send_json_success( array(
			'view' => ob_get_clean(),
		) );
	}

	/**
	 * Dupliques la causerie sélectionnée.
	 *
	 * Effectue une redirection vers la page "single" de la nouvelle causerie créée.
	 *
	 * @since   6.6.0
	 * @version 6.6.0
	 *
	 * @return void
	 *
	 * @todo: FIXME 28/05/2018: nonce
	 */
	public function callback_start_causerie() {
		$id = ! empty( $_GET['id'] ) ? (int) $_GET['id'] : 0; // WPCS: input var ok.

		$causerie_intervention = Causerie_Intervention_Class::g()->duplicate( $id );

		wp_redirect( admin_url( 'admin.php?page=digirisk-causerie&id=' . $causerie_intervention->data['id'] ) );
	}

	/**
	 * Supprimes une causerie en cours.
	 *
	 * @since 7.3.0
	 */
	public function callback_delete_started_causerie() {
		check_ajax_referer( 'delete_started_causerie' );

		$id = ! empty( $_POST['id'] ) ? (int) $_POST['id'] : 0;

		if ( empty( $id ) ) {
			wp_send_json_error();
		}

		$causerie = Causerie_Intervention_Class::g()->get( array( 'id' => $id ), true );

		$causerie->data['status'] = 'trash';

		Causerie_Intervention_Class::g()->update( $causerie->data );

		wp_send_json_success( array(
			'namespace'        => 'digirisk',
			'module'           => 'causerie',
			'callback_success' => 'deletedStartedCauserie',
		) );
	}
}

new Causerie_Page_Action();
