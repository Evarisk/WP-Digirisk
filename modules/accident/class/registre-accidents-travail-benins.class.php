<?php
/**
 * Gères la génération de l'ODT: Registre Accidents de travail benins
 *
 * @author Jimmy Latour <jimmy@evarisk.com>
 * @since 6.3.0
 * @version 6.3.0
 * @copyright 2015-2017
 * @package DigiRisk
 */

namespace digi;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Gères la génération de l'ODT: Registre Accidents de travail benins
 */
class Registre_Accidents_Travail_Benins_Class extends \eoxia\Post_Class {

	/**
	 * Le nom du modèle
	 *
	 * @var string
	 */
	protected $model_name = '\digi\Registre_Accidents_Travail_Benins_Model';

	/**
	 * Le post type
	 *
	 * @var string
	 */
	protected $post_type = 'accidents_benin';

	/**
	 * Le type du document
	 *
	 * @var string
	 */
	public $attached_taxonomy_type  = 'attachment_category';

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
	protected $base = 'registre-accidents-travail-benins';

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
	public $element_prefix = 'RATB';

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
	protected $post_type_name = 'Registre Accidents de Travail Benins';

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
		$main_society = Society_Class::g()->get( array(
			'posts_per_page' => 1,

		), true );
		$list_document = $this->get( array(
			'post_parent' => $main_society->id,
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
	 * @return array
	 *
	 * @since 6.3.0
	 * @version 6.3.0
	 */
	public function generate() {
		$main_society = Society_Class::g()->get( array(
			'posts_per_page' => 1,
		), true );

		$sheet_details = array(
			'raisonSociale' => $main_society->title,
			'adresse' => '',
			'telephone' => $main_society->telephone,
			'siret' => $main_society->siret_id,
			'email' => $main_society->email,
			'effectif' => $main_society->number_of_employees,
		);

		$sheet_details = wp_parse_args( $sheet_details, $this->set_accidents() );

		$document_creation_response = document_class::g()->create_document( $main_society, array( 'accidents_benin' ), $sheet_details );

		return array(
			'creation_response' => $document_creation_response,
			'success' => true,
		);
	}

	/**
	 * Récupères les accidents
	 *
	 * @return array Les accidents
	 *
	 * @since 6.3.0
	 * @version 6.3.0
	 */
	public function set_accidents() {
		$accidents = Accident_Class::g()->get();

		$accident_details = array(
			'accidentDebut' => array(
				'type' => 'segment',
				'value' => array(),
			),
			'accidentFin' => array(
				'type' => 'segment',
				'value' => array(),
			),
		);

		if ( ! empty( $accidents ) ) {
			foreach ( $accidents as $element ) {
				$comments = get_comments( array(
					'post_id' => $element->id,
					'status' => -34070,
				) );

				$comment_content = '';

				if ( ! empty( $comments ) ) {
					foreach ( $comments as $comment ) {
						$comment_content .= $comment->comment_content . '
';
					}
				}

				$accident_details['accidentDebut']['value'][] = array(
					'ref' => $element->unique_identifier,
					'dateInscriptionRegistre' => $element->registration_date_in_register,
					'nomPrenomMatriculeVictime' => ! empty( $element->victim_identity->id ) ? User_Digi_Class::g()->element_prefix . $element->victim_identity->id . ' ' . $element->victim_identity->login : '',
					'dateHeure' => $element->accident_date,
					'lieu' => $element->place,
					'circonstances' => $comment_content,
					'siegeLesions' => $element->location_of_lesions,
				);

				$accident_details['accidentFin']['value'][] = array(
					'ref' => $element->unique_identifier,
					'natureLesions' => $element->nature_of_lesions,
					'nomAdresseTemoins' => $element->name_and_address_of_witnesses,
					'nomAdresseTiers' => $element->name_and_address_of_third_parties_involved,
					'signatureDonneurSoins' => $this->get_picture( ! empty( $element->associated_document_id['name_and_signature_of_the_caregiver_id'][0] ) ? $element->associated_document_id['name_and_signature_of_the_caregiver_id'][0] : 0 ),
					'signatureVictime' => $this->get_picture( ! empty( $element->associated_document_id['signature_of_the_victim_id'][0] ) ? $element->associated_document_id['signature_of_the_victim_id'][0] : 0 ),
					'observations' => $element->observation,
				);
			}
		}

		return $accident_details;
	}

	/**
	 * A supprimer
	 * @param  [type] $id [description]
	 * @return [type]     [description]
	 */
	public function get_picture( $id ) {
		$picture = '';

		$picture_definition = wp_get_attachment_image_src( $id, 'thumbnail' );
		$picture_path = str_replace( site_url( '/' ), ABSPATH, $picture_definition[0] );

		if ( is_file( $picture_path ) ) {
			$picture = array(
				'type'		=> 'picture',
				'value'		=> str_replace( site_url( '/' ), ABSPATH, $picture_definition[0] ),
				'option'	=> array(
					'size' => 3,
				),
			);
		}

		return $picture;
	}
}

Accident_Travail_Benin_Class::g();
