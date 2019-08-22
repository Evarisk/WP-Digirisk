<?php
/**
 * La classe gérant les causeries
 *
 * @author    Evarisk <dev@evarisk.com>
 * @since     6.6.0
 * @version   6.6.0
 * @copyright 2018 Evarisk.
 * @package   DigiRisk
 */

namespace digi;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * La classe gérant les causeries
 */
class Causerie_Class extends \eoxia\Post_Class {

	/**
	 * Le nom du modèle
	 *
	 * @var string
	 */
	protected $model_name = '\digi\Causerie_Model';

	/**
	 * Le post type
	 *
	 * @var string
	 */
	protected $type = 'digi-causerie';

	/**
	 * La route pour accéder à l'objet dans la rest API
	 *
	 * @var string
	 */
	protected $base = 'causerie';

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
	protected $meta_key = '_wpdigi_causerie';

	/**
	 * Le préfixe de l'objet dans DigiRisk
	 *
	 * @var string
	 */
	public $element_prefix = 'C';

	/**
	 * Le nom pour le resgister post type
	 *
	 * @var string
	 */
	protected $post_type_name = 'Causeries';

	protected function construct() {
		$wp_upload_dir          = wp_upload_dir();
		$this->export_directory = $wp_upload_dir['basedir'] . '/digirisk/tmp/';

		wp_mkdir_p( $this->export_directory );
	}

	public function display_textarea(){
		\eoxia\View_Util::exec( 'digirisk', 'causerie', 'form/modal-content',array() );
	}

	public function display_gitview( $data = array(), $args = array() ){
		\eoxia\View_Util::exec( 'digirisk', 'causerie', 'form/modal-content-git',array(
			'data' => $data,
			'args' => $args
		) );
	}

	public function treat_content_import_causerie( $content ){

		$content_by_lines = preg_split( '/\r\n|\r|\n/', $content );
		$line_error = array();

		if ( ! empty( $content_by_lines ) ) {
			$list_id = array();
			$id_actual = -1;
			foreach ( $content_by_lines as $index => $line ) {
				if ( false !== strpos( strtolower( $line ), '%causerie%' ) ) {
					$line = str_replace( '%causerie%', '', $line );
					$line = str_replace( '%Causerie%', '', $line );
					if( ! empty( $line ) ){
						$create_causerie = Causerie_class::g()->create(
							array(
								'title'   => $line
							)
						);

						$data = array(
							'id' => $create_causerie->data[ 'id' ],
							'title' => $line,
							'description' => '',
							'risque' => array(),
							'media' => array()
						);

						$list_id[ $create_causerie->data[ 'id' ] ] = $data;
						$id_actual = $create_causerie->data[ 'id' ];
					}else{
						$error = array(
							'line' => $line,
							'error' => __( 'Ligne vide', 'digirisk' )
						);
						array_push( $line_error, $error);
					}

				}else if( false !== strpos( strtolower( $line ), '%description%' ) ) {
					$line = str_replace( '%description%', '', $line );
					$line = str_replace( '%Description%', '', $line );
					if( ! empty( $line ) && ! empty( $list_id ) && $id_actual > 0 ){
						$causerie = Causerie_Class::g()->get( array( 'id' => $id_actual ), true );

						$causerie->data[ 'content' ] = $line;
						Causerie_Class::g()->update( $causerie->data );
						$list_id[ $id_actual ][ 'description' ] = $line;
					}else{
						$error = array(
							'line' => $line,
							'error' => __( 'Ligne vide/ Causerie ID invalide', 'digirisk' )
						);
						array_push( $line_error, $error );
					}
				}else if( false !== strpos( strtolower( $line ), '%media%' ) ){
					$line = str_replace( '%media%', '', $line );
					$line = str_replace( '%Media%', '', $line );
					if( ! empty( $line ) && ! empty( $list_id ) && $id_actual > 0 ){
						$live_without_extension = preg_replace('/\\.[^.\\s]{3,4}$/', '', $line);
						$media_query = new \WP_Query(
						    array(
								'title'          => $live_without_extension,
						        'post_type'      => 'attachment',
						        'post_status'    => 'inherit',
						        'posts_per_page' => 1,
						    )
						);

						if( ! empty( $media_query->posts ) ){
							$image_id = $media_query->posts[ 0 ]->ID;
							$causerie->data['thumbnail_id']                      = (int) $image_id;
							$causerie->data['associated_document_id']['image'][] = (int) $image_id;
							Causerie_Class::g()->update( $causerie->data );

							$temp_data = array( 'title' => $line, 'status' => 'success' );
							$list_id[ $id_actual ][ 'media' ][] = $temp_data;
						}else{
							$error = array(
								'line' => $line,
								'error' => __( 'Image introuvable', 'digirisk' )
							);
							array_push( $line_error, $error);

							$temp_data = array( 'title' => $line, 'status' => __( 'Erreur : Media introuvable', 'digirisk' ) );
							$list_id[ $id_actual ][ 'media' ][] = $temp_data;
						}
					}else{
						$error = array(
							'line' => $line,
							'error' => __( 'Ligne vide/ Causerie ID invalide', 'digirisk' )
						);
						array_push( $line_error, $error);
					}

				}else if( false !== strpos( strtolower( $line ), '%risque%' ) ){
					$line = str_replace( '%risque%', '', $line );
					$line = str_replace( '%Risque%', '', $line );
					if( ! empty( $line ) && ! empty( $list_id ) && $id_actual > 0 ){
						$causerie = Causerie_Class::g()->get( array( 'id' => $id_actual ), true );
						$risque = Risk_Category_Class::g()->get( array( 'name' => $line ), true );

						if( ! empty( $risque ) ){
							$causerie->data['taxonomy']['digi-category-risk'][] = $risque->data[ 'id' ];
							Causerie_Class::g()->update( $causerie->data );
							$temp_data = array( 'name' => $risque->data[ 'name' ], 'status' => 'success' );
							$list_id[ $id_actual ][ 'risque' ][] = $temp_data;
						}else{
							$error = array(
								'line'  => $line,
								'error' => sprintf( __( 'Risque introuvable %s', 'digirisk' ), $line )
							);
							array_push( $line_error, $error);

							$temp_data = array( 'name' => $line, 'status' => __( 'Erreur : Risque introuvable', 'digirisk' ) );
							$list_id[ $id_actual ][ 'risque' ][] = $temp_data;
						}
					}else{
						$error = array(
							'line'  => $line,
							'error' => sprintf( __( 'Ligne vide/ Causerie ID invalide : %s', 'digirisk' ), $id_actual )
						);
						array_push( $line_error, $error);
					}
				}else {
					$error = array(
						'line'  => $line,
						'error' => sprintf( __( 'La ligne contient seulement du text', 'digirisk' ) )
					);
					array_push( $line_error, $error);
				}
			}
		}else{
			$error = array(
				'line'  => 'Le text est vide',
				'error' => sprintf( __( 'Text vide', 'digirisk' ) )
			);
			array_push( $line_error, $error);
		}

		foreach( $list_id as $causerie_element ){ // On créait les documents de causerie
			$causerie = Causerie_Class::g()->get( array( 'id' => $causerie_element[ 'id' ] ), true );

			$response = Sheet_Causerie_Class::g()->prepare_document( $causerie );
			Sheet_Causerie_Class::g()->create_document( $response['document']->data['id'] );
		}

		return array( 'list' => $list_id, 'error' => $line_error );
	}

	public function download_repos_from_git_hub( $content ){
		$data_return = array(
			'success' => false,
			'error'   => '',
			'data'    => array()
		);

		if( strpos($content, 'github.com') === false ){
			$data_return[ 'error' ] = 'Link no valid (Need contains github)';
			return $data_return;
		}

		$link = str_replace( 'github.com', 'api.github.com/repos', $content );
		$link = str_replace( 'tree/master', 'contents', $link );
		$link .= '?ref=master';
		$result = $this->github_request_api( $link );
		if( ! $result || empty( $result ) ){
			$data_return[ 'error' ] = 'This url seems not good';
			return $data_return;
		}

		$data_return[ 'data' ] = $result;
		$data_return[ 'success' ] = true;

		return $data_return;
	}

	function github_request_api( $url = "" ){
	    $curl = curl_init();
		curl_setopt( $curl, CURLOPT_URL, $url);
	    curl_setopt( $curl, CURLOPT_RETURNTRANSFER, true);
		curl_setopt( $curl, CURLOPT_SSL_VERIFYHOST, false);
		curl_setopt( $curl, CURLOPT_SSL_VERIFYPEER, false);
		curl_setopt( $curl, CURLOPT_HTTPHEADER, array( 'User-Agent: Eoxia' ));

	    $response = curl_exec( $curl );

	    curl_close( $curl );
	    return json_decode( $response, true );
	}

	public function upload_to_wordpress_library( $image_url, $media_name = "" ){
		require_once(ABSPATH . 'wp-admin/includes/image.php');
		require_once( ABSPATH . '/wp-includes/pluggable.php' );

		$image = $image_url;
	    $get = wp_remote_get( $image );
	    $type = wp_remote_retrieve_header( $get, 'content-type' );

	    if (!$type)
	        return false;

	    $mirror = wp_upload_bits( basename( $image ), '', wp_remote_retrieve_body( $get ) );
	    $attachment = array(
			'guid'           => $mirror['url'] . '/' . $mirror['file'],
	        'post_title'     => $media_name,
			'post_content'   => '',
			'post_status'    => 'inherit',
	        'post_mime_type' => $type
	    );
	    $attach_id = wp_insert_attachment( $attachment, $mirror['file'] );

	    $attach_data = wp_generate_attachment_metadata( $attach_id, $mirror['file'] );

	    wp_update_attachment_metadata( $attach_id, $attach_data );

	    return $attach_id;
	}

	public function check_if_gitelement_is_valid( $element, $key ){
		$data_element = array(
			'key'     => $key,
			'success' => false,
			'info' => ''
		);

		if( empty( $element ) ){
			$data_element[ 'info' ] = esc_html__( 'Element vide', 'digirisk' );
		}

		$data_element[ 'name' ] = isset( $element[ 'name' ] ) ? $element[ 'name' ] : 'No name';
		$data_element[ 'url' ] = isset( $element[ 'url' ] ) ? $element[ 'url' ] : 'No url';
		$data_element[ 'type' ] = isset( $element[ 'type' ] ) ? $element[ 'type' ] : 'No type';
		$data_element[ 'extension' ] = isset( $element[ 'path' ] ) ? pathinfo( $element[ 'path' ] )[ 'extension' ] : 'No path';

		return $data_element;

	}

	public function trad_this_gittype( $type = "", $name = "" ){
		if( ! $type ){
			return '';
		}

		$data = array(
			'type' => $type,
			'extension' => ''
		);

		switch( $type ){
			case 'file' :
				$data[ 'type' ] = esc_html__( 'Fichier', 'digirisk' );
				if( $name ){
					$data[ 'extension' ] = pathinfo( $name )[ 'extension' ];
				}
				break;
			case 'dir' :
				$data[ 'type' ] = esc_html__( 'Dossier', 'digirisk' );
				break;
			default:
				break;
		}
		return $data[ 'type' ] . ' ' . $data[ 'extension' ];
	}

	public function check_if_content_is_correct( $content, $git_file ){
		$lines = preg_split('/\r\n|\n|\r/', $content );
		$data = array();
		foreach( $lines as $key => $line ){
			$temp = array(
				'line'    => $line,
				'type'    => '',
				'error'    => '',
				'info'     => ''
			);

			if( $line != "" ){
				$data_line = $this->check_if_line_is_correct_to_causerie( $line, $git_file );
				if( $data_line[ 'success' ] ){
					if( $data_line[ 'type_valid' ] ){
						$temp[ 'info' ] = $data_line[ 'type_info' ];
					}else{
						$temp[ 'error' ] = $data_line[ 'type_info' ];
					}
				}else{
					$temp[ 'error' ] = esc_html__( 'Ligne invalide', 'digirisk' );
				}
			}else{
				$temp[ 'error' ] = esc_html__( 'Ligne vide', 'digirisk' );
			}
			$data[ $key ] = $temp;
		}

		return $data;
	}

	public function check_if_line_is_correct_to_causerie( $line, $git_file ){
		$line_error = array();
		$data = array(
			'success'    => true,
			'type'       => '',
			'type_valid' => false,
			'type_info'  => ''
		);

		if ( false !== strpos( strtolower( $line ), '%causerie%' ) ) {
			$data[ 'type' ] = 'causerie';
			$data[ 'type_valid' ] = true;
			$data[ 'type_info' ] = esc_html__( 'Causerie valid', 'digirisk' );
		}else if( false !== strpos( strtolower( $line ), '%description%' ) ) {
			$data[ 'type' ] = "description";
			$data[ 'type_valid' ] = true;
			$data[ 'type_info' ] = esc_html__( 'Description valid', 'digirisk' );
		}else if( false !== strpos( strtolower( $line ), '%media%' ) ){ // Si c'est une photo on vérifie qu'elle existe
			$data[ 'type' ] = "media";
			$line = str_replace( '%media%', '', $line );
			$line = str_replace( '%Media%', '', $line );

			$live_without_extension = preg_replace( '/\\.[^.\\s]{3,4}$/', '', $line );
			$media_query = new \WP_Query(
				array(
					'title'          => $live_without_extension,
					'post_type'      => 'attachment',
					'post_status'    => 'inherit',
					'posts_per_page' => 1,
				)
			);

			if( ! empty( $media_query->posts ) ){ // Photo trouvé !
				$data[ 'type_valid' ] = true;
				$data[ 'type_info' ] = esc_html__( 'Media valid', 'digirisk' );
			}else{ // Photo introuvable dans les medias
				if( ! empty( $git_file ) ){ // Check si la photo se trouve dans l'import
					$media_is_in_import = $this->check_if_media_is_in_import( $line, $git_file );
					if( $media_is_in_import ){
						$data[ 'type_info' ] = esc_html__( 'Media trouvé dans l\'import', 'digirisk' );
					}else{
						$data[ 'type_info' ] = esc_html__( 'Media introuvable (gallery et import)', 'digirisk' );
					}
				}else{
					$data[ 'type_info' ] = esc_html__( 'Media introuvable dans la gallery', 'digirisk' );
				}
			}
		}else if( false !== strpos( strtolower( $line ), '%risque%' ) ){
			$data[ 'type' ] = "risque";
			$line = str_replace( '%risque%', '', $line );
			$line = str_replace( '%Risque%', '', $line );

			$risque = Risk_Category_Class::g()->get( array( 'name' => $line ), true );
			if( ! empty( $risque ) ){
				$data[ 'type_valid' ] = true;
				$data[ 'type_info' ] = esc_html__( 'Risque valide', 'digirisk' );
			}else{
				$data[ 'type_info' ] = esc_html__( 'Risque introuvable', 'digirisk' );
			}
		}else{
			$data[ 'success' ] = false; // Type introuvable / pas pris en compte
		}

		return $data;
	}

	public function check_if_media_is_in_import( $line, $git_file ){
		foreach( $git_file as $element ){
			if( $element[ 'name' ] == $line ){
				return true;
			}
		}
		return false;
	}
}

Causerie_Class::g();
