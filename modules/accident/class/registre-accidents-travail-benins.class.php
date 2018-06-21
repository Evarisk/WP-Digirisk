<?php
/**
 * Gères la génération de l'ODT: Registre Accidents de travail benins
 *
 * @author    Evarisk <dev@evarisk.com>
 * @since     6.3.0
 * @version   7.0.0
 * @copyright 2018 Evarisk.
 * @package   DigiRisk
 */

namespace digi;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Gères la génération de l'ODT: Registre Accidents de travail benins
 */
class Registre_Accidents_Travail_Benins_Class extends Document_Class {

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
	protected $type = 'accidents_benin';

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
	 * Le nom pour le resgister post type
	 *
	 * @var string
	 */
	protected $post_type_name = 'Registre Accidents de Travail Benins';

	/**
	 * Le nom de l'ODT sans l'extension; exemple: document_unique
	 *
	 * @var string
	 */
	protected $odt_name = 'registre_accidents_travail_benins';

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
	 * @version 7.0.0
	 */
	public function display_document_list() {
		$main_society = Society_Class::g()->get( array(
			'posts_per_page' => 1,
		), true );

		$list_document = $this->get( array(
			'post_parent' => $main_society->data['id'],
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
	 * Cette méthode génère le registre AT bénins.
	 *
	 * @since   6.3.0
	 * @version 7.0.0
	 *
	 * @param Society_Model $main_society La société.
	 * @return array
	 */
	public function generate( $main_society ) {
		$address = Society_Class::g()->get_address( $main_society );

		$sheet_details = array(
			'ref'           => self::g()->element_prefix . (int) ( Identifier_Filter::get_last_unique_key( '\digi\Registre_Accidents_Travail_Benins_Class' ) + 1 ),
			'raisonSociale' => $main_society->data['title'],
			'adresse'       => $address->data['address'] . ' ' . $address->data['additional_address'] . ' ' . $address->data['postcode'] . ' ' . $address->data['town'],
			'telephone'     => ! empty( $main_society->data['contact']['phone'] ) ? end( $main_society->data['contact']['phone'] ) : '',
			'siret'         => $main_society->data['siret_id'],
			'email'         => $main_society->data['contact']['email'],
			'effectif'      => $main_society->data['number_of_employees'],
		);

		$sheet_details = wp_parse_args( $sheet_details, $this->set_accidents() );

		$sheet_details_log = $sheet_details;
		$sheet_details_log = \wp_json_encode( $sheet_details_log );
		$sheet_details_log = addslashes( $sheet_details_log );
		$sheet_details_log = preg_replace_callback( '/\\\\u([0-9a-f]{4})/i', function ( $matches ) {
			$sym = mb_convert_encoding( pack( 'H*', $matches[1] ), 'UTF-8', 'UTF-16' );
			return $sym;
		}, $sheet_details_log );

		\eoxia\LOG_Util::log( $sheet_details_log, 'digirisk' );
		$document_creation_response = $this->create_document( $main_society, array( 'registre_accidents_travail_benins' ), $sheet_details );

		return array(
			'creation_response' => $document_creation_response,
			'success'           => true,
		);
	}

	/**
	 * Récupères les accidents
	 *
	 * @return array Les accidents
	 *
	 * @since 6.3.0
	 * @version 6.5.0
	 */
	public function set_accidents() {
		$accidents = Accident_Class::g()->get( array(
			'posts_per_page' => -1,
			'order'          => 'ASC',
		) );

		$accident_details = array(
			'accidentDebut' => array(
				'type'  => 'segment',
				'value' => array(),
			),
			'accidentFin' => array(
				'type'  => 'segment',
				'value' => array(),
			),
		);

		if ( ! empty( $accidents ) ) {
			foreach ( $accidents as $element ) {
				$comments = get_comments( array(
					'post_id' => $element->id,
					'status'  => -34070,
				) );

				$comment_content = '';

				if ( ! empty( $comments ) ) {
					foreach ( $comments as $comment ) {
						$comment_content .= $comment->comment_content . '
';
					}
				}

				$accident_details['accidentDebut']['value'][] = array(
					'ref'                       => $element->unique_identifier,
					'dateInscriptionRegistre'   => $element->registration_date_in_register['rendered']['date'],
					'nomPrenomMatriculeVictime' => ! empty( $element->victim_identity->id ) ? User_Digi_Class::g()->element_prefix . $element->victim_identity->id . ' ' . $element->victim_identity->login : '',
					'dateHeure'                 => $element->accident_date['rendered']['date_time'],
					'lieu'                      => $element->place->modified_unique_identifier . ' ' . $element->place->title,
					'circonstances'             => $comment_content,
					'siegeLesions'              => $element->location_of_lesions,
				);

				$accident_details['accidentFin']['value'][] = array(
					'ref'                   => $element->unique_identifier,
					'natureLesions'         => $element->nature_of_lesions,
					'nomAdresseTemoins'     => $element->name_and_address_of_witnesses,
					'nomAdresseTiers'       => $element->name_and_address_of_third_parties_involved,
					'signatureDonneurSoins' => $this->get_picture( ! empty( $element->associated_document_id['signature_of_the_caregiver_id'][0] ) ? $element->associated_document_id['signature_of_the_caregiver_id'][0] : 0 ),
					'signatureVictime'      => $this->get_picture( ! empty( $element->associated_document_id['signature_of_the_victim_id'][0] ) ? $element->associated_document_id['signature_of_the_victim_id'][0] : 0 ),
					'observations'          => $element->observation,
				);
			}
		}

		return $accident_details;
	}

	/**
	 * Récupères le thumbnail de l'attachment.
	 *
	 * @since 6.4.0
	 * @version 6.4.0
	 *
	 * @param  integer $id L'ID de l'attchment.
	 * @return array       Les données pour l'ODT.
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
					'size' => 4,
				),
			);
		}

		return $picture;
	}
}

Accident_Travail_Benin_Class::g();
