<?php
/**
 * Les filtres relatives au DUER
 *
 * @author Evarisk <jimmy@evarisk.com>
 * @since 6.2.5
 * @version 6.4.4
 * @copyright 2015-2017 Evarisk
 * @package DigiRisk
 */

namespace digi;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Les filtres relatives au DUER
 */
class DUER_Filter extends Identifier_Filter {

	/**
	 * Le constructeur ajoute le filtre society_header_end
	 *
	 * @since 6.2.5
	 */
	public function __construct() {
		parent::__construct();

		add_filter( 'digi_tab', array( $this, 'callback_digi_tab' ), 5, 2 );

		add_filter( 'digi_duer_document_data', array( $this, 'callback_digi_document_data' ), 10, 2 );
		add_filter( 'digi_duer_document_data', array( $this, 'callback_hierarchy' ), 11, 2 );
		add_filter( 'digi_duer_document_data', array( $this, 'callback_risks' ), 12, 2 );
	}

	/**
	 * Ajoutes une entrée dans le tableau $list_tab pour la société.
	 *
	 * @param  array   $list_tab  La liste des filtres.
	 * @param  integer $id        L'ID de la société.
	 * @return array              La liste des filtres + le filtre ajouté par cette méthode.
	 *
	 * @since 6.4.4
	 */
	public function callback_digi_tab( $list_tab, $id ) {
		$list_tab['digi-society']['list-duer'] = array(
			'type'  => 'text',
			'text'  => __( 'DUER ', 'digirisk' ),
			'title' => __( 'DUER', 'digirisk' ),
		);

		return $list_tab;
	}

	/**
	 * Ajoutes toutes les données nécessaire pour le registre des AT bénins.
	 *
	 * @since 7.0.0
	 *
	 * @param  array         $data    Les données pour le registre des AT bénins.
	 * @param  Society_Model $society Les données de la société.
	 *
	 * @return array                  Les données pour le registre des AT bénins modifié.
	 */
	public function callback_digi_document_data( $data, $args ) {
		$society = Society_Class::g()->get( array(
			'posts_per_page' => 1,
		), true );

		$user = wp_get_current_user();

		$data['nomEntreprise']      = $society->data['title'];
		$data['emetteurDUER']       = ! empty( $user->display_name ) ? $user->display_name : '';
		$data['destinataireDUER']   = $args['destinataire_duer'];
		$data['telephone']          = ! empty( $society->data['contact']['phone'] ) ? end( $society->data['contact']['phone'] ) : '';
		$data['portable']           = '';
		$data['methodologie']       = $args['methodologie'];
		$data['sources']            = $args['sources'];
		$data['remarqueImportante'] = $args['remarque_importante'];
		$data['dispoDesPlans']      = $args['dispo_des_plans'];
		$data['dateGeneration']     = mysql2date( get_option( 'date_format' ), current_time( 'mysql', 0 ), true );
		$data['dateDebutAudit']     = $args['date_debut_audit'];
		$data['dateFinAudit']       = $args['date_fin_audit'];

		$audit_date = '';

		if ( ! empty( $args['date_debut_audit'] ) ) {
			$audit_date .= mysql2date( 'd/m/Y', $args['date_debut_audit'] );
		}
		if ( ! empty( $args['date_fin_audit'] ) && $audit_date != $args['date_fin_audit'] ) {
			if ( ! empty( $audit_date ) ) {
				$audit_date .= ' - ';
			}
			$audit_date .= mysql2date( 'd/m/Y', $args['date_fin_audit'] );
		}

		$data['dateAudit'] = $audit_date;

		$data['elementParHierarchie'] = array(
			'type'  => 'segment',
			'value' => array(),
		);

		$level_risk = array( '1', '2', '3', '4' );

		foreach( $level_risk as $level ) {
			$data[ 'risk' . $level ] = array(
				'type'  => 'segment',
				'value' => array(),
			);

			$data[ 'planDactionRisq' . $level ] = array(
				'type'  => 'segment',
				'value' => array(),
			);
		}

		$data['risqueFiche'] = array(
			'type'  => 'segment',
			'value' => array(),
		);

		return $data;
	}

	public function callback_hierarchy( $data, $args ) {
		return DUER_Class::g()->get_hierarchy( $data, $args );
	}

	public function callback_risks( $data, $args ) {
		$quotationsTotal = array();

		$args_where = array(
			'post_status'    => array( 'publish', 'inherit' ),
			'meta_key'       => '_wpdigi_equivalence',
			'orderby'        => 'meta_value_num',
			'meta_query' => array(
				array(
					'key'     => '_wpdigi_preset',
					'value'   => 1,
					'compare' => '!=',
				)
			)
		);

		$risks = Risk_Class::g()->get( $args_where );

		if ( ! empty( $risks ) ) {
			foreach ( $risks as $risk ) {
				$output_comment = '';

				if ( ! empty( $risk->data['comment'] ) ) {
					foreach ( $risk->data['comment'] as $comment ) {
						$output_comment .= point_to_string( $comment );
					}
				}

				$risk = Corrective_Task_Class::g()->output_odt( $risk );

				$risk_data = array(
					'nomElement'                  => $risk->data['parent']->data['unique_identifier'] . ' - ' . $risk->data['parent']->data['title'],
					'identifiantRisque'           => $risk->data['unique_identifier'] . ' - ' . $risk->data['evaluation']->data['unique_identifier'],
					'quotationRisque'             => $risk->data['current_equivalence'],
					'nomDanger'                   => $risk->data['risk_category']->data['name'],
					'commentaireRisque'           => $output_comment,
					'actionPreventionUncompleted' => $risk->data['output_action_prevention_uncompleted'],
					'actionPreventionCompleted'   => $risk->data['output_action_prevention_completed'],
				);

				$data[ 'risk' . $risk->data['evaluation']->data['scale'] ]['value'][]            = $risk_data;
				$data[ 'planDactionRisq' . $risk->data['evaluation']->data['scale'] ]['value'][] = $risk_data;

				if ( empty( $quotationsTotal[ $risk->data['parent']->data['unique_identifier'] . ' - ' . $risk->data['parent']->data['title'] ] ) ) {
					$quotationsTotal[ $risk->data['parent']->data['unique_identifier'] . ' - ' . $risk->data['parent']->data['title'] ] = 0;
				}

				$quotationsTotal[ $risk->data['parent']->data['unique_identifier'] . ' - ' . $risk->data['parent']->data['title'] ] += $risk->data['current_equivalence'];
			}
		}

		if ( count( $quotationsTotal ) > 1 ) {
			uasort( $quotationsTotal, function( $a, $b ) {
				if( $a == $b ) {
					return 0;
				}
				return ( $a > $b ) ? -1 : 1;
			} );
		}

		if ( ! empty( $quotationsTotal ) ) {
			foreach ( $quotationsTotal as $key => $quotationTotal ) {
				$data['risqueFiche']['value'][] = array(
					'nomElement'      => $key,
					'quotationTotale' => $quotationTotal,
				);
			}
		}

		return $data;
	}
}

new DUER_Filter();
