<?php
/**
 * Classe gérant les diffusions d'informations
 *
 * @author    Evarisk <dev@evarisk.com>
 * @since     6.2.10
 * @version   6.6.0
 * @copyright 2018 Evarisk.
 * @package   DigiRisk
 */

namespace digi;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Classe gérant les diffusions d'informations
 */
class Diffusion_Informations_Class extends \eoxia\Post_Class {

	/**
	 * Le nom du modèle
	 *
	 * @var string
	 */
	protected $model_name = '\digi\Diffusion_Informations_Model';

	/**
	 * Le post type
	 *
	 * @var string
	 */
	protected $post_type = 'digi-diffusion-info';

	/**
	 * La clé principale du modèle
	 *
	 * @var string
	 */
	protected $meta_key = '_wpdigi_diffusion_information';

	/**
	 * La route pour accéder à l'objet dans la rest API
	 *
	 * @var string
	 */
	protected $base = 'diffusion-information';

	/**
	 * La version de l'objet
	 *
	 * @var string
	 */
	protected $version = '0.1';

	/**
	 * La fonction appelée automatiquement avant la création de l'objet dans la base de donnée
	 *
	 * @var array
	 */
	protected $before_post_function = array( '\digi\construct_identifier' );

	/**
	 * La fonction appelée automatiquement après la récupération de l'objet dans la base de donnée
	 *
	 * @var array
	 */
	protected $after_get_function = array( '\digi\get_identifier' );

	/**
	 * Le préfixe de l'objet dans DigiRisk
	 *
	 * @var string
	 */
	public $element_prefix = 'DI';

	/**
	 * Le nom pour le resgister post type
	 *
	 * @var string
	 */
	protected $post_type_name = 'Diffusion information';

	/**
	 * Appelle la vue "main".
	 *
	 * @since 6.4.4
	 * @version 6.4.4
	 *
	 * @param  integer $element_id L'ID de l'élement.
	 * @return void
	 */
	public function display( $element_id ) {
		$element = Society_Class::g()->show_by_type( $element_id );

		\eoxia\View_Util::exec( 'digirisk', 'diffusion_informations', 'main', array(
			'element' => $element,
		) );
	}

	/**
	 * Appelle le template list.view.php dans le dossier /diffusion_informations/view/
	 *
	 * @param  integer $element_id L'ID de l'élement.
	 * @return void
	 *
	 * @since 6.2.10
	 * @version 6.2.10
	 */
	public function display_document_list( $element_id ) {
		$list_document = Diffusion_Informations_A3_Class::g()->get( array(
			'post_parent' => $element_id,
			'post_status' => array(
				'publish',
				'inherit',
			),
		) );

		$list_document = array_merge( $list_document, Diffusion_Informations_A4_Class::g()->get( array(
			'post_parent' => $element_id,
			'post_status' => array(
				'publish',
				'inherit',
			),
		) ) );

		// Trie le tableau par ordre des clés.
		usort( $list_document, function( $a, $b ) {
			if ( $a->unique_key === $b->unique_key ) {
				return 0;
			}

			return ( $a->unique_key > $b->unique_key ) ? -1 : 1;
		} );

		\eoxia\View_Util::exec( 'digirisk', 'diffusion_informations', 'list', array(
			'list_document' => $list_document,
		) );
	}

	/**
	 * Enregistres les informations de la diffusion d'informations
	 *
	 * @since 6.6.0
	 * @version 6.6.0
	 *
	 * @param array $data Les données provenant du formulaire de l'onglet "Diffusion informations".
	 *
	 * @return void
	 */
	public function save_information( $parent_id, $data ) {
		$data = array(
			'parent_id'     => $parent_id,
			'document_meta' => array(
				'delegues_du_personnels_date'             => ! empty( $data['delegues_du_personnels_date'] ) ? sanitize_text_field( $data['delegues_du_personnels_date'] ) : '',
				'delegues_du_personnels_titulaires'       => ! empty( $data['delegues_du_personnels_titulaires'] ) ? sanitize_text_field( $data['delegues_du_personnels_titulaires'] ) : '',
				'delegues_du_personnels_suppleants'       => ! empty( $data['delegues_du_personnels_suppleants'] ) ? sanitize_text_field( $data['delegues_du_personnels_suppleants'] ) : '',
				'membres_du_comite_entreprise_date'       => ! empty( $data['membres_du_comite_entreprise_date'] ) ? sanitize_text_field( $data['membres_du_comite_entreprise_date'] ) : '',
				'membres_du_comite_entreprise_titulaires' => ! empty( $data['membres_du_comite_entreprise_titulaires'] ) ? sanitize_text_field( $data['membres_du_comite_entreprise_titulaires'] ) : '',
				'membres_du_comite_entreprise_suppleants' => ! empty( $data['membres_du_comite_entreprise_suppleants'] ) ? sanitize_text_field( $data['membres_du_comite_entreprise_suppleants'] ) : '',
			),
		);

		$this->update( $data );
	}

	/**
	 * Le formulaire pour générer une diffusion d'information
	 *
	 * @param  object $element La société.
	 * @return void
	 *
	 * @since 6.2.10
	 * @version 6.4.4
	 */
	public function display_form( $element ) {
		$diffusion_information = $this->get( array(
			'post_parent' => $element->id,
			'post_status' => array(
				'publish',
				'inherit',
			),
		) );

		if ( empty( $diffusion_information ) ) {
			$diffusion_information = $this->get( array(
				'schema' => true,
			) );
		}

		if ( ! empty( $diffusion_information ) ) {
			$diffusion_information = $diffusion_information[0];
		}

		\eoxia\View_Util::exec( 'digirisk', 'diffusion_informations', 'form', array(
			'element_id'            => $element->id,
			'diffusion_information' => $diffusion_information,
		) );
	}

	/**
	 * Génère une fiche de diffusions
	 *
	 * @param  array         $data    Les données du documents.
	 * @param  Society_Model $element La société.
	 * @param  string        $format  Le format de la génération A3 ou A4.
	 * @return void
	 *
	 * @since 6.2.10
	 * @version 6.4.0
	 */
	public function generate_sheet( $data, $element, $format = 'A3' ) {
		$data['delegues_du_personnels_date'] = mysql2date( 'd/m/Y', $data['delegues_du_personnels_date'] );
		$data['membres_du_comite_entreprise_date'] = mysql2date( 'd/m/Y', $data['membres_du_comite_entreprise_date'] );

		$class = '\digi\Diffusion_Informations_' . $format . '_Class';
		$document_creation = $class::g()->create_document( $element, array( 'diffusion_informations_' . $format ), $data );

		$filetype = 'unknown';
		if ( ! empty( $document_creation ) && ! empty( $document_creation['status'] ) && ! empty( $document_creation['link'] ) ) {
			$filetype = wp_check_filetype( $document_creation['link'], null );
		}

		$element->associated_document_id['document'][] = $document_creation['id'];
		Society_Class::g()->update_by_type( $element );
	}

}

Diffusion_Informations_Class::g();
