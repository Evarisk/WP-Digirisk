<?php
/**
 * Gestion des modèles personnalisés
 *
 * @since 6.1.0
 * @version 6.3.0
 *
 * @package Evarisk\Plugin
 */

namespace digi;

if ( ! defined( 'ABSPATH' ) ) { exit; }

/**
 * Gestion des modèles personnalisés
 */
class Handle_Model_Class extends \eoxia\Singleton_Util {

	/**
	 * La liste des documents personnalisables avec leur titre
	 *
	 * @var array
	 */
	private $list_type_document = array(
		'document_unique' => 'Document unique',
		'fiche_de_groupement' => 'Fiche de groupement',
		'fiche_de_poste' => 'Fiche de poste',
		'affichage_legal_A3' => 'Affichage légal A3',
		'affichage_legal_A4' => 'Affichage légal A4',
		'diffusion_informations_A3' => 'Diffusion informations A3',
		'diffusion_informations_A4' => 'Diffusion informations A4',
		'accident_benin' => 'Accident de travail bénin',
		'accidents_benin' => 'Registre accidents de travail bénin',
	);

	/**
	 * Le constructeur
	 *
	 * @return void
	 */
	protected function construct() {}

	/**
	 * Appelle la vue main.view.php pour afficher la gestion des modèles personnalisés.
	 *
	 * @return void
	 */
	public function display() {
		$list_document_default = array();

		if ( ! empty( $this->list_type_document ) ) {
			foreach ( $this->list_type_document as $key => $element ) {
				$list_document_default[ $key ] = Document_Class::g()->get_model_for_element( array( $key, 'model', 'default_model' ) );
			}
		}

		\eoxia\View_Util::exec( 'digirisk', 'handle_model', 'main', array(
			'list_type_document' => $this->list_type_document,
			'list_document_default' => $list_document_default,
		) );
	}

	/**
	 * Ajoutes le fichier dans le dossier document_template.
	 * Puis génère le POST du fichier.
	 *
	 * @since 6.3.0
	 * @version 6.3.0
	 *
	 * @param  string  $type    Le type du fichier.
	 * @param  integer $file_id L'ID du fichier ODT.
	 * @return boolean
	 */
	public function upload_model( $type, $file_id ) {
		// Upload le fichier vers le dossier ./wp-content/uploads/digirisk/document_template/.
		$upload_dir = wp_upload_dir();
		$document_template_path = $upload_dir['basedir'] . '/digirisk/document_template/';
		wp_mkdir_p( $document_template_path );
		$attachment = get_post( $file_id );
		$attachment_current_path = str_replace( $upload_dir['url'], $upload_dir['path'] , $attachment->guid );
		$attachment_copy_path = str_replace( $upload_dir['url'], $document_template_path , $attachment->guid );
		$copy_status = copy( $attachment_current_path, $attachment_copy_path );
		if ( ! $copy_status ) {
			return false;
		}
		// Génère les données du média.
		$document_args = array(
			'post_content' => '',
			'post_status' => 'inherit',
			'post_author' => get_current_user_id(),
			'post_date' => current_time( 'mysql', 0 ),
			'post_title' => $attachment->title,
		);
		$response['id'] = wp_insert_attachment( $document_args, $attachment_copy_path, 0 );
		$attach_data = wp_generate_attachment_metadata( $response['id'], $attachment_copy_path );
		wp_update_attachment_metadata( $response['id'], $attach_data );
		wp_set_object_terms( $response['id'], array( $type, 'default_model', 'model' ), Document_Class::g()->attached_taxonomy_type );
		$response['model_id'] = $attachment_copy_path;
		Document_Class::g()->update( $response );
		return true;
	}
}

Handle_Model_Class::g();
