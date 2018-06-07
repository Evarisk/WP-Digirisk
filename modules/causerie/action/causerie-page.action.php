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

		add_action( 'admin_post_start_causerie', array( $this, 'callback_start_causerie' ) );
	}

	public function callback_admin_menu() {
		add_submenu_page( 'digirisk-simple-risk-evaluation', __( 'Causeries', 'digirisk' ), __( 'Causeries', 'digirisk' ), 'manage_digirisk', 'digirisk-causerie', array( Causerie_Page_Class::g(), 'display' ), PLUGIN_DIGIRISK_URL . 'core/assets/images/favicon2.png', 4 );
	}

	/**
	 * Dupliques la causerie sélectionné puis appel la vue suivante.
	 *
	 * @since 6.6.0
	 * @version 6.6.0
	 *
	 * @return void
	 *
	 * @todo: FIXME 28/05/2018: nonce
	 */
	public function callback_start_causerie() {
		$id = ! empty( $_GET['id'] ) ? (int) $_GET['id'] : 0;

		$causerie_intervention = Causerie_Intervention_Class::g()->duplicate( $id );

		wp_redirect( admin_url( 'admin.php?page=digirisk-causerie&id=' . $causerie_intervention->id . '&step=1' ) );
	}

}

new Causerie_Page_Action();
