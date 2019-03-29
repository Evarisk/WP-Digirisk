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
		add_filter( 'eo_model_listing_risk_action_before_post', array( $this, 'before_save_doc' ), 10, 2 );
		add_filter( 'eo_model_listing_risk_picture_before_post', array( $this, 'before_save_doc' ), 10, 2 );
		add_filter( 'digi_listing_risk_action_document_data', array( $this, 'callback_digi_document_data' ), 12, 2 );
		add_filter( 'digi_listing_risk_picture_document_data', array( $this, 'callback_digi_document_data' ), 12, 2 );
	}



	/**
	 * Ajoutes le titre du document ainsi que le GUID et le chemin vers celui-ci.
	 *
	 * Cette méthode est appelée avant l'ajout du document en base de donnée.
	 *
	 * @since 7.0.0
	 *
	 * @param  array $data Les données du document.
	 * @param  array $args Les données de la requête.
	 *
	 * @return mixed
	 */
	public function before_save_doc( $data, $args ) {

		$identifier_filter = new Identifier_Filter();

		$upload_dir = wp_upload_dir();

		$type = '';
		$model_name = '';

		if ( 'listing_risk_picture' === $data['type'] ) {
			$type = 'listing_risque_photo';
			$model_name = '\digi\Listing_Risk_Picture_Model';
		} else {
			$type = 'listing_risque_action';
			$model_name = '\digi\Listing_Risk_Corrective_Task_Model';
		}

		$data = $identifier_filter->construct_identifier( $data, array( 'model_name' => $model_name ) );
		$data['document_meta']['reference'] = $data['unique_identifier'];

		$data['title']  = current_time( 'Ymd' ) . '_';
		$data['title'] .= $data['parent']->data['unique_identifier'] . '_' . sanitize_title( $type ) . '_';
		$data['title'] .= sanitize_title( $data['parent']->data['title'] ) . '_';
		$data['title'] .= 'V' . \eoxia\ODT_Class::g()->get_revision( $data['type'], $data['parent']->data['id'] );
		$data['title']  = str_replace( '-', '_', $data['title'] );

		$data['guid'] = $upload_dir['baseurl'] . '/digirisk/' . $data['parent']->data['type'] . '/' . $data['parent']->data['id'] . '/' . sanitize_title( $data['title'] ) . '.odt';
		$data['path'] = $upload_dir['basedir'] . '/digirisk/' . $data['parent']->data['type'] . '/' . $data['parent']->data['id'] . '/' . sanitize_title( $data['title'] ) . '.odt';
		$data['path'] = str_replace( '\\', '/', $data['path'] );

		$data['_wp_attached_file'] = '/digirisk/' . $data['parent']->data['type'] . '/' . $data['parent']->data['id'] . '/' . sanitize_title( $data['title'] ) . '.odt';

		return $data;
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

		if ( count( $data['risks'] ) > 1 ) {
			uasort( $data['risks'], function( $a, $b ) {
				if( $a->data['current_equivalence'] == $b->data['current_equivalence'] ) {
					return 0;
				}
				return ( $a->data['current_equivalence'] > $b->data['current_equivalence'] ) ? -1 : 1;
			} );
		}

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
					'nomElement'                  => $risk->data['parent']->data['unique_identifier'] . ' - ' . $risk->data['parent']->data['title'],
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
