<?php
/**
 * Gères la génération de l'ODT: accident travail benin
 *
 * @author Jimmy Latour <jimmy@evarisk.com>
 * @since 6.3.0
 * @version 6.4.0
 * @copyright 2015-2017
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
	protected $post_type = 'accident_benin';

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
	protected $post_type_name = 'Accident travail benin';

	/**
	 * Le nom de l'ODT sans l'extension; exemple: document_unique
	 *
	 * @var string
	 */
	protected $odt_name = 'accident_benin';

	/**
	 * Appelle le template main.view.php dans le dossier /view/
	 *
	 * @return void
	 *
	 * @since 6.3.0
	 * @version 6.3.0
	 */
	public function display() {
		$element = $this->get( array(
			'schema' => true,
		), true );

		\eoxia\View_Util::exec( 'digirisk', 'accident', 'document/main', array(
			'element' => $element,
		) );
	}

	/**
	 * Appelle le template list.view.php dans le dossier /view/
	 *
	 * @return void
	 *
	 * @since 6.3.0
	 * @version 6.3.0
	 */
	public function display_document_list() {
		$list_document = $this->get( array(
			'post_status' => array(
				'publish',
				'inherit',
			),
		) );
		\eoxia\View_Util::exec( 'digirisk', 'accident', 'document/list', array(
			'list_document' => $list_document,
		) );
	}

	/**
	 * Cette méthode génère l'accident de travail bénin
	 *
	 * @since 6.3.0
	 * @version 6.3.0
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
		$address = $address[0];

		$sheet_details = array(
			'raisonSociale' => $main_society->title,
			'adresse' => $address->address . ' ' . $address->additional_address . ' ' . $address->postcode . ' ' . $address->town,
			'telephone' => ! empty( $element->contact['phone'] ) ? max( $element->contact['phone'] ) : '',
			'siret' => $main_society->siret_id,
			'email' => $main_society->contact['email'],
			'effectif' => $main_society->number_of_employees,
		);

		$accident = Accident_Class::g()->get( array(
			'id' => $accident_id,
		), true );

		$sheet_details = wp_parse_args( $sheet_details, $this->set_accident( $accident ) );

		$document_creation_response = $this->create_document( $accident, array( 'accident_benin' ), $sheet_details );

		return array(
			'creation_response' => $document_creation_response,
			'success' => true,
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
			'dateInscriptionRegistre' => $accident->registration_date_in_register['date_input']['fr_FR']['date'],
			'nomPrenomMatriculeVictime' => ! empty( $accident->victim_identity->id ) ? User_Digi_Class::g()->element_prefix . $accident->victim_identity->id . ' ' . $accident->victim_identity->login : '',
			'dateHeure' => $accident->accident_date['date_input']['fr_FR']['date_time'],
			'lieu' => $accident->place,
			'circonstances' => $comment_content,
			'siegeLesions' => $accident->location_of_lesions,
			'natureLesions' => $accident->nature_of_lesions,
			'nomAdresseTemoins' => $accident->name_and_address_of_witnesses,
			'nomAdresseTiers' => $accident->name_and_address_of_third_parties_involved,
			'signatureDonneurSoins' => $this->get_picture( ! empty( $accident->associated_document_id['signature_of_the_caregiver_id'][0] ) ? $accident->associated_document_id['signature_of_the_caregiver_id'][0] : 0 ),
			'signatureVictime' => $this->get_picture( ! empty( $accident->associated_document_id['signature_of_the_victim_id'][0] ) ? $accident->associated_document_id['signature_of_the_victim_id'][0] : 0 ),
			'observations' => $accident->observation,
			'enqueteAccident' => ! empty( $accident->associated_document_id['accident_investigation_id'][0] ) ? __( 'Oui', 'digirisk' ) : __( 'Non', 'digirisk' ),
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
					'size' => 3,
				),
			);
		}

		return $picture;
	}
}

Accident_Travail_Benin_Class::g();
