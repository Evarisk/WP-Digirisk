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

	public function treat_content_import_causerie( $content ){

		$content_by_lines = preg_split( '/\r\n|\r|\n/', $content );
		$line_error = array();

		if ( ! empty( $content_by_lines ) ) {
			$list_id = array();
			$id_actual = -1;
			foreach ( $content_by_lines as $index => $line ) {
				if ( false !== strpos( $line, '%causerie%' ) ) {
					$line = str_replace( '%causerie%', '', $line );
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

				}else if( false !== strpos( $line, '%description%' ) ) {
					$line = str_replace( '%description%', '', $line );
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
				}else if( false !== strpos( $line, '%media%' ) ){
					$line = str_replace( '%media%', '', $line );
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

				}else if( false !== strpos( $line, '%risque%' ) ){
					$line = str_replace( '%risque%', '', $line );
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
}

Causerie_Class::g();
