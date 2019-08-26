<?php
/**
 * La classe gérant les feuilles du plan de prevention
 *
 * @author    Evarisk <dev@evarisk.com>
 * @since     6.6.0
 * @version   6.6.0
 * @copyright 2018 Causerie.
 * @package   DigiRisk
 */

namespace digi;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * La classe gérant les feuilles de causeries "intervention"
 */
class Sheet_Prevention_Class extends Document_Class {

	/**
	 * Le nom du modèle
	 *
	 * @var string
	 */
	protected $model_name = '\digi\Sheet_Prevention_Model';

	/**
	 * Le post type
	 *
	 * @var string
	 */
	protected $type = 'sheet-prevention';

	/**
	 * Le type du document
	 *
	 * @var string
	 */
	public $attached_taxonomy_type = 'attachment_category';

	/**
	 * La route pour accéder à l'objet dans la rest API
	 *
	 * @var string
	 */
	protected $base = 'digi-sheet-prevention';

	/**
	 * La version de l'objet
	 *
	 * @var string
	 */
	protected $version = '0.1';

	/**
	 * La clé principale du modèle
	 *
	 * @var string
	 */
	protected $meta_key = '_wpdigi_document';

	/**
	 * Le préfixe de l'objet dans DigiRisk
	 *
	 * @var string
	 */
	public $element_prefix = 'FP';

	/**
	 * Le nom pour le resgister post type
	 *
	 * @var string
	 */
	protected $post_type_name = 'Fiche prevention';

	/**
	 * Le nom de l'ODT sans l'extension; exemple: document_unique
	 *
	 * @var string
	 */
	protected $odt_name = 'prevention_securite';

	/**
	 * Cette méthode génère la fiche du plan de prévention
	 *
	 * @since   6.6.0
	 * @version 6.6.0
	 *
	 * @param integer $prevention_id L'ID de la causerie.
	 */
	public function generate( $prevention_id ) {/*
		$prevention = Prevention_Class::g()->get( array( 'id' => $prevention_id ), true );

		$sheet_details = array(
			'IDdate_start_intervention_PPP' => 'ALJBHDZIJDZIPBDP', // 'dateDebutPrevention'
			't' => 'ALJBHDZIJDZIPBDP', // 'dateDebutPrevention'
			'dateCloturePrevention' => 'dzqdq',
			'formateur' => '',
			'formateurSignature' => '',
			'maitreOeuvre' => '',
			'maitreOeuvreSignature' => '',
			'intervenantExterieur' => '',
			'intervenantExterieurSignature' => '',
			'intervenants' => array(),
			'titrePrevention' => '',
			'interventions' => array(),
		);

		echo '<pre>'; print_r( $this->set_medias( $prevention ) ); echo '</pre>';
		echo '<pre>'; print_r( '- - -' ); echo '</pre>';
		echo '<pre>'; print_r( $this->set_users( $prevention ) ); echo '</pre>';
		echo '<pre>'; print_r( '- - -' ); echo '</pre>';
		$sheet_details = wp_parse_args( $sheet_details, $this->set_medias( $prevention ) );
		$sheet_details = wp_parse_args( $sheet_details, $this->set_users( $prevention ) );

		echo '<pre>'; print_r( $sheet_details ); echo '</pre>'; exit;

		// add_filter( 'digi_document_identifier', array( Sheet_Prevention_Filter::g(), 'callback_digi_document_identifier_prevention' ), 10, 2 );
		$document_creation_response = $this->create_document( $prevention, array( $this->odt_name ), $sheet_details );

		return array(
			'creation_response' => $document_creation_response,
			'element'           => $prevention,
			'success'           => true,
		);*/
	}
}

Sheet_Prevention_Class::g();
