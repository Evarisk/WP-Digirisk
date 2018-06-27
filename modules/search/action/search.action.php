<?php
/**
 * Gestion des actions pour la recherche dans DigiRisk.
 *
 * @author    Evarisk <dev@evarisk.com>
 * @copyright (c) 2006-2018 Evarisk <dev@evarisk.com>.
 *
 * @license   AGPLv3 <https://spdx.org/licenses/AGPL-3.0-or-later.html>
 *
 * @package   DigiRisk\Classes
 *
 * @since     6.2.3
 */

namespace digi;

defined( 'ABSPATH' ) || exit;

/**
 * Search action class.
 */
class Search_Action {

	/**
	 * Le constructeur
	 *
	 * @since 6.2.3
	 */
	public function __construct() {
		add_action( 'wp_ajax_digi_search', array( $this, 'callback_digi_search' ) );
	}

	/**
	 * Appelle la méthode search de Search_Class pour récupérer la liste selon le critère $_GET['type']
	 * Si next_action est défini, appelle l'action pour gérer une action différente.
	 *
	 * @since 6.2.3
	 */
	public function callback_digi_search() {
		check_ajax_referer( 'digi_search' );

		$s           = ! empty( $_POST['s'] ) ? sanitize_text_field( wp_unslash( $_POST['s'] ) ) : ''; // WPCS: input var ok.
		$id          = ! empty( $_POST['id'] ) ? (int) $_POST['id'] : 0; // WPCS: input var ok.
		$type        = ! empty( $_POST['type'] ) ? sanitize_text_field( wp_unslash( $_POST['type'] ) ) : ''; // WPCS: input var ok.
		$next_action = ! empty( $_POST['next_action'] ) ? sanitize_text_field( wp_unslash( $_POST['next_action'] ) ) : ''; // WPCS: input var ok.

		$results = Search_Class::g()->search( array(
			'term' => $s,
			'type' => $type,
		) );

		if ( ! empty( $next_action ) ) {
			$results = do_action( $next_action, $id, $results );
		}

		if ( ! empty( $results ) ) {
			foreach ( $results as &$result ) {
				$result = User_Digi_Class::g()->get( array( 'id' => $result ), true );
			}
		}

		ob_start();
		\eoxia\View_Util::exec( 'digirisk', 'search', 'results', array(
			'results' => $results,
		) );

		wp_send_json_success( array(
			'view' => ob_get_clean(),
		) );
	}
}

new Search_Action();
