<?php if ( !defined( 'ABSPATH' ) ) exit;
/**
 * Fichier du controlleur pour la gestion des utilisateurs / Main controller file for users management
 *
 * @author Evarisk development team <dev@evarisk.com>
 * @version 6.0
 */

/**
 * Classe du controlleur principal pour la gestion des utilisateurs / Main controller class for users management
 *
 * @author Evarisk development team <dev@evarisk.com>
 * @version 6.0
 */

if ( !class_exists( 'wpdigi_file_action_01' ) ) {
	class wpdigi_file_action_01 {
	   public function __construct() {
       /**	AJAX listener	*/
       add_action( 'wp_ajax_wpeofiles-paginate-files', array( &$this, 'ajax_galery_pagination' ) );
       add_action( 'wp_ajax_wpeo_file_set_thumbnail', array( $this, 'ajax_file_set_thumbnail' ) );
     }

     /**
      * Render file
      * $_POST['array_file_id']
      * $_POST['index']
      * $_POST['limit']
      */
     public function ajax_galery_pagination() {
       $response = array('template' => array(), 'paginate_link' => array());

			 $page_to_get = 1;
			 if( !empty( $_GET['page'] ) )
			 	$page_to_get = (int) $_GET['page'];

				if ( 0 === (int) $_GET['limit'] )
					wp_send_json_error();
				else {
					$limit = (int) $_GET['limit'];
				}

	     $index = $page_to_get * $limit;
	     $index -= $limit;

			 if( !is_array( $_GET['file_list_association'] ) )
			 	wp_die();
			else {
				$file_list_association = $_GET['file_list_association'];
			}

	     $array_file_id 			= explode( ',', $file_list_association );
	     $number_page 			= ceil( count( $array_file_id ) / $limit );
	     $files 					= array_slice( $array_file_id, !empty( $page_to_get ) ? $index : 0, $limit );
	     parse_str( $_SERVER[ 'QUERY_STRING' ], $params );
	     unset( $params[ 'page' ] );

	     ob_start();
	     require( wpdigi_utils::get_template_part( WPEOMTM_FILES_DIR, WPEOMTM_FILES_TEMPLATES_MAIN_DIR, "backend", "file", "list") );
	     $response['template'] = ob_get_clean();

	     $args_paginate_links = array(
	       'total' 	=> $number_page,
	       'current'	=> $page_to_get,
	       'base'	=> admin_url( 'admin-ajax.php?' . http_build_query( $params ) . '%_%' ),
	       'format'	=> '&page=%#%',
	       'prev_text' => '<i class="dashicons dashicons-arrow-left" ></i>',
	       'next_text' => '<i class="dashicons dashicons-arrow-right" ></i>',
	     );

	     $response['paginate_link'] = paginate_links($args_paginate_links);

	     wp_die( json_encode( $response ) );
     }

     public function ajax_file_set_thumbnail() {
			 if ( 0 === (int) $_POST['element_id'] )
				 wp_send_json_error();
			 else {
				 $element_id = (int) $_POST['element_id'];
			 }

			 if ( 0 === (int) $_POST['thumbnail_id'] )
				 wp_send_json_error();
			 else {
				 $thumbnail_id = (int) $_POST['thumbnail_id'];
			 }

       set_post_thumbnail( $element_id, $thumbnail_id );

       ob_start();
       echo get_the_post_thumbnail( $element_id, 'digirisk-element-miniature' );
       $template = ob_get_clean();

       wp_send_json_success( array( 'template' => $template ) );
     }
	}

	global $wpdigi_file_action;
	$wpdigi_file_action = new wpdigi_file_action_01();
}
