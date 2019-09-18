<?php
/**
 * Gestion des actions des causeries.
 *
 * @author    Evarisk <dev@evarisk.com>
 * @since     6.5.0
 * @version   6.6.0
 * @copyright 2018 Evarisk.
 * @package   DigiRisk
 */

namespace digi;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Gestion des actions des causeries
 */
class Causerie_Action {

	/**
	 * Le constructeur appelle une action personnalisée
	 * Il appelle également les actions ajax suivantes
	 */
	public function __construct() {
		add_action( 'wp_ajax_edit_causerie', array( $this, 'ajax_edit_causerie' ) );
		add_action( 'wp_ajax_load_edit_causerie', array( $this, 'ajax_load_edit_causerie' ) );
		add_action( 'wp_ajax_delete_causerie', array( $this, 'ajax_delete_causerie' ) );

		add_action( 'wp_ajax_digi_import_causeries', array( $this, 'callback_digi_import_causeries' ) );
		add_action( 'wp_ajax_get_text_from_url', array( $this, 'callback_get_text_from_url' ) );

		add_action( 'wp_ajax_import_this_picture_tomedia', array( $this, 'callback_import_this_picture_tomedia' ) );
		add_action( 'wp_ajax_import_this_txt_totextarea', array( $this, 'callback_import_this_txt_totextarea' ) );

		add_action( 'wp_ajax_execute_this_txt_totextarea', array( $this, 'callback_execute_this_txt_totextarea' ) );

		add_action( 'wp_ajax_execute_git_txt', array( $this, 'callback_execute_git_txt' ) );
		add_action( 'wp_ajax_ia_import_txt_from_url', array( $this, 'callback_ia_import_txt_from_url' ) );


	}

	/**
	 * Sauvegardes un causerie ainsi que ses images et la liste des commentaires.
	 *
	 * Appelle la méthode "generate" de "Sheet_Causerie_Class" afin de générer l'ODT.
	 *
	 * @since   6.6.0
	 */
	public function ajax_edit_causerie() {
		check_ajax_referer( 'edit_causerie' );

		$id               = ! empty( $_POST['id'] ) ? (int) $_POST['id'] : 0;
		$title            = ! empty( $_POST['title'] ) ? sanitize_text_field( $_POST['title'] ) : '';
		$description      = ! empty( $_POST['description'] ) ? $_POST['description'] : '';
		$category_risk_id = ! empty( $_POST['risk_category_id'] ) ? (int) $_POST['risk_category_id'] : 0;
		$image_id         = ! empty( $_POST['image'] ) ? (int) $_POST['image'] : 0;

		$causerie = Causerie_Class::g()->get( array( 'id' => $id ), true );

		$causerie->data['title']                            = $title;
		$causerie->data['content']                          = $description;
		$causerie->data['taxonomy']['digi-category-risk'][] = $category_risk_id;

		if ( empty( $id ) && ! empty( $image_id ) && empty( $causerie->data['thumbnail_id'] ) ) {
			$causerie->data['thumbnail_id']                      = (int) $image_id;
			$causerie->data['associated_document_id']['image'][] = (int) $image_id;
		}

		$causerie = Causerie_Class::g()->update( $causerie->data );

		$response = Sheet_Causerie_Class::g()->prepare_document( $causerie );
		Sheet_Causerie_Class::g()->create_document( $response['document']->data['id'] );

		$causerie = Causerie_Class::g()->get( array( 'id' => $causerie->data[ 'id' ] ), true );
		ob_start();
		Causerie_Page_Class::g()->display_form();
		wp_send_json_success( array(
			'namespace'        => 'digirisk',
			'module'           => 'causerie',
			'callback_success' => 'editedCauserieSuccess',
			'view'             => ob_get_clean(),
		) );
	}

	/**
	 * Charges un causerie ainsi que ses images et la liste des commentaires.
	 *
	 * @since   6.6.0
	 */
	public function ajax_load_edit_causerie() {
		check_ajax_referer( 'ajax_load_edit_causerie' );

		$id = ! empty( $_POST['id'] ) ? (int) $_POST['id'] : 0; // WPCS: input var ok.

		if ( empty( $id ) ) {
			wp_send_json_error();
		}

		$causerie = Causerie_Class::g()->get( array(
			'id' => $id,
		), true );

		$causerie->data['risk_category'] = Risk_Category_Class::g()->get( array(
			'id' => end( $causerie->data['taxonomy'][ Risk_Category_Class::g()->get_type() ] ),
		), true );

		ob_start();
		\eoxia\View_Util::exec( 'digirisk', 'causerie', 'form/item-edit', array(
			'causerie' => $causerie,
		) );

		wp_send_json_success( array(
			'namespace'        => 'digirisk',
			'module'           => 'causerie',
			'callback_success' => 'loadedCauserieSuccess',
			'view'             => ob_get_clean(),
		) );
	}

	/**
	 * Passes le status de l'causerie en "trash".
	 *
	 * @since   6.6.0
	 */
	public function ajax_delete_causerie() {
		check_ajax_referer( 'ajax_delete_causerie' );

		$id = ! empty( $_POST['id'] ) ? (int) $_POST['id'] : 0; // WPCS: input var ok.

		if ( empty( $id ) ) {
			wp_send_json_error();
		}

		$causerie = Causerie_Class::g()->get( array(
			'id' => $id,
		), true );

		if ( empty( $causerie ) ) {
			wp_send_json_error();
		}

		$causerie->data['status'] = 'trash';

		Causerie_Class::g()->update( $causerie->data );

		wp_send_json_success( array(
			'namespace'        => 'digirisk',
			'module'           => 'causerie',
			'callback_success' => 'deletedAccidentSuccess',
		) );
	}

	public function callback_digi_import_causeries(){
		check_ajax_referer( 'digi_import_causeries' );

		$content = ! empty( $_POST ) && ! empty( $_POST['content'] ) ? trim( $_POST['content'] ) : null;

		if ( null === $content ) {
			wp_send_json_error( array( 'message' => __( 'Le contenu de l\'import est vide', 'digirisk' ) ) );
		}

		$response = Causerie_Class::g()->treat_content_import_causerie( $content );

		ob_start();
		Causerie_Page_Class::g()->display_form();
		wp_send_json_success( array(
			'namespace'        => 'digirisk',
			'module'           => 'causerie',
			'callback_success' => 'editedCauserieSuccess',
			'view'             => ob_get_clean(),
			'data'             => $response
		) );
	}

	public function callback_get_text_from_url(){
		$content = ! empty( $_POST ) && ! empty( $_POST['content'] ) ? trim( $_POST['content'] ) : null;
		// $content = file_get_contents( $link );
		if( ! $content ){
			wp_send_json_error();
		}

		$response = Causerie_Class::g()->download_repos_from_git_hub( $content );
		$view = "";
		if( $response[ 'success' ] ){
			$args = array(
				'picture' => array(),
				'txt'     => array()
			);

			foreach( $response[ 'data' ] as $key => $element ){
				if( $element[ 'type' ] == "file"){
					if( pathinfo( $element[ 'name' ] )[ 'extension' ] == "jpg" || pathinfo( $element[ 'name' ] )[ 'extension' ] == "png" ){
						$data = array(
							'key' => $key,
							'name' => $element[ 'name' ]
						);
						array_push( $args[ 'picture' ], $data );
					}else if( pathinfo( $element[ 'name' ] )[ 'extension' ] == "txt" ){
						$data = array(
							'key' => $key,
							'name' => $element[ 'name' ],
							'url'  => $element[ 'download_url' ]
						);

						array_push( $args[ 'txt' ], $data );
					}
				}
			}

			ob_start();
			Causerie_Class::g()->display_gitview( $response[ 'data' ], $args );
			$view = ob_get_clean();
		}

		wp_send_json_success(
			array(
				'namespace'        => 'digirisk',
				'module'           => 'causerie',
				'callback_success' => 'getContentFromUrl',
				'content'          => $content,
				'response_git'     => $response,
				'view'             => $view
			)
		);
	}

	public function callback_import_this_picture_tomedia(){
		check_ajax_referer( 'import_this_picture_tomedia' );

		$url      = isset( $_POST[ 'url' ] ) ? sanitize_text_field( $_POST[ 'url' ] ) : '';
		$filename = isset( $_POST[ 'filename' ] ) ? sanitize_text_field( $_POST[ 'filename' ] ) : '';

		if( ! $url || ! $filename ){
			wp_send_json_error( 'Url or Filename missing' );
		}

		$id_media = Causerie_class::g()->upload_to_wordpress_library( $url, $filename );
		$link = "";
		$text_info = esc_html__( 'Erreur dans l\'import :(', 'digirisk' );
		$content = "";

		if( $id_media > 0 ){
			$content = "%media%" . get_the_title( $id_media );
			$link = admin_url() .  '/upload.php?item=' . $id_media;
			$text_info = esc_html__( 'Media importé avec succés !', 'digirisk' );
		}

		wp_send_json_success(
			array(
				'namespace'        => 'digirisk',
				'module'           => 'causerie',
				'callback_success' => 'importPictureToMediaSuccess',
				'id'               => $id_media,
				'link'             => $link,
				'text_info'        => $text_info,
				'content'          => $content
			)
		);
	}

	public function callback_import_this_txt_totextarea(){
		check_ajax_referer( 'import_this_txt_totextarea' );
		$url     = isset( $_POST[ 'url' ] ) ? sanitize_text_field( $_POST[ 'url' ] ) : '';

		if( ! $url  ){
			wp_send_json_error( 'Url missing' );
		}

		$content = file_get_contents( $url );
		$content = mb_convert_encoding( $content, 'UTF-8', mb_detect_encoding( $content, 'UTF-8, ISO-8859-1', true ) ); // pour les accents

		if( $content != "" ){
			$text_info = esc_html__( 'Texte importé avec succés !', 'digirisk' );
		}else{
			$text_info = esc_html__( 'Erreur dans l\'import :(', 'digirisk' );
		}


		wp_send_json_success(
			array(
				'namespace'        => 'digirisk',
				'module'           => 'causerie',
				'callback_success' => 'importTxtToTextareaSuccess',
				'content'          => $content,
				'text_info'        => $text_info
			)
		);
	}

	public function callback_execute_this_txt_totextarea( $url = "" ){

		$url = isset( $_POST[ 'url' ] ) ? sanitize_text_field( $_POST[ 'url' ] ) : '';
		$git_file = isset( $_POST[ 'git' ] ) ? $_POST[ 'git' ] : 'nono';

		if( ! $url  ){
			wp_send_json_error( 'URL manquant' );
		}

		$content = file_get_contents( $url );
		$content = mb_convert_encoding($content, 'UTF-8', mb_detect_encoding($content, 'UTF-8, ISO-8859-1', true)); // pour les accents

		$text_error  = "";
		$view        = "";
		$view_footer = "";
		if( $content != "" ){
			$info = Causerie_Class::g()->check_if_content_is_correct( $content, $git_file );
			ob_start();
			\eoxia\View_Util::exec( 'digirisk', 'causerie', 'form/modal-content-execute', array(
				'lines' => $info,
			) );
			$view = ob_get_clean();

			ob_start();
			\eoxia\View_Util::exec( 'digirisk', 'causerie', 'form/modal-footer-execute', array() );
			$view_footer = ob_get_clean();
		}else{
			$text_error = esc_html__( 'Erreur dans l\'import :(', 'digirisk' );
		}

		wp_send_json_success(
			array(
				'namespace'        => 'digirisk',
				'module'           => 'causerie',
				'callback_success' => 'executeTxtToTextareaSuccess',
				'content'          => $content,
				'view'             => $view,
				'view_footer'      => $view_footer
			)
		);
	}
	public function callback_execute_git_txt(){
		check_ajax_referer( 'execute_git_txt' );
		$content = ! empty( $_POST ) && ! empty( $_POST['content'] ) ? trim( $_POST['content'] ) : null;

		if ( null === $content ) {
			wp_send_json_error( array( 'message' => __( 'Le contenu de l\'import est vide', 'digirisk' ) ) );
		}

		$response = Causerie_Class::g()->treat_content_import_causerie( $content );

		ob_start();
		Causerie_Page_Class::g()->display_form();
		wp_send_json_success( array(
			'namespace'        => 'digirisk',
			'module'           => 'causerie',
			'callback_success' => 'executeGitTxtSuccess',
			'view'             => ob_get_clean(),
			'data'             => $response
		) );
	}

	public function callback_ia_import_txt_from_url(){
		check_ajax_referer( 'execute_git_txt' );
		$content = ! empty( $_POST ) && ! empty( $_POST['content'] ) ? trim( $_POST['content'] ) : null;


	}
}

new Causerie_Action();
