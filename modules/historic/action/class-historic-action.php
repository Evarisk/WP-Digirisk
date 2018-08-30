<?php
/**
 * Classe gérant les actions des historiques.
 *
 * Gères également l'historique des cotations des risques.
 *
 * @author    Evarisk <dev@evarisk.com>
 * @copyright (c) 2006 2018 Evarisk <dev@evarisk.com>.
 *
 * @license   AGPLv3 <https://spdx.org/licenses/AGPL-3.0-or-later.html>
 *
 * @package   DigiRisk\Classes
 *
 * @since     6.2.1
 */

namespace digi;

defined( 'ABSPATH' ) || exit;

/**
 * Historic Action class.
 */
class Historic_Action {

	/**
	 * Le constructeur.
	 *
	 * @since 6.2.10
	 */
	public function __construct() {
		add_action( 'digi_add_historic', array( $this, 'callback_add_historic' ), 10, 1 );
		add_action( 'wp_ajax_historic_risk', array( $this, 'callback_historic_risk' ) );
	}

	/**
	 * Enregistres dans la base de donnée les données de $data qui doivent
	 * réspecter obligatoirement le schéma suivant:
	 * - parent ID
	 * - ID
	 * - Contenu
	 *
	 * @since 6.2.10
	 *
	 * @param array $data Un tableau respectant le format ci-dessus.
	 */
	public function callback_add_historic( $data ) {
		if ( ! empty( $data['parent_id'] ) && ! empty( $data['id'] ) && ! empty( $data['content'] ) ) {
			$data['date'] = current_time( 'mysql' );
			update_post_meta( $data['parent_id'], \eoxia\Config_Util::$init['digirisk']->historic->key_historic, $data );
		}
	}

	/**
	 * Récupères toutes les cotations faites pour le risque et les affiches.
	 *
	 * @since 6.2.10
	 */
	public function callback_historic_risk() {
		check_ajax_referer( 'historic_risk' );

		$risk_id = ! empty( $_POST['id'] ) ? (int) $_POST['id'] : 0; // WPCS: input var ok.

		if ( empty( $risk_id ) ) {
			wp_send_json_error();
		}

		$evaluations = Risk_Evaluation_Class::g()->get( array(
			'post_id' => $risk_id,
			'orderby' => 'comment_ID',
		) );

		if ( ! empty( $evaluations ) ) {
			foreach ( $evaluations as &$evaluation ) {
				$evaluation->comments = Risk_Evaluation_Comment_Class::g()->get( array(
					'post_id' => $risk_id,
					'parent'  => $evaluation->data['id'],
				) );
			}
		}

		ob_start();
		\eoxia\View_Util::exec( 'digirisk', 'historic', 'risk/main', array(
			'evaluations' => $evaluations,
		) );
		$view = ob_get_clean();

		ob_start();
		\eoxia\View_Util::exec( 'digirisk', 'historic', 'risk/modal-button' );
		$buttons_view = ob_get_clean();

		wp_send_json_success( array(
			'namespace'        => 'digirisk',
			'module'           => 'historic',
			'callback_success' => 'openedHistoricRiskPopup',
			'view'             => $view,
			'buttons_view'     => $buttons_view,
		) );
	}
}

new Historic_Action();
