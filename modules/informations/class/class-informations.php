<?php
/**
 * Appelle la vue pour afficher le formulaire de configuration d'une société
 *
 * @author Evarisk <dev@evarisk.com>
 * @since 6.2.1
 * @copyright 2015-2018 Evarisk
 * @package DigiRisk
 */

namespace digi;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Appelle la vue pour afficher le formulaire de configuration d'une société
 */
class Informations_Class extends \eoxia\Singleton_Util {

	/**
	 * Le constructeur
	 */
	protected function construct() {}

	/**
	 * Charges le responsable et l'addresse du groupement.
	 * Envois les données à la vue group/configuration-form.view.php
	 *
	 * @param  Group_Model $element L'objet groupement.
	 *
	 * @since 7.2.0
	 */
	public function display( $element ) {
		$general_options = get_option( \eoxia\Config_Util::$init['digirisk']->general_options, Setting_Class::g()->default_general_options );

		$duers        = DUER_Class::g()->get( array( 'posts_per_page' => 2 ), true );
		$current_duer = null;

		$date_before_next_duer = null;

		if ( ! empty( $duers ) ) {
			$current_duer = ( is_array( $duers ) ) ? $duers[0] : $duers;
			$old_duer     = is_array( $duers ) ? $duers[1] : null;
		}

		$accident = Accident_Class::g()->get( array( 'posts_per_page' => 1 ), true );

		$count_users = count_users();

		$historic_update = get_post_meta( $element->data['id'], \eoxia\Config_Util::$init['digirisk']->historic->key_historic, true );

		if ( empty( $historic_update ) ) {
			$historic_update = array(
				'date'    => 'Indisponible',
				'content' => 'Indisponible',
			);
		} else {
			$historic_update['date'] = \eoxia\Date_Util::g()->fill_date( $historic_update['date'] );
			$historic_update['parent'] = Society_Class::g()->show_by_type( $historic_update['parent_id'] );
		}

		$evaluator_ids = array();

		$groups          = Group_Class::g()->get( array(
			'posts_per_page' => -1,
		) );
		$groups          = array_merge( $groups, Workunit_Class::g()->get( array(
			'posts_per_page' => -1,
		) ) );

		if ( ! empty( $groups ) ) {
			foreach ( $groups as $group ) {
				if ( ! empty( $group->data['user_info']['affected_id']['evaluator'] ) ) {
					foreach ( $group->data['user_info']['affected_id']['evaluator'] as $user_affected_id => $affected_info ) {
						if ( ! in_array( $user_affected_id, $evaluator_ids, true ) ) {
							$evaluator_ids[] = $user_affected_id;
						}
					}
				}
			}
		}

		$number_evaluator = count( $evaluator_ids );

		$total_users = $count_users['total_users'] - 1;
		$average = 'N/A';

		if ( $total_users != 0 ) {
			$average = round( $number_evaluator / $total_users * 100 );
			$average .= '%';
		}

		$diff_info = array(
			'total_risk'      => 'N/A',
			'quotation_total' => 'N/A',
			'average'         => 'N/A',
			'number_risk'     => array( 0, 0, 0, 0, 0 ),
		);

		$current_duer_info = $this->duer_info( array() );
		$old_duer_info     = $this->duer_info( array() );

		if ( ! empty( $current_duer ) ) {
			$current_duer_info = $this->duer_info( $current_duer->data );

			$date         = new \DateTime( $current_duer->data['date']['raw'] );
			$date_compare = new \DateTime( $current_duer->data['date']['raw'] );
			$current_date = new \DateTime( 'now' );

			$date_compare->add( new \DateInterval( 'P' . $general_options['required_duer_day'] . 'D' ) );

			$interval              = $current_date->diff( $date_compare );
			$date_before_next_duer = $interval->format( '%a' );
		}

		if ( ! empty( $old_duer ) ) {
			$old_duer_info = $this->duer_info( $old_duer->data );

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


		$risks = Risk_Class::g()->get();

		if ( ! empty( $risks_categories ) ) {
			foreach ( $risks_categories as &$risk_category ) {
				for ( $i = 1; $i < 5; $i++ ) {
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

		\eoxia\View_Util::exec( 'digirisk', 'informations', 'main', array(
			'current_duer'          => $current_duer,
			'current_duer_info'     => $current_duer_info,
			'old_duer_info'         => $old_duer_info,
			'accident'              => $accident,
			'count_users'           => $count_users,
			'historic_update'       => $historic_update,
			'number_evaluator'      => count( $evaluator_ids ),
			'average'               => $average,
			'total_users'           => $total_users,
			'diff_info'             => $diff_info,
			'risks_categories'      => $risks_categories,
			'general_options'       => $general_options,
			'date_before_next_duer' => $date_before_next_duer,
		) );
	}

	public function duer_info( $duer ) {
		$total_risk      = 'N/A';
		$quotation_total = 'N/A';
		$average         = 'N/A';
		$number_risk = array( 1 => 'N/A', 2 => 'N/A', 3 => 'N/A', 4 => 'N/A' );

		if ( ! empty( $duer['document_meta'] ) ) {
			$total_risk      = 0;
			$quotation_total = 0;
			$average         = 0;
			$number_risk     = array( 1 => 0, 2 => 0, 3 => 0, 4 => 0 );
			$risk_level      = array( 1, 2, 3, 4 );

			if ( ! empty( $risk_level ) ) {
				foreach ( $risk_level as $level ) {
					$number_risk[ $level ] = count( $duer['document_meta'][ 'risq' . $level ]['value'] );
					$total_risk += count( $duer['document_meta'][ 'risq' . $level ]['value'] );
				}
			}

			if ( ! empty( $duer['document_meta']['risqueFiche']['value'] ) ) {
				foreach ( $duer['document_meta']['risqueFiche']['value'] as $element ) {
					$quotation_total += $element['quotationTotale'];
				}
			}

			$average = $quotation_total / $total_risk;
		}

		return array(
			'total_risk'      => $total_risk,
			'quotation_total' => $quotation_total,
			'average'         => $average,
			'number_risk'     => $number_risk,
		);
	}
}

Informations_Class::g();
