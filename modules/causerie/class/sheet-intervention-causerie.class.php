<?php
/**
 * La classe gérant les feuilles de causeries "intervention"
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
class Sheet_Causerie_Intervention_Class extends Sheet_Causerie_Class {

	/**
	 * Le nom du modèle
	 *
	 * @var string
	 */
	protected $model_name = '\digi\Sheet_Causerie_Intervention_Model';

	/**
	 * Le post type
	 *
	 * @var string
	 */
	protected $type = 'sheet-causerie-inter';

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
	protected $base = 'digi-sheet-intervention-causerie';

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
	public $element_prefix = 'FCI';

	/**
	 * Le nom pour le resgister post type
	 *
	 * @var string
	 */
	protected $post_type_name = 'Fiche causerie intervention';

	/**
	 * Le nom de l'ODT sans l'extension; exemple: document_unique
	 *
	 * @var string
	 */
	protected $odt_name = 'causerie_securite';

	/**
	 * Cette méthode génère la fiche de causerie
	 *
	 * @since   6.6.0
	 * @version 6.6.0
	 *
	 * @param integer $causerie_id L'ID de la causerie.
	 */
	public function generate( $causerie_id ) {
		$causerie_intervention = Causerie_Intervention_Class::g()->get( array( 'id' => $causerie_id ), true );
		$causerie              = Causerie_Class::g()->get( array( 'id' => $causerie_intervention->parent_id ), true );

		$causerie_intervention->former['rendered'] = (array) $causerie_intervention->former['rendered'];

		$sheet_details = array(
			'cleCauserie'         => $causerie_intervention->unique_key,
			'cleFinalCauserie'    => $causerie_intervention->second_unique_key,
			'titreCauserie'       => $causerie_intervention->title,
			'categorieINRS'       => $causerie_intervention->risk_category->name,
			'descriptionCauserie' => $causerie_intervention->content,
			'formateur'           => $causerie_intervention->former['rendered']['displayname'],
			'formateurSignature'  => $this->set_picture( $causerie_intervention->former['signature_id'], 5 ),
			'dateDebutCauserie'   => $causerie_intervention->date_start['date_human_readable'],
			'dateClotureCauserie' => $causerie_intervention->date_end['date_human_readable'],
			'nombreCauserie'      => $causerie->number_time_realized,
			'dateCreation'        => $causerie->date['date_input']['fr_FR']['date'],
			'nombreFormateur'     => $causerie->number_formers,
			'nombreUtilisateur'   => $causerie->number_participants
		);


		$sheet_details = wp_parse_args( $sheet_details, $this->set_medias( $causerie_intervention ) );
		$sheet_details = wp_parse_args( $sheet_details, $this->set_users( $causerie_intervention ) );

		add_filter( 'digi_document_identifier', array( Sheet_Causerie_Filter::g(), 'callback_digi_document_identifier' ), 10, 2 );
		$document_creation_response = $this->create_document( $causerie_intervention, array( $this->odt_name ), $sheet_details );

		return array(
			'creation_response' => $document_creation_response,
			'element'           => $causerie_intervention,
			'success'           => true,
		);
	}
}

Sheet_Causerie_Intervention_Class::g();
