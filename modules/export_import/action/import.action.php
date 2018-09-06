<?php
/**
 * Gestion de l'imporation des données de DigiRisk.
 *
 * @author Jimmy Latour <jimmy@evarisk.com>
 * @since 6.1.9
 * @version 6.4.3
 * @copyright 2015-2017
 * @package DigiRisk
 */

namespace digi;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Gestion de l'imporation des données de DigiRisk.
 */
class Import_Action extends \eoxia\Singleton_Util {

	/**
	 * Le chemin vers le dossier export de WordPress.
	 *
	 * @var string
	 */
	private $destination_directory;

	/**
	 * Le tableau des réponses des requêtes AJAX.
	 *
	 * @var array
	 */
	public static $response;

	/**
	 * Initialise l'action digi_import_data
	 * Initialise l'attribut $destination_directory.
	 *
	 * @since 6.1.9
	 * @version 6.4.3
	 *
	 * @return void
	 */
	protected function construct() {
		add_action( 'wp_ajax_digi_import_data', array( $this, 'callback_import_data' ) );

		$wp_upload_dir               = wp_upload_dir();
		$this->destination_directory = $wp_upload_dir['basedir'] . '/digirisk/export/';

		wp_mkdir_p( $this->destination_directory );
	}

	/**
	 * Fonction de rappel pour l'importation des données
	 *
	 * @since 6.1.9
	 * @version 6.4.3
	 */
	public function callback_import_data() {
		check_ajax_referer( 'digi_import_data' );
		ini_set( 'memory_limit', '-1' );

		self::$response = array(
			'message' => __( 'Digirisk datas imported successfully', 'digirisk' ),
		);

		if ( empty( $_POST['path_to_json'] ) ) {
			if ( empty( $_FILES ) || empty( $_FILES['file'] ) ) {
				wp_send_json_error();
			}

			// \eoxia\LOG_Util::log( 'Création catégorie de risque, recommendation et évaluation de méthode par défaut.', 'digirisk' );
			// $danger_created            = Risk_Category_Default_Data_Class::g()->create();
			// $recommendation_created    = Recommendation_Default_Data_Class::g()->create();
			// $evaluation_method_created = Evaluation_Method_Default_Data_Class::g()->create();
			//
			// // Met à jours l'option pour dire que l'installation est terminée.
			// update_option( \eoxia\Config_Util::$init['digirisk']->core_option, array(
			// 	'installed'  => true,
			// 	'db_version' => 1,
			// ) );

			$current_version_for_update_manager = (int) str_replace( '.', '', \eoxia\Config_Util::$init['digirisk']->version );

			// version * 10 car le module de mise à jour parse les mises à jour à faire grâce à des versions à 4 chiffres.
			if ( 3 === strlen( $current_version_for_update_manager ) ) {
				$current_version_for_update_manager *= 10;
			}

			update_option( \eoxia\Config_Util::$init['digirisk']->key_last_update_version, $current_version_for_update_manager );

			$zip_file = $_FILES['file'];

			$zip_info = \eoxia\ZIP_Util::g()->unzip( $zip_file['tmp_name'], $this->destination_directory );
			if ( ! $zip_info['state'] && empty( $zip_info['list_file'][0] ) ) {
				wp_send_json_error();
			}

			$path_to_json = $this->destination_directory . $zip_info['list_file'][0];
		} else {
			$path_to_json = sanitize_text_field( $_POST['path_to_json'] );
		}

		self::$response['path_to_json'] = str_replace( '\\\\', '/', str_replace( '\\', '/', $path_to_json ) );
		$file_content                   = file_get_contents( $path_to_json );
		$data                           = json_decode( $file_content, true );

		self::$response['count_element'] = \eoxia\Array_Util::g()->count_recursive( $data, true, array(
			'list_group',
			'list_workunit',
			'danger',
			'comment',
			'list_risk',
			'danger_category',
			'evaluation_method',
			'variable',
			'evaluation',
		) ) + 1;

		self::$response['index_element'] = (int) $_POST['index_element'];

		\eoxia\LOG_Util::log( wp_json_encode( self::$response ), 'digirisk' );

		Import_Class::g()->create( $data );

		wp_send_json_success( self::$response );
	}

	/**
	 * Réponses de la requête XHR
	 *
	 * @since 6.1.9
	 * @version 6.4.3
	 *
	 * @param  boolean $end True ou false.
	 * @return void
	 * @todo: Que fait cette méthode ?
	 */
	public function fast_response( $end = false ) {
		self::$response['end'] = $end;
		if ( self::$response['end'] ) {
			// Tools_Class::g()->reset_method_evaluation();
		}
		wp_send_json_success( self::$response );
	}
}

Import_Action::g();
