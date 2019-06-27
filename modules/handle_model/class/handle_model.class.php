<?php
/**
 * Gestion des modèles ODT personnalisés.
 *
 * @author    Evarisk <dev@evarisk.com>
 * @copyright (c) 2006 2018 Evarisk <dev@evarisk.com>.
 *
 * @license   AGPLv3 <https://spdx.org/licenses/AGPL-3.0-or-later.html>
 *
 * @package   DigiRisk\Classes
 *
 * @since     6.1.0
 */

namespace digi;

defined( 'ABSPATH' ) || exit;

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
		'duer'                    			=> array(
			'title' => 'Document unique',
			'class' => '\digi\DUER_Class',
		),
		'duer_mu'                            => array(
			'title' => 'Document unique Mu',
			'class' => '\digirisk_dashboard\DUER_Class',
		),
		'sheet_groupment'                    => array(
			'title' => 'Groupement',
			'class' => '\digi\Sheet_Groupment_Class',
		),
		'sheet_workunit' => array(
			'title' => 'Unité de travail',
			'class' => '\digi\Sheet_Workunit_Class',
		),
		'affichage_legal_A3'                => array(
			'title' => 'Affichage légal A3',
			'class' => '\digi\legal_display_A3_class',
		),
		'affichage_legal_A4'                =>  array(
			'title' => 'Affichage légal A4',
			'class' => '\digi\legal_display_A4_class',
		),
		'diffusion_informations_A3'         => array(
			'title' => 'Diffusion informations A3',
			'class' => '\digi\Diffusion_Informations_A3_Class',
		),
		'diffusion_informations_A4'         => array(
			'title' => 'Diffusion informations A4',
			'class' => '\digi\Diffusion_Informations_A4_Class',
		),
		'accident_benin'                    =>  array(
			'title' => 'Accident de travail bénin',
			'class' => '\digi\Accident_Class',
		),
		'registre_at_benin'                 => array(
			'title' => 'Registre accidents de travail bénin',
			'class' => '\digi\Registre_AT_Benin_Class',
		),
	);

	/**
	 * Le constructeur
	 */
	protected function construct() {}

	/**
	 * Appelle la vue main.view.php pour afficher la gestion des modèles personnalisés.
	 *
	 * @since 6.1.0
	 */
	public function display() {
		$list_document_default = array();

		if ( ! empty( $this->list_type_document ) ) {
			foreach ( $this->list_type_document as $key => $element ) {
				$list_document_default[ $key ] = $element['class']::g()->get_default_model( $key );
			}
		}

		\eoxia\View_Util::exec( 'digirisk', 'handle_model', 'main', array(
			'list_type_document'    => $this->list_type_document,
			'list_document_default' => $list_document_default,
		) );
	}

	/**
	 * Ajoutes le fichier dans le dossier document_template.
	 * Puis génère le POST du fichier.
	 *
	 * @since 6.3.0
	 *
	 * @param string $type      Le type du fichier.
	 * @param string $file_path Le chemin courant du fichier.
	 *
	 * @return boolean
	 */
	public function upload_model( $type, $file_path ) {
		\eoxia\LOG_Util::log( sprintf( 'upload_model -> Start: pour le site %1$d', get_current_blog_id() ), 'digirisk' );

		// Upload le fichier vers le dossier ./wp-content/uploads/digirisk/document_template/.
		$upload_dir             = wp_upload_dir();
		$document_template_path = str_replace( '\\', '/', $upload_dir['basedir'] ) . '/digirisk/document_template/';
		$mkdir_status           = wp_mkdir_p( $document_template_path );
		$mkdir_status_string    = $mkdir_status ? 'true' : 'false';
		\eoxia\LOG_Util::log( sprintf( 'upload_model -> Création du dossier %1$s avec le status %2$s pour le site %3$d', $document_template_path, $mkdir_status_string, get_current_blog_id() ), 'digirisk' );

		$attachment_current_path = str_replace( $upload_dir['baseurl'], $upload_dir['basedir'], $file_path );
		$document_template_path .= basename( $file_path );

		\eoxia\LOG_Util::log( sprintf( 'upload_model -> Tentative de copie: %1$s vers %2$s', $attachment_current_path, $document_template_path ), 'digirisk' );

		$copy_status        = copy( $attachment_current_path, $document_template_path );
		$copy_status_string = $copy_status ? 'true' : 'false';

		\eoxia\LOG_Util::log( sprintf( 'upload_model -> Résultat: cp status %1$s => %2$s vers %3$s', $copy_status_string, $attachment_current_path, $document_template_path ), 'digirisk' );

		if ( ! $copy_status ) {
			return false;
		}

		$end_guid = 'digirisk/document_template/' . basename( $document_template_path );
		$guid     = $upload_dir['baseurl'] . $end_guid . '/';

		// Génère les données du média.
		$document_args = array(
			'post_content' => '',
			'post_status'  => 'inherit',
			'post_author'  => get_current_user_id(),
			'post_date'    => current_time( 'mysql', 0 ),
			'post_title'   => basename( $document_template_path ),
			'guid'         => $guid,
		);
		$response      = array();

		\eoxia\LOG_Util::log( sprintf( 'upload_model -> Début: Insertion de l\'attachement %1$s avec le chemin %2$s', wp_json_encode( $document_args ), $document_template_path ), 'digirisk' );
		$response['id'] = wp_insert_attachment( $document_args, $end_guid, 0 );
		\eoxia\LOG_Util::log( sprintf( 'upload_model -> Fin: Insertion attachement ID %1$d', $response['id'] ), 'digirisk' );

		$attach_data = wp_generate_attachment_metadata( $response['id'], $document_template_path );
		wp_update_attachment_metadata( $response['id'], $attach_data );
		wp_set_object_terms( $response['id'], array( $type, 'default_model', 'model' ), Document_Class::g()->attached_taxonomy_type );
		$response['model_path'] = $document_template_path;
		Document_Class::g()->update( $response );

		\eoxia\LOG_Util::log( sprintf( 'upload_model -> Upload du modèle: %1$s vers %2$s', $attachment_current_path, $document_template_path ), 'digirisk' );

		\eoxia\LOG_Util::log( sprintf( 'upload_model -> Fin: pour le site %1$d', get_current_blog_id() ), 'digirisk' );

		return true;
	}
}

Handle_Model_Class::g();
