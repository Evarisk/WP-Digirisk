<?php
/**
 * Classe gérant les filtres du listing des risques.
 *
 * @author    Evarisk <dev@evarisk.com>
 * @copyright (c) 2006 2018 Evarisk <dev@evarisk.com>.
 *
 * @license   AGPLv3 <https://spdx.org/licenses/AGPL-3.0-or-later.html>
 *
 * @package   DigiRisk\Classes
 *
 * @since     6.5.0
 */

namespace digi;

defined( 'ABSPATH' ) || exit;

/**
 * Lsting Risk Filter class.
 */
class Listing_Risk_Filter {

	/**
	 * Constructor.
	 *
	 * @since 6.5.0
	 */
	public function __construct() {
		add_filter( 'digi_tab', array( $this, 'callback_digi_tab' ), 6, 2 );

		add_filter( 'digi_listing_risk_action_document_data', array( $this, 'callback_digi_document_data' ), 12, 2 );
		add_filter( 'digi_listing_risk_picture_document_data', array( $this, 'callback_digi_document_data' ), 12, 2 );
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
		$list_tab['digi-group']['listing-risk'] = array(
			'type'  => 'text',
			'text'  => __( 'Listing risk ', 'digirisk' ),
			'title' => __( 'Listing risk', 'digirisk' ),
		);

		return $list_tab;
	}

	public function callback_digi_document_data( $data, $args ) {
		$args['parent_id'] = $args['parent']->data['id'];
		$with_picture      = ( 'actions' === $args['type'] ) ? false : true;

		$args_where = array(
			'post_parent'    => $args['parent_id'],
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

		// Récupères les risques.
		$data['risks'] = array_merge( array(), Risk_Class::g()->get( $args_where ) );

		$data = $this->callback_hierarchy( $data, $args );

		$level_risk = array( '1', '2', '3', '4' );

		foreach( $level_risk as $level ) {
			$data[ 'risk' . $level ] = array(
				'type'  => 'segment',
				'value' => array(),
			);
		}

		if ( ! empty( $data['risks'] ) ) {
			foreach ( $data['risks'] as $risk ) {
				$output_comment                       = '';

				if ( ! empty( $risk->data['comment'] ) ) {
					foreach ( $risk->data['comment'] as $comment ) {
						$output_comment .= point_to_string( $comment );
					}
				}

				$risk = Corrective_Task_Class::g()->output_odt( $risk );

				$risk_odt = array(
					'nomElement'                  => $risk->data['parent']->data['title'],
					'identifiantRisque'           => $risk->data['unique_identifier'] . ' - ' . $risk->data['evaluation']->data['unique_identifier'],
					'quotationRisque'             => $risk->data['current_equivalence'],
					'nomDanger'                   => $risk->data['risk_category']->data['name'],
					'commentaireRisque'           => $output_comment,
					'actionPreventionUncompleted' => $risk->data['output_action_prevention_uncompleted'],
					'actionPreventionCompleted'   => $risk->data['output_action_prevention_completed'],
					'photoAssociee'               => '',
				);

				if ( $with_picture && ! empty( $risk->data['thumbnail_id'] ) ) {
					$risk_odt['photoAssociee'] = Document_Util_Class::g()->get_picture( ! empty( $risk->data['thumbnail_id'] ) ? $risk->data['thumbnail_id'] : 0, 6, 'full' );

				}

				$data[ 'risk' . $risk->data['evaluation']->data['scale'] ]['value'][] = $risk_odt;
			}
		}


		unset( $data['risks'] );

		return $data;
	}

	public function callback_hierarchy( $data, $args ) {
		$societies = Society_Class::g()->get_societies_in( $args['parent_id'], 'inherit' );

		if ( ! empty( $societies ) ) {
			foreach ( $societies as $society ) {

				$args_where = array(
					'post_parent'    => $society->data['id'],
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

				// Récupères les risques.
				$data['risks']     = array_merge( $data['risks'], Risk_Class::g()->get( $args_where ) );
				$args['parent_id'] = $society->data['id'];

				$data = $this->callback_hierarchy( $data, $args );
			}
		}

		return $data;
	}
}

new Listing_Risk_Filter();
