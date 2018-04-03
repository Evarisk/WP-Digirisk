<?php
/**
 * Les filtres relatifs aux risques
 *
 * @author Evarisk <dev@evarisk.com>
 * @since 6.2.4
 * @version 7.0.0
 * @copyright 2015-2018 Evarisk
 * @package DigiRisk
 */

namespace digi;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Les filtres relatifs aux risques
 */
class Risk_Filter extends Identifier_Filter {

	/**
	 * Le constructeur
	 */
	public function __construct() {
		parent::__construct();

		add_filter( 'digi_tab', array( $this, 'callback_tab' ), 1, 2 );

		$current_type = Risk_Class::g()->get_type();
		add_filter( "eo_model_{$current_type}_after_get", array( $this, 'get_full_risk' ), 10, 2 );
	}

	/**
	 * Ajoutes l'onglet risque aux groupements et aux unités de travail
	 *
	 * @param  array   $list_tab La liste des filtres.
	 * @param  integer $id L'ID de la société.
	 *
	 * @return array
	 *
	 * @since 6.2.2
	 * @version 7.0.0
	 */
	public function callback_tab( $list_tab, $id ) {
		$list_tab['digi-group']['risk'] = array(
			'type'  => 'text',
			'text'  => __( 'Risques', 'digirisk' ),
			'title' => __( 'Les risques', 'digirisk' ),
		);

		$list_tab['digi-workunit']['risk'] = array(
			'type'  => 'text',
			'text'  => __( 'Risques', 'digirisk' ),
			'title' => __( 'Les risques', 'digirisk' ),
		);

		return $list_tab;
	}


	/**
	 * Récupères tous les éléments nécessaires pour le fonctionnement d'un risque.
	 * Danger catégorie, danger, méthode d'évaluation, évaluation et commentaire.
	 *
	 * @since 6.0.0
	 * @version 7.0.0
	 *
	 * @param  Risk_Model $object L'objet.
	 * @param  array      $args   Les paramètres de la requête.
	 * @return Risk_Model L'objet avec tous les éléments ajoutés par cette méthode.
	 */
	public function get_full_risk( $object, $args ) {
		$object->data['risk_category']     = array();
		$object->data['evaluation_method'] = array();
		$object->data['evaluation']        = array();
		$risk_evaluation_comments          = array();

		if ( ! empty( $object->data['id'] ) ) {
			$object->data['risk_category']     = Risk_Category_Class::g()->get( array( 'id' => end( $object->data['taxonomy']['digi-category-risk'] ) ), true );
			$object->data['evaluation_method'] = Evaluation_Method_Class::g()->get( array( 'id' => end( $object->data['taxonomy'][ Evaluation_Method_Class::g()->get_type() ] ) ), true );
			$object->data['evaluation']        = Risk_Evaluation_Class::g()->get( array(
				'post_id' => $object->data['id'],
				'number'  => 1,
			), true );
			$risk_evaluation_comments          = Risk_Evaluation_Comment_Class::g()->get( array( 'post_id' => $object->data['id'] ) );
		}

		if ( 0 === count( $object->data['risk_category'] ) ) {
			$object->data['risk_category'] = Risk_Category_Class::g()->get( array( 'schema' => true ), true );
		}

		if ( 0 === count( $object->data['evaluation_method'] ) ) {
			$object->data['evaluation_method'] = Evaluation_Method_Class::g()->get( array( 'schema' => true ), true );
		}

		if ( 0 === count( $object->data['evaluation'] ) ) {
			$object->data['evaluation'] = Risk_Evaluation_Class::g()->get( array( 'schema' => true ), true );
		}

		if ( 0 === count( $risk_evaluation_comments ) ) {
			$risk_evaluation_comments = Risk_Evaluation_Comment_Class::g()->get( array( 'schema' => true ) );
		}

		$object->data['comment'] = $risk_evaluation_comments;

		if ( ! isset( $object->data['modified_unique_identifier'] ) ) {
			$object->data['modified_unique_identifier'] = '';
		}

		return $object;
	}
}

new Risk_Filter();
