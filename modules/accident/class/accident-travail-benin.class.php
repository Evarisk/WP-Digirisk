<?php
/**
 * Gères la génération de l'ODT: accident travail benin
 *
 * @author Evarisk <dev@evarisk.com>
 * @since 6.3.0
 * @version 7.0.0
 * @copyright 2015-2018
 * @package DigiRisk
 */

namespace digi;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Gères la génération de l'ODT: accident travail benin
 */
class Accident_Travail_Benin_Class extends Document_Class {

	/**
	 * Le nom du modèle
	 *
	 * @var string
	 */
	protected $model_name = '\digi\Accident_Travail_Benin_Model';

	/**
	 * Le post type
	 *
	 * @var string
	 */
	protected $type = 'accident_benin';

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
	protected $base = 'accident-travail-benin';

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
	public $element_prefix = 'AT';

	/**
	 * Le nom pour le resgister post type
	 *
	 * @var string
	 */
	protected $post_type_name = 'Accident travail benin';

	/**
	 * Le nom de l'ODT sans l'extension; exemple: document_unique
	 *
	 * @var string
	 */
	protected $odt_name = 'accident_benin';

	/**
	 * Cette méthode génère l'accident de travail bénin
	 *
	 * @since 6.3.0
	 * @version 6.5.0
	 *
	 * @param integer $accident_id L'ID de l'accident.
	 * @return array {
	 *      @type array   $creation_response Les données retournées par la méthode 'create_document' de la classe 'Document'.
	 *      @type boolean $success           Tout s'est bien déroulé.
	 * }
	 */
	public function generate( $accident_id ) {
		$main_society = Society_Class::g()->get( array(
			'posts_per_page' => 1,
		), true );

		$address = Society_Class::g()->get_address( $main_society );

		$sheet_details = array(
			'raisonSociale' => $main_society->title,
			'adresse'       => $address->address . ' ' . $address->additional_address . ' ' . $address->postcode . ' ' . $address->town,
			'telephone'     => ! empty( $main_society->contact['phone'] ) ? max( $main_society->contact['phone'] ) : '',
			'siret'         => $main_society->siret_id,
			'email'         => $main_society->contact['email'],
			'effectif'      => $main_society->number_of_employees,
		);

		$accident = Accident_Class::g()->get( array(
			'id' => $accident_id,
		), true );

		$sheet_details = wp_parse_args( $sheet_details, $this->set_accident( $accident ) );

		$document_creation_response = $this->create_document( $accident, array( 'accident_benin' ), $sheet_details );

		return array(
			'creation_response' => $document_creation_response,
			'success'           => true,
		);
	}

	/**
	 * Récupères les détailles d'un accident.
	 *
	 * @param Object $accident L'objet accident.
	 *
	 * @return array Les détailes pour la génération du document.
	 *
	 * @since 6.3.0
	 * @version 6.3.0
	 *
	 * @todo: Document_Class::set_picture.
	 * @todo: Utiliser cette fonction pour éviter le duplicat dans l'autre génération.
	 */
	public function set_accident( $accident ) {
		$comments = get_comments( array(
			'post_id' => $accident->id,
			'status' => -34070,
		) );

		$comment_content = '';

		if ( ! empty( $comments ) ) {
			foreach ( $comments as $comment ) {
				$comment_content .= $comment->comment_content . '
';
			}
		}

		$accident_details = array(
			'ref' => $accident->unique_identifier,
			'dateInscriptionRegistre' => $accident->registration_date_in_register['rendered']['date'],
			'nomPrenomMatriculeVictime' => ! empty( $accident->victim_identity->id ) ? User_Digi_Class::g()->element_prefix . $accident->victim_identity->id . ' ' . $accident->victim_identity->login : '',
			'dateHeure' => $accident->accident_date['rendered']['date_time'],
			'lieu' => $accident->place->modified_unique_identifier . ' ' . $accident->place->title,
			'circonstances' => $comment_content,
			'siegeLesions' => $accident->location_of_lesions,
			'natureLesions' => $accident->nature_of_lesions,
			'nomAdresseTemoins' => $accident->name_and_address_of_witnesses,
			'nomAdresseTiers' => $accident->name_and_address_of_third_parties_involved,
			'signatureDonneurSoins' => $this->get_picture( ! empty( $accident->associated_document_id['signature_of_the_caregiver_id'][0] ) ? $accident->associated_document_id['signature_of_the_caregiver_id'][0] : 0 ),
			'signatureVictime' => $this->get_picture( ! empty( $accident->associated_document_id['signature_of_the_victim_id'][0] ) ? $accident->associated_document_id['signature_of_the_victim_id'][0] : 0 ),
			'observations' => $accident->observation,
			'enqueteAccident' => $accident->have_investigation ? __( 'Oui', 'digirisk' ) : __( 'Non', 'digirisk' ),
		);

		return $accident_details;
	}

	/**
	 * Récupères la définition de l'image.
	 *
	 * @param  integer $id L'ID du post de type image.
	 *
	 * @return array Les données de l'image.
	 *
	 * @since 6.3.0
	 * @version 6.4.0
	 */
	public function get_picture( $id ) {
		$picture = '';

		$picture_definition = wp_get_attachment_image_src( $id, array( 300, 150 ) );
		$picture_path = str_replace( site_url( '/' ), ABSPATH, $picture_definition[0] );

		if ( is_file( $picture_path ) ) {
			$picture = array(
				'type' => 'picture',
				'value' => str_replace( site_url( '/' ), ABSPATH, $picture_definition[0] ),
				'option' => array(
					'size' => 6,
				),
			);
		}

		return $picture;
	}
}

Accident_Travail_Benin_Class::g();
