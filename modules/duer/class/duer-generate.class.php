<?php
/**
 * Génères le DUER
 *
 * @author Jimmy Latour <jimmy@evarisk.com>
 * @since 6.1.9
 * @version 6.4.0
 * @copyright 2015-2017 Evarisk
 * @package DigiRisk
 */

namespace digi;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Génères le DUER
 */
class DUER_Generate_Class extends \eoxia\Singleton_Util {

	/**
	 * Le constructeur pour l'héritage de Singleton_Util
	 *
	 * @since 6.0.0
	 * @version 6.3.0
	 */
	protected function construct() {}

	/**
	 * Génères le DUER
	 *
	 * @since 6.0.0
	 * @version 6.4.0
	 *
	 * @param array $data Les data à mettre dans le ODT.
	 * @return array {
	 *         @type array         creation_response Un tableau contenant toutes les réponses de la création de tous les documents nécessaires pour le DUER.
	 *         @type Society_Model element           Les données de la société.
	 *         @type boolean       success           Si la génération s'est déroulée avec succés.
	 * }
	 */
	public function generate( $data ) {
		if ( empty( $data ) || empty( $data['element_id'] ) ) {
			return false;
		}

		$id      = (int) $data['element_id'];
		$element = Society_Class::g()->get( array(
			'id' => $id,
		), true );

		$src_logo         = $this->get_logo();
		$data             = $this->securize_duer_data( $data, $element );
		$data_to_document = $this->prepare_skeleton();
		$data_to_document = $this->fill_data_duer( $data, $data_to_document, $element );
		$data_to_document = $this->fill_data_risk( $data_to_document, $element );

		$data_to_document = apply_filters( 'wpdigi_element_duer_details', $data_to_document );

		$document_creation_response = DUER_Class::g()->create_document( $element, array( 'document_unique' ), $data_to_document );

		return array(
			'creation_response' => $document_creation_response,
			'element'           => $element,
			'success'           => true,
		);
	}

	/**
	 * Securises toutes les données
	 *
	 * @param array       $data Les données à sécuriser.
	 * @param Group_Model $element Les données du groupement.
	 *
	 * @return array Les données sécurisées
	 *
	 * @since 6.0.0
	 * @version 6.3.0
	 */
	public function securize_duer_data( $data, $element ) {
		$user = wp_get_current_user();
		$data['nomEntreprise'] = $element->title;
		$data['emetteurDUER'] = $user->display_name;
		$data['telephone'] = ! empty( $element->contact['phone'] ) ? max( $element->contact['phone'] ) : '';

		$data['dateAudit'] = $this->formatte_audit_date( $data );
		$data['destinataireDUER'] = ! empty( $data['destinataireDUER'] ) ? sanitize_text_field( $data['destinataireDUER'] ) : '';
		$data['portable'] = ! empty( $data['portable'] ) ? sanitize_text_field( $data['portable'] ) : '';

		$data['methodologie'] = ! empty( $data['methodologie'] ) ? $data['methodologie'] : '';
		$data['sources'] = ! empty( $data['sources'] ) ? $data['sources'] : '';
		$data['remarqueImportante'] = ! empty( $data['remarqueImportante'] ) ? $data['remarqueImportante'] : '';
		$data['dispoDesPlans'] = ! empty( $data['dispoDesPlans'] ) ? $data['dispoDesPlans'] : '';

		return $data;
	}

	/**
	 * Prépares un squelette des données
	 *
	 * Cette méthode permet de définir des chaines de caractères vide dans l'ODT si les données ne sont pas présente.
	 *
	 * @since 6.0.0
	 * @version 6.4.0
	 *
	 * @return array {
	 *         Le squelette des données
	 *
	 *         @type string identifiantElement
	 *         @type string nomEntreprise
	 *         @type string dateAudit
	 *         @type emetteurDUER
	 *         @type
	 * }
	 */
	public function prepare_skeleton() {
		$skeleton = array(
			'identifiantElement' => '',
			'nomEntreprise' => '',
			'dateAudit' => '',
			'emetteurDUER' => '',
			'destinataireDUER' => '',
			'dateGeneration' => '',
			'telephone' => '',
			'portable' => '',

			'methodologie' => '',
			'sources' => '',
			'remarqueImportante' => '',
			'dispoDesPlans' => '',

			'elementParHierarchie' => array(
				'type' => 'segment',
				'value' => array(),
			),

			'risq' => array(
				'type' => 'segment',
				'value' => array(),
			),

			'risqueFiche' => array(
				'type' => 'segment',
				'value' => array(),
			),

			'planDactionRisq' => array(
				'type' => 'segment',
				'value' => array(),
			),

			'planDaction' => array(
				'type' => 'segment',
				'value' => array(),
			),
		);

		$level_list = array( 48, 51, 80 );
		foreach ( $level_list as $level ) {
			$skeleton[ 'risq' . $level ] = array(
				'type' => 'segment',
				'value' => array(),
			);
			$skeleton[ 'planDactionRisq' . $level ] = array(
				'type' => 'segment',
				'value' => array(),
			);
		}

		return $skeleton;
	}

	/**
	 * Récupères le logo
	 *
	 * @since 6.0.0
	 * @version 6.4.0
	 *
	 * @return string Le chemin vers le logo
	 */
	public function get_logo() {
		$custom_logo_id = get_theme_mod( 'custom_logo' );
		$src_logo = wp_get_attachment_image_src( $custom_logo_id, 'digirisk-element-thumbnail' );
		return $src_logo;
	}

	/**
	 * Remplis les données du duer
	 *
	 * @param array  $data Les données sécurisées.
	 * @param array  $data_to_document Les données qui seront insérées dans le document.
	 * @param object $element L'objet groupement.
	 *
	 * @return array Les données qui seront insérées dans le document
	 *
	 * @since 6.0.0
	 * @version 6.3.1
	 */
	public function fill_data_duer( $data, $data_to_document, $element ) {
		$data_to_document = array_merge( $data_to_document, $data );
		$data_to_document['identifiantElement'] = $element->unique_identifier;
		$data_to_document['dateAudit'] = $this->formatte_audit_date( $data );
		$data_to_document['dateGeneration'] = mysql2date( get_option( 'date_format' ), current_time( 'mysql', 0 ), true );
		$data_to_document['elementParHierarchie']['value'] = Group_Class::g()->get_element_sub_tree( $element );

		return $data_to_document;
	}

	/**
	 * Remplis les données du duer des risques
	 *
	 * @param array  $data_to_document Les données qui seront insérées dans le document.
	 * @param object $element L'objet groupement.
	 *
	 * @return array Les données qui seront insérées dans le document
	 *
	 * @since 0.1
	 * @version 6.2.5.0
	 */
	public function fill_data_risk( $data_to_document, $element ) {
		$list_risk = group_class::g()->get_element_tree_risk( $element );
		$risk_per_element = array();

		if ( count( $list_risk ) > 1 ) {
			usort( $list_risk, function( $a, $b ) {
				if( $a['quotationRisque'] == $b['quotationRisque'] ) {
					return 0;
				}
				return ( $a['quotationRisque'] > $b['quotationRisque'] ) ? -1 : 1;
			} );
		}

		if ( !empty( $list_risk ) ) {
		  foreach ( $list_risk as $risk ) {
				$final_level = !empty( evaluation_method_class::g()->list_scale[$risk['niveauRisque']] ) ? evaluation_method_class::g()->list_scale[$risk['niveauRisque']] : '';
				$data_to_document[ 'risq' . $final_level ][ 'value' ][] = $risk;
				$data_to_document[ 'planDactionRisq' . $final_level ][ 'value' ][] = $risk;

				if ( !isset( $risk_per_element[ $risk[ 'idElement' ] ] ) ) {
					$risk_per_element[ $risk[ 'idElement' ] ][ 'quotationTotale' ] = 0;
				}
				$risk_per_element[ $risk[ 'idElement' ] ][ 'quotationTotale' ] += $risk[ 'quotationRisque' ];
		  }
		}

		$element_sub_tree = group_class::g()->get_element_sub_tree( $element , '', array( 'default' => array( 'quotationTotale' => 0, ), 'value' => $risk_per_element, ) );
		if ( count( $element_sub_tree ) > 1 ) {
			usort( $element_sub_tree, function( $a, $b ) {
				if( $a['quotationTotale'] == $b['quotationTotale'] ) {
					return 0;
				}
				return ( $a['quotationTotale'] > $b['quotationTotale'] ) ? -1 : 1;
			} );
		}
		$data_to_document[ 'risqueFiche' ][ 'value' ] = $element_sub_tree;

		return $data_to_document;
	}

	/**
	 * Formattes la date de l'audit
	 *
	 * @param array $data_duer Les données sécurisées.
	 *
	 * @return string La date de l'audit formatté
	 *
	 * @since 6.0.0
	 * @version 6.3.0
	 */
	public function formatte_audit_date( $data_duer ) {
		$audit_date = '';

		if ( ! empty( $data_duer['dateDebutAudit'] ) ) {
			$audit_date .= mysql2date( 'd/m/Y', $data_duer['dateDebutAudit'] );
		}

		if ( ! empty( $data_duer['dateFinAudit'] ) && $audit_date != $data_duer['dateFinAudit'] ) {
			if ( ! empty( $audit_date ) ) {
				$audit_date .= ' - ';
			}

			$audit_date .= mysql2date( 'd/m/Y', $data_duer['dateFinAudit'] );
		}

		return $audit_date;
	}

}
