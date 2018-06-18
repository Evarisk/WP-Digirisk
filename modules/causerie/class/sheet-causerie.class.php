<?php
/**
 * La classe gérant les feuilles de causeries
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
 * La classe gérant les feuilles de causeries
 */
class Sheet_Causerie_Class extends Document_Class {

	/**
	 * Le nom du modèle
	 *
	 * @var string
	 */
	protected $model_name = '\digi\Sheet_Causerie_Model';

	/**
	 * Le post type
	 *
	 * @var string
	 */
	protected $post_type = 'digi-sheet-causerie';

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
	protected $base = 'digi-sheet-causerie';

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
	public $element_prefix = 'FC';

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
	protected $post_type_name = 'Fiche causerie';

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
		$causerie                = Causerie_Class::g()->get( array( 'id' => $causerie_id ), true );
		$causerie->risk_category = Risk_Category_Class::g()->get( array(
			'id' => end( $causerie->taxonomy[ Risk_Category_Class::g()->get_type() ] ),
		), true );

		$sheet_details = array(
			'cleCauserie'         => $causerie->unique_key,
			'cleFinalCauserie'    => __( 'N/A', 'digirisk' ),
			'titreCauserie'       => $causerie->title,
			'categorieINRS'       => $causerie->risk_category->name,
			'descriptionCauserie' => $causerie->content,
			'formateur'           => __( 'N/A', 'digirisk' ),
			'formateurSignature'  => __( 'N/A', 'digirisk' ),
			'dateDebutCauserie'   => __( 'N/A', 'digirisk' ),
			'dateClotureCauserie' => __( 'N/A', 'digirisk' ),
			'nombreCauserie'      => 0,
			'dateCreation'        => $causerie->date['date_input']['fr_FR']['date'],
			'nombreFormateur'     => 0,
			'nombreUtilisateur'   => 0,
		);

		$sheet_details = wp_parse_args( $sheet_details, $this->set_medias( $causerie ) );
		$sheet_details = wp_parse_args( $sheet_details, $this->set_users( $causerie ) );

		$document_creation_response = $this->create_document( $causerie, array( $this->odt_name ), $sheet_details );

		return array(
			'creation_response' => $document_creation_response,
			'element'           => $causerie,
			'success'           => true,
		);
	}

	/**
	 * Remplis les données des médias.
	 *
	 * @since   6.6.0
	 * @version 6.6.0
	 *
	 * @param Causerie_Model $causerie Le modèle de la causerie.
	 *
	 * @return array {
	 *    @type integer nombreMedia       Le nombre de média
	 *    @type string  nomsMediaCauserie Le noms des médias.
	 *    @type array   mediasCauserie    Les images des médias.
	 * }
	 */
	public function set_medias( $causerie ) {
		$data = array(
			'nombreMedia'       => 0,
			'nomsMediaCauserie' => '',
			'mediasCauserie'    => array(
				'type'  => 'segment',
				'value' => array(),
			),
		);

		if ( ! empty( $causerie->associated_document_id['image'] ) ) {
			foreach ( $causerie->associated_document_id['image'] as $image_id ) {
				$data['mediasCauserie']['value'][] = array(
					'mediaCauserie' => $this->set_picture( $image_id ),
				);

				$data['nombreMedia']++;
				$data['nomsMediaCauserie'] .= get_the_title( $image_id ) . ', ';
			}
		}

		$data['nomsMediaCauserie'] = substr( $data['nomsMediaCauserie'], 0, -2 );

		return $data;
	}

	/**
	 * Remplis les données des médias.
	 *
	 * @since   6.6.0
	 * @version 6.6.0
	 *
	 * @param Causerie_Model $causerie Le modèle de la causerie.
	 *
	 * @return array {
	 *    @type integer nombreMedia       Le nombre de média
	 *    @type string  nomsMediaCauserie Le noms des médias.
	 *    @type array   mediasCauserie    Les images des médias.
	 * }
	 */
	public function set_users( $causerie ) {
		$data = array(
			'utilisateurs' => array(
				'type'  => 'segment',
				'value' => array(),
			),
		);

		if ( ! empty( $causerie->participants ) ) {
			foreach ( $causerie->participants as $participant ) {
				$participant['rendered'] = (array) $participant['rendered'];

				$data['utilisateurs']['value'][] = array(
					'nomUtilisateur'    => $participant['rendered']['lastname'],
					'prenomUtilisateur' => $participant['rendered']['firstname'],
					'dateSignature'     => \eoxia\Date_Util::g()->mysqldate2wordpress( $participant['signature_date'] ),
					'signature'         => $this->set_picture( $participant['signature_id'], 5 ),
				);
			}
		}

		return $data;
	}

	/**
	 * Définie l'image du document
	 *
	 * @since   6.6.0
	 * @version 6.6.0
	 *
	 * @param integer $id   L'ID du média.
	 * @param integer $size La taille en CM du media.
	 *
	 * @return string|false|array {
	 *         @type string type   Le type du noeud pour l'ODT.
	 *         @type string value  Le lien vers le media.
	 *         @type array  option {
	 *               @type integer size La taille en CM du media.
	 *         }
	 * }
	 */
	public function set_picture( $id, $size = 9 ) {
		$picture = __( 'No picture defined', 'digirisk' );

		if ( ! empty( $id ) ) {
			$picture_definition = wp_get_attachment_image_src( $id, 'medium' );
			$picture_path       = str_replace( site_url( '/' ), ABSPATH, $picture_definition[0] );

			if ( is_file( $picture_path ) ) {
				$picture = array(
					'type'   => 'picture',
					'value'  => str_replace( site_url( '/' ), ABSPATH, $picture_definition[0] ),
					'option' => array(
						'size' => $size,
					),
				);
			}
		}

		return $picture;
	}
}

Sheet_Causerie_Class::g();
