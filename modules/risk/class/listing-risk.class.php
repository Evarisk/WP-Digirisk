<?php
/**
 * Classe gérant les listing de risque
 *
 * @author Jimmy Latour <jimmy@evarisk.com>
 * @since 6.5.0
 * @version 6.5.0
 * @copyright 2015-2018 Evarisk
 * @package DigiRisk
 */

namespace digi;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Classe gérant les listing de risque
 */
class Listing_Risk_Class extends Document_Class {

	/**
	 * Le nom du modèle
	 *
	 * @var string
	 */
	protected $model_name = '\digi\Listing_Risk_Model';

	/**
	 * Le post type
	 *
	 * @var string
	 */
	protected $post_type = 'listing_risk';

	/**
	 * Le type du document
	 *
	 * @var string
	 */
	public $attached_taxonomy_type = 'attachment_category';

	/**
	 * La clé principale du modèle
	 *
	 * @var string
	 */
	protected $meta_key = '_wpdigi_document';

	/**
	 * La route pour accéder à l'objet dans la rest API
	 *
	 * @var string
	 */
	protected $base = 'listing-risk';

	/**
	 * La version de l'objet
	 *
	 * @var string
	 */
	protected $version = '0.1';

	/**
	 * Le préfixe de l'objet dans DigiRisk
	 *
	 * @var string
	 */
	public $element_prefix = 'LR';

	/**
	 * La fonction appelée automatiquement avant la création de l'objet dans la base de donnée
	 *
	 * @var array
	 */
	protected $before_put_function = array( '\digi\construct_identifier' );

	/**
	 * La fonction appelée automatiquement après la récupération de l'objet dans la base de donnée
	 *
	 * @var array
	 */
	protected $after_get_function = array( '\digi\get_identifier' );

	/**
	 * Le nom pour le resgister post type
	 *
	 * @var string
	 */
	protected $post_type_name = 'Listing des risques';

	/**
	 * Le nom de l'ODT sans l'extension; exemple: document_unique
	 *
	 * @var string
	 */
	protected $odt_name = 'listing-risk';

	/**
	 * Charges la liste des documents de type "Listing de risque".
	 *
	 * @since 6.5.0
	 * @version 6.5.0
	 *
	 * @param  integer $society_id L'ID de la société.
	 *
	 * @return void
	 */
	public function display( $society_id ) {
		$element = $this->get( array(
			'schema' => true,
		), true );

		\eoxia\View_Util::exec( 'digirisk', 'risk', 'listing-risk/main', array(
			'element'    => $element,
			'element_id' => $society_id,
		) );
	}

	/**
	 * Appelle le template list.view.php dans le dossier view/risk/listing-risk/ du module.
	 *
	 * @since 6.5.0
	 * @version 6.5.0
	 *
	 * @param int $element_id L'ID de l'élement.
	 *
	 * @return void
	 */
	public function display_document_list( $element_id ) {
		$list_document = $this->get( array(
			'post_parent' => $element_id,
			'post_status' => array( 'publish', 'inherit' ),
		) );

		\eoxia\View_Util::exec( 'digirisk', 'risk', 'listing-risk/list', array(
			'list_document' => $list_document,
		) );
	}

	/**
	 * Cette méthode construit les données pour générer un ODT listing de risque.
	 *
	 * @since 6.5.0
	 * @version 6.5.0
	 *
	 * @param int    $society_id L'ID de la société.
	 * @param string $type       Doit être "photos" ou "actions".
	 *
	 * @return array
	 */
	public function generate( $society_id, $type ) {
		$response = array(
			'creation_response' => null,
			'element'           => null,
			'success'           => false,
		);

		if ( empty( $society_id ) || empty( $type ) ) {
			return $response;
		}

		$society = Group_Class::g()->get( array(
			'id' => $society_id,
		), true );

		$data_to_document = $this->prepare_skeleton();
		$data_to_document = $this->set_risks( $data_to_document, $society );
		$data_to_document = apply_filters( 'digi_generate_listing_risk_details', $data_to_document );

		$document_creation_response = $this->create_document( $society, array( 'liste_des_risques_' . $type ), $data_to_document );

		$response['creation_response'] = $document_creation_response;
		$response['element']           = $society;
		$response['success']           = true;

		return $response;
	}

	/**
	 * Prépares un squelette des données
	 *
	 * Cette méthode permet de définir des chaines de caractères vide dans l'ODT si les données ne sont pas présente.
	 *
	 * @since 6.5.0
	 * @version 6.5.0
	 *
	 * @return array {
	 *         Le squelette des données
	 * }
	 */
	public function prepare_skeleton() {
		$skeleton = array(
			'risq' => array(
				'type'  => 'segment',
				'value' => array(),
			),
		);

		$level_list = array( 48, 51, 80 );
		foreach ( $level_list as $level ) {
			$skeleton[ 'risq' . $level ] = array(
				'type'  => 'segment',
				'value' => array(),
			);
		}

		return $skeleton;
	}

	/**
	 * Récupères les risques dans la société ainsi que les risques enfants.
	 *
	 * @since 6.5.0
	 * @version 6.5.0
	 *
	 * @param array       $data_to_document Les données à construire dans le document.
	 * @param Group_Model $element          L'objet groupement.
	 *
	 * @return array Les risques dans la société ainsi que les risques enfants.
	 */
	public function set_risks( $data_to_document, $element ) {
		$list_risk        = Group_Class::g()->get_element_tree_risk( $element );
		$risk_per_element = array();

		if ( count( $list_risk ) > 1 ) {
			usort( $list_risk, function( $a, $b ) {
				if ( $a['quotationRisque'] === $b['quotationRisque'] ) {
					return 0;
				}
				return ( $a['quotationRisque'] > $b['quotationRisque'] ) ? -1 : 1;
			} );
		}

		if ( ! empty( $list_risk ) ) {
			foreach ( $list_risk as $risk ) {
				$final_level = ! empty( Evaluation_Method_Class::g()->list_scale[ $risk['niveauRisque'] ] ) ? evaluation_method_class::g()->list_scale[ $risk['niveauRisque'] ] : '';
				$data_to_document[ 'risq' . $final_level ]['value'][] = $risk;

				if ( ! isset( $risk_per_element[ $risk['idElement'] ] ) ) {
					$risk_per_element[ $risk['idElement'] ]['quotationTotale'] = 0;
				}

				$risk_per_element[ $risk['idElement'] ]['quotationTotale'] += $risk['quotationRisque'];
			}
		}

		$element_sub_tree = Group_Class::g()->get_element_sub_tree( $element, '', array(
			'default' => array( 'quotationTotale' => 0 ),
			'value'   => $risk_per_element,
		) );

		if ( count( $element_sub_tree ) > 1 ) {
			usort( $element_sub_tree, function( $a, $b ) {
				if ( $a['quotationTotale'] === $b['quotationTotale'] ) {
					return 0;
				}
				return ( $a['quotationTotale'] > $b['quotationTotale'] ) ? -1 : 1;
			} );
		}

		return $data_to_document;
	}
}

Listing_Risk_Class::g();
