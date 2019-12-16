<?php
/**
 * Gestion de l'action pour enregistrer les informations d'une société.
 *
 * @author    Evarisk <dev@evarisk.com>
 * @copyright (c) 2006-2018 Evarisk <dev@evarisk.com>.
 *
 * @license   AGPLv3 <https://spdx.org/licenses/AGPL-3.0-or-later.html>
 *
 * @package   DigiRisk\Classes
 *
 * @since     6.2.2
 */

namespace digi;

defined( 'ABSPATH' ) || exit;

/**
 * Society informations action.
 */
class Society_Informations_Action {

	/**
	 * Constructeur.
	 *
	 * @since 6.2.2
	 */
	public function __construct() {
		add_action( 'wp_ajax_load_risks_information', array( $this, 'load_risks_information' ) );
	}

	public function load_risks_information() {
		$diff_info = array(
			'total_risk'      => 'N/A',
			'quotation_total' => 'N/A',
			'average'         => 'N/A',
			'number_risk'     => array( 0, 0, 0, 0, 0 ),
		);

		$current_duer_info = Informations_Class::g()->duer_info( array() );
		$old_duer_info     = Informations_Class::g()->duer_info( array() );

		if ( ! empty( $current_duer ) ) {
			$current_duer_info = Informations_Class::g()->duer_info( $current_duer->data );
		}

		if ( ! empty( $old_duer ) ) {
			$old_duer_info = Informations_Class::g()->duer_info( $old_duer->data );

			$diff_info['total_risk']      = $current_duer_info['total_risk'] - $old_duer_info['total_risk'];
			$diff_info['quotation_total'] = $current_duer_info['quotation_total'] - $old_duer_info['quotation_total'];
			$diff_info['average']         = $current_duer_info['average'] - $old_duer_info['average'];

			$diff_info['number_risk'] = array(
				1 => $current_duer_info['number_risk'][1] - $old_duer_info['number_risk'][1],
				2 => $current_duer_info['number_risk'][2] - $old_duer_info['number_risk'][2],
				3 => $current_duer_info['number_risk'][3] - $old_duer_info['number_risk'][3],
				4 => $current_duer_info['number_risk'][4] - $old_duer_info['number_risk'][4],
			);
		}

		$risks_categories = Risk_Category_Class::g()->get( array(
			'meta_key' => '_position',
			'orderby'  => 'meta_value_num',
		) );

		if ( ! empty( $risks_categories ) ) {
			foreach ( $risks_categories as &$risk_category ) {
				for ( $i = 0; $i < 5; $i++ ) {
					if ( ! isset( $risk_category->data['level' . $i ] )  ) {
						$risk_category->data['level' . $i ] = 0;
					}
				}

				$risks = Risk_Class::g()->get( array(
					'tax_query' => array(
						array(
							'taxonomy' => Risk_Category_Class::g()->get_type(),
							'field'    => 'term_id',
							'terms'    => $risk_category->data['id'],
						),
					),
					'meta_query' => array(
						array(
							'key'     => '_wpdigi_preset',
							'value'   => 1,
							'compare' => '!=',
						),
					),
				) );

				if ( ! empty( $risks ) ) {
					foreach ( $risks as $risk ) {
						$risk_category->data['level' . $risk->data['evaluation']->data['scale'] ]++;
					}
				}
			}
		}

		unset( $risk_category );

		ob_start();
		\eoxia\View_Util::exec( 'digirisk', 'informations', 'risks', array(
			'old_duer_info'     => $old_duer_info,
			'current_duer_info' => $current_duer_info,
			'diff_info'         => $diff_info,
			'risks_categories'   => $risks_categories,
		) );
		$view = ob_get_clean();

		wp_send_json_success( array(
			'view' => $view,
		) );
	}
}

new Society_Informations_Action();
