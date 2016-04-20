<?php if ( !defined( 'ABSPATH' ) ) exit;
/**
 * Main controller file for files module
 *
 * @author Eoxia development team <dev@eoxia.com>
 * @version 1.0
 */

/**
 * Main controller class for files module
 *
 * @author Eoxia development team <dev@eoxia.com>
 * @version 1.0
 */
class wpeoTMFilesController {

	/**
	 * CORE - Instanciate task management
	 */
	function __construct() {
		/**	Call style for administration	*/
		add_action( 'admin_enqueue_scripts', array( &$this, 'admin_css' ) );

		/**	Include the different javascript	*/
		add_action( 'admin_enqueue_scripts', array(&$this, 'admin_js') );
		add_action( 'admin_print_scripts', array(&$this, 'admin_printed_js') );

		/**	SHORTCODE listener	*/
		add_shortcode( 'wpeofiles', array( &$this, 'shortcode_display_file' ) );
		add_shortcode( 'wpeo_gallery', array( &$this, 'shortcode_gallery' ) );

		/**	AJAX listener	*/
		add_action( 'wp_ajax_wpeofiles-associate-files', array( &$this, 'ajax_associate_file_to_element' ) );
		add_action( 'wp_ajax_wpeofiles-paginate-files', array( &$this, 'ajax_galery_pagination' ) );

		add_action( 'wp_ajax_wpeo_file_set_thumbnail', array( $this, 'ajax_file_set_thumbnail' ) );
	}

	/**
	 * WORDPRESS HOOK - ADMIN STYLES - Include stylesheets
	 */
	function admin_css() {
		wp_register_style( 'wpeofiles-styles', WPEOMTM_FILES_URL . '/assets/css/backend.css', '', WPEOMTM_FILES_VERSION );
		wp_enqueue_style( 'wpeofiles-styles' );
	}

	/**
	 * WORDPRESS HOOK - ADMIN JAVASCRIPTS - Load the different javascript librairies
	 */
	function admin_js() {
		wp_enqueue_media();
		wp_enqueue_script( 'wpeofiles-scripts', WPEOMTM_FILES_URL . '/assets/js/backend.js', '', WPEOMTM_FILES_VERSION );
	}

	/**
	 * WORDPRESS HOOK - ADMIN INLINE JAVASCRIPTS - Print javascript (dynamic js content) instruction into html code head.
	 */
	function admin_printed_js() {
		require_once( wpdigi_utils::get_template_part( WPEOMTM_FILES_DIR, WPEOMTM_FILES_TEMPLATES_MAIN_DIR, "backend", "header.js" ) );
	}


	/**
	 * SHORTCODE - Display associated files list for a given element from a shortcode
	 *
	 * @param array $args The list of arguments passed through shortcode call
	 */
	function shortcode_display_file( $params ) {
		$files = array();
		$element_thumbnail_id = null;
		$display_file_type = null;

		/**	Check if there is a list of element given or if we have to get the list of associated medias from database	*/
		if ( !empty( $params[ 'file_list_association' ] ) ) {
			$files = explode( ',', $params[ 'file_list_association' ] );
		}

		/**	Check if there is a thumbnail identifier setted */
		if ( !empty( $params[ 'thumbnail_id' ] ) ) {
			$element_thumbnail_id = (int)$params[ 'thumbnail_id' ];
		}

		/**	Check if there is a file type defined for dispay	*/
		if ( !empty( $params[ 'type' ]) ) {
			$display_file_type = $params[ 'type' ];
		}

		if ( empty( $files ) ) {
			$element_type = !empty( $params ) && !empty( $params[ 'data-type' ] ) ? $params[ 'data-type' ] : null;
			switch ( $element_type ) {
				case 'post':
				default:
					$files = $this->post_dedupe_associated_files( $params[ 'element-id' ], $files );

					$element_thumbnail_id = get_post_thumbnail_id( $params[ 'element-id' ] );
					$element_thumbnail_display = get_the_post_thumbnail( $params[ 'element-id' ], ( !empty( $params[ 'thumbnail_size' ] ) ? $params[ 'thumbnail_size' ] : 'thumbnail' ), array( 'class' => 'wp-digi-element-thumbnail wp-digi-element-thumbnail-gallery', ) );
				break;
			}
		}

		if ( empty( $params[ 'file_list_association' ] ) ) {
			$params[ 'file_list_association' ] = implode( ',', $files );
		}

		/** Array slice */
		$number_page 	= ceil( count( $files) / $params['limit'] );
		$files				= array_slice( $files, 0, $params['limit'] );

		rsort( $files );

		$args_paginate_links = array(
			'total' 	=> $number_page,
			'current'	=> 1,
			'base'	=> admin_url( 'admin-ajax.php?' . http_build_query( $params ) . '%_%' ),
			'format'	=> '&page=%#%',
			'prev_text' => '<i class="dashicons dashicons-arrow-left" ></i>',
			'next_text' => '<i class="dashicons dashicons-arrow-right" ></i>',
		);

		ob_start();
		require( wpdigi_utils::get_template_part( WPEOMTM_FILES_DIR, WPEOMTM_FILES_TEMPLATES_MAIN_DIR, "backend", "file", ( !empty( $params ) && !empty( $params[ 'output_type' ] ) ? $params[ 'output_type' ] : 'list' ) ) );
		$file_list_display = ob_get_contents();
		ob_end_clean();

		echo apply_filters( "wpeo_file_list_display", $file_list_display, $files, $params );
	}

	public function shortcode_gallery( $params ) {
		$element_id = $params['element_id'];
		global ${$params['global']};
		$element = ${$params['global']}->show( $element_id );

		$list_id = !empty( $element->option['associated_document_id']['image'] ) ? $element->option['associated_document_id']['image'] : array();
		$thumbnail_id = $element->thumbnail_id;

		require( wpdigi_utils::get_template_part( WPEOMTM_FILES_DIR, WPEOMTM_FILES_TEMPLATES_MAIN_DIR, "backend", "file-big-gallery" ) );
	}

	/**
	 * Get associated attachment and attachment sended on given element in order to get an unique array without double attachment media
	 *
	 * @param integer $elementID The element identifier to check association for
	 * @param array $file_list The associated attachment
	 *
	 * @return array The final list of medias attached to given element
	 */
	function post_dedupe_associated_files( $post_ID, $file_list ) {
		global $wpdb;
		$associated_files = array();

		$more_where = null;
		if ( !empty( $file_list ) ) {
			$more_where .= "
				AND ID NOT IN ( " . implode( ',', $file_list ) . " )";
		}

		/**	Get all medias attached to given element	*/
		$query = $wpdb->prepare(
			"SELECT GROUP_CONCAT( ID ) AS attachment_list
			FROM {$wpdb->posts}
			WHERE post_type = %s
				AND post_parent = %d
				AND post_status = %s
				" . $more_where . "
			GROUP BY post_parent",
		'attachment', $post_ID, 'inherit' );
		$children_files = $wpdb->get_var( $query );
		if ( !empty( $children_files ) ) {
			$children_files = explode( ",", $children_files );
		}
		else {
			$children_files = array();
		}

		/**	Build the final file list by removing duplicate entries from attached medias and associated medias	*/
		$associated_files = array_merge( $children_files, $file_list );

		return $associated_files;
	}

	/**
	 * GETTER - Get a filename corresponding to an attachment type
	 *
	 * @param integer $post_id The attachment identifier
	 *
	 * @return string The filename corresponding to the given attachement type
	 */
	function get_icon_for_attachment( $post_id, $type = 'dashicons' ) {
		$base = includes_url( 'images/media/' );
		$type = get_post_mime_type( $post_id );
		switch ($type) {
			case 'image/jpeg':
			case 'image/png':
			case 'image/gif':
				$icon_attachment = "dashicons-format-image";
				if ( 'image' == $type ) {
					$icon_attachment = $base . "default.png";
				}
			break;
			case 'video/mpeg':
			case 'video/mp4':
			case 'video/quicktime':
				$icon_attachment = "dashicons-media-video";
				if ( 'image' == $type ) {
					$icon_attachment = $base . "video.png";
				}
			break;
			case 'text/csv':
			case 'text/plain':
			case 'text/xml':
				$icon_attachment = "dashicons-media-text";
				if ( 'image' == $type ) {
					$icon_attachment = $base . "text.png";
				}
			break;
			default:
				$icon_attachment = "dashicons-media-default";
				if ( 'image' == $type ) {
					$icon_attachment = $base . "default.png";
				}
			break;
		}

		return $icon_attachment;
	}

	/**
	 * Render file
	 * $_POST['array_file_id']
	 * $_POST['index']
	 * $_POST['limit']
	 */
	public function ajax_galery_pagination() {
		$response = array('template' => array(), 'paginate_link' => array());

		$page_to_get = !empty( $_GET ) && !empty( $_GET['page'] ) ? $_GET['page'] : 1;

		$index = $page_to_get * $_GET['limit'];
		$index -= $_GET['limit'];

		$array_file_id 			= explode( ',', $_GET['file_list_association'] );
		$number_page 			= ceil( count( $array_file_id) / $_GET['limit'] );
		$files 					= array_slice( $array_file_id, !empty( $page_to_get ) ? $index : 0, $_GET['limit'] );
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
		set_post_thumbnail( $_POST['element_id'], $_POST['thumbnail_id'] );

		ob_start();
		echo get_the_post_thumbnail( $_POST['element_id'], 'digirisk-element-miniature' );
		$template = ob_get_clean();

		wp_send_json_success( array( 'template' => $template ) );
	}
}
