<?php
/**
 * Classe gérant les fitres principaux des documents.
 *
 * Génères le nom du fichier.
 * Génères la version du fichier.
 * Gestion de l'ajout du mime type.

 * @author    Evarisk <dev@evarisk.com>
 * @copyright (c) 2006-2018 Evarisk <dev@evarisk.com>.
 *
 * @license   AGPLv3 <https://spdx.org/licenses/AGPL-3.0-or-later.html>
 *
 * @package   DigiRisk\Classes
 *
 * @since     7.0.0
 */

namespace digi;

defined( 'ABSPATH' ) || exit;

/**
 * Document util class.
 */
class Document_Filter extends \eoxia\Singleton_Util {

	/**
	 * Constructeur.
	 *
	 * @since 7.0.0
	 */
	protected function construct() {
		add_filter( 'eo_model_registre_at_benin_before_post', array( $this, 'before_save_doc' ), 10, 2 );
		add_filter( 'eo_model_duer_before_post', array( $this, 'before_save_doc' ), 10, 2 );
		add_filter( 'eo_model_affichage_legal_A3_before_post', array( $this, 'before_save_doc' ), 10, 2 );
		add_filter( 'eo_model_affichage_legal_A4_before_post', array( $this, 'before_save_doc' ), 10, 2 );
		add_filter( 'eo_model_diffusion_info_A3_before_post', array( $this, 'before_save_doc' ), 10, 2 );
		add_filter( 'eo_model_diffusion_info_A4_before_post', array( $this, 'before_save_doc' ), 10, 2 );
		add_filter( 'eo_model_accident_benin_before_post', array( $this, 'before_save_doc' ), 10, 2 );

		add_filter( 'eo_model_zip_before_post', array( $this, 'before_save_doc' ), 10, 2 );
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
		$upload_dir = wp_upload_dir();

		$data['title']  = current_time( 'Ymd' ) . '_';
		$data['title'] .= $data['parent']->data['unique_identifier'] . '_' . sanitize_title( $data['type'] ) . '_';
		$data['title'] .= sanitize_title( $data['parent']->data['title'] ) . '_';
		$data['title'] .= 'V' . \eoxia\ODT_Class::g()->get_revision( $data['type'], $data['parent']->data['id'] );
		$data['title']  = str_replace( '-', '_', $data['title'] );

		$data['guid'] = $upload_dir['baseurl'] . '/digirisk/' . $data['parent']->data['type'] . '/' . $data['parent']->data['id'] . '/' . sanitize_title( $data['title'] ) . '.odt';
		$data['path'] = $upload_dir['basedir'] . '/digirisk/' . $data['parent']->data['type'] . '/' . $data['parent']->data['id'] . '/' . sanitize_title( $data['title'] ) . '.odt';
		$data['path'] = str_replace( '\\', '/', $data['path'] );

		$data['_wp_attached_file'] = '/digirisk/' . $data['parent']->data['type'] . '/' . $data['parent']->data['id'] . '/' . sanitize_title( $data['title'] ) . '.odt';

		return $data;
	}

	public function fill_header( $data, $args ) {
		$address = Society_Class::g()->get_address( $args['parent'] );

		$data['reference']    = $args['parent']->data['unique_identifier'];
		$data['nom']          = $args['parent']->data['title'];
		$data['adresse']      = $address->data['address'] . ' ' . $address->data['additional_address'];
		$data['codePostal']   = $address->data['postcode'];
		$data['ville']        = $address->data['town'];
		$data['telephone']    = ! empty( $args['parent']->data['contact']['phone'] ) ? end( $args['parent']->data['contact']['phone'] ) : '';
		$data['description']  = $args['parent']->data['content'];
		$data['photoDefault'] = '';

		if ( ! empty( $args['parent']->data['thumbnail_id'] ) ) {
			$data['photoDefault'] = Document_Util_Class::g()->get_picture( ! empty( $args['parent']->data['thumbnail_id'] ) ? $args['parent']->data['thumbnail_id'] : 0, 9, 'medium' );
		}

		return $data;
	}

	public function fill_risks( $data, $args ) {
		$risks = Risk_Class::g()->get( array( 'post_parent' => $args['parent']->data['id'] ) );

		$data['risq4'] = array( 'type' => 'segment', 'value' => array() );
		$data['risq3'] = array( 'type' => 'segment', 'value' => array() );
		$data['risq2'] = array( 'type' => 'segment', 'value' => array() );
		$data['risq1'] = array( 'type' => 'segment', 'value' => array() );

		if ( ! empty( $risks ) ) {
			foreach ( $risks as $risk ) {
				$comment_list = '';

				if ( ! empty( $risk->data['comment'] ) ) {
					foreach ( $risk->data['comment'] as $comment ) {
						$comment_list .= $comment->data['date']['rendered']['date_time'] . ' : ' . $comment->data['content'] . "
";
					}
				}

				$data[ 'risq' . $risk->data['evaluation']->data['scale'] ]['value'][] = array(
					'nomDanger'         => $risk->data['risk_category']->data['name'],
					'identifiantRisque' => $risk->data['unique_identifier'] . '-' . $risk->data['evaluation']->data['unique_identifier'],
					'quotationRisque'   => $risk->data['current_equivalence'],
					'commentaireRisque' => $comment_list,
				);
			}
		}

		return $data;
	}

	public function fill_evaluators( $data, $args ) {
		$data['utilisateursPresents'] = array( 'type' => 'segment', 'value' => array() );

		$affecteds_evaluator = Evaluator_Class::g()->get_list_affected_evaluator( $args['parent'] );

		if ( ! empty( $affecteds_evaluator ) ) {
			foreach ( $affecteds_evaluator as $evaluator_id => $evaluator_affectation_info ) {
				foreach ( $evaluator_affectation_info as $evaluator_affectation_info ) {
					if ( 'valid' === $evaluator_affectation_info['affectation_info']['status'] ) {
						$data['utilisateursPresents']['value'][] = array(
							'idUtilisateur'              => Evaluator_Class::g()->element_prefix . $evaluator_affectation_info['user_info']->data['id'],
							'nomUtilisateur'             => $evaluator_affectation_info['user_info']->data['lastname'],
							'prenomUtilisateur'          => $evaluator_affectation_info['user_info']->data['firstname'],
							'dateAffectationUtilisateur' => mysql2date( 'd/m/Y', $evaluator_affectation_info['affectation_info']['start']['date'], true ),
							'dateTrie'                   => $evaluator_affectation_info['affectation_info']['start']['date'],
							'dureeEntretien'             => Evaluator_Class::g()->get_duration( $evaluator_affectation_info['affectation_info'] ),
						);
					}
				}
			}

			if ( count( $data['utilisateursPresents']['value'] ) > 1 ) {
				usort( $data['utilisateursPresents']['value'], function( $a, $b ) {
					if ( $a['dateTrie'] == $b['dateTrie'] ) {
						return 0;
					}

					return ( $a['dateTrie'] > $b['dateTrie'] ) ? 1 : -1;
				} );
			}
		}

		return $data;
	}

	public function fill_recommendations( $data, $args ) {
		$data['affectedRecommandation'] = array( 'type' => 'segment', 'value' => array() );

		$recommendations = Recommendation::g()->get( array( 'post_parent' => $args['parent']->data['id'] ) );

		if ( ! empty( $recommendations ) ) {
			foreach ( $recommendations as $recommendation ) {
				/** Récupères la catégorie parent */
				$data['affectedRecommandation']['value'][] = array(
					'identifiantRecommandation' => $recommendation->data['unique_identifier'],
					'recommandationIcon'        => Document_Util_Class::g()->get_picture( $recommendation->data['recommendation_category']->data['thumbnail_id'], 1 ),
					'recommandationName'        => $recommendation->data['recommendation_category']->data['name'],
					'recommandationComment'     => ! empty( $recommendation->data['comment'][0] ) ? $recommendation->data['comment'][0]->data['content'] : '',
				);
			}
		}

		return $data;
	}
}

Document_Filter::g();
