<?php if ( !defined( 'ABSPATH' ) ) exit;
class wpdigi_utils {

	/* PRODEST:
	{
		"name": "__construct",
		"description": "CORE - Instanciation de la classe / Object instanciation",
		"type": "function",
		"check": true,
		"author":
		{
			"email": "dev@evarisk.com",
			"name": "Alexandre T"
		},
		"version": 0.1
	}
	*/
	function __construct() {}

	/* PRODEST:
	 {
		 "name": "get_template_part",
		 "description": "INTERNAL LIB - Vérifie et récupère si il existe le fichier template pour le bloc a afficher / Check and get the template file path to use for a given display part ",
		 "type": "function",
		 "check": true,
		 "author":
		 {
			 "email": "dev@evarisk.com",
			 "name": "Alexandre T"
		 },
		 "param":
		 {
			 "$plugin_dir_name": {"type": "string", "description": "The main directory name containing the plugin", "default": "null"},
			 "$main_template_dir": {"type": "string", "description": "The main directory containing the templates used for display", "default": "null"},
			 "$side": {"type": "string", "description": "The website part were the template will be displayed. Backend or frontend", "default": "null"},
			 "$slug": {"type": "string", "description": "The slug name for the generic template.", "default": "null"},
			 "$name": {"type": "string", "description": "The name of the specialised template.", "default": "null"}
		 },
		 "return":
		 {
		 	"$path": {"type": "string", "description": "The template file path to use if founded" }
		 },
		 "version": 0.1
	 }
	 */
	static function get_template_part( $plugin_dir_name, $main_template_dir, $side, $slug, $name = null, $debug = null ) {
		$path = '';

		$templates = array();
		$name = (string)$name;
		if ( '' !== $name )
			$templates[] = "{$side}/{$slug}-{$name}.php";
		$templates[] = "{$side}/{$slug}.php";

		/**	Check if required template exists into current theme	*/
		$check_theme_template = array();
		foreach ( $templates as $template ) {
			$check_theme_template = $plugin_dir_name . "/" . $template;
		}
		$path = locate_template( $check_theme_template, false );

		/**	Allow debugging	*/
		if ( !empty( $debug ) ) {
			echo '--- Debug mode - Start ---<br/>';
			echo __FILE__ . '<br/>';
			echo 'Debug for display method<br/>';
		}

		if ( empty( $path ) ) {
			foreach ( (array) $templates as $template_name ) {
				if ( !$template_name )
					continue;

				/**	Allow debugging	*/
				if ( !empty( $debug ) ) {
					echo __LINE__ . ' - ' . $main_template_dir . $template_name . '<hr/>';
				}

				if ( file_exists( $main_template_dir . $template_name ) ) {
					$path = $main_template_dir . $template_name;
					break;
				}
			}
		}

		/**	Allow debugging	*/
		if ( !empty( $debug ) ) {
			echo '--- Debug mode - END ---<br/><br/>';
		}

		return $path;
	}

	/* PRODEST:
	{
		"name": "activation",
		"description": "CORE - Lance des actions spécifiques lors de l'activation de l'extension / Make some specific action on plugin activation",
		"type": "function",
		"check": true,
		"author":
		{
			"email": "dev@evarisk.com",
			"name": "Alexandre T"
		},
		"version": 0.1
	}
	*/
	public static function activation() {
		do_action( 'digi-extra-module-activation' );

		flush_rewrite_rules( false );/**	False allow to avoid htaccess rewriting	*/
	}


	/**
	 * Récupération du dernier index unique pour un type
	 *
	 * @return boolean|integer Retourne la valeur du dernier index unique pour les éléments digirisk / Return the last index for digirisk element
	 */
	public static function get_last_unique_key( $wp_type, $element_type ) {
		if ( empty( $wp_type ) || empty( $element_type ) )
			return false;

		global $wpdb;
		switch ( $wp_type ) {
			case 'post':
				$query = $wpdb->prepare(
					"SELECT max( PM.meta_value + 0 )
					FROM {$wpdb->postmeta} AS PM
						INNER JOIN {$wpdb->posts} AS P ON ( P.ID = PM.post_id )
					WHERE PM.meta_key = %s
						AND P.post_type = %s", '_wpdigi_unique_key', $element_type );
			break;

			case 'comment':
				$query = $wpdb->prepare(
					"SELECT max( CM.meta_value + 0 )
					FROM {$wpdb->commentmeta} AS CM
						INNER JOIN {$wpdb->comments} AS C ON ( C.comment_ID = CM.comment_id )
					WHERE CM.meta_key = %s
						AND C.comment_type = %s", '_wpdigi_unique_key', $element_type );
			break;

			case 'user':
				$query = $wpdb->prepare(
					"SELECT max( UM.meta_value + 0 )
					FROM {$wpdb->usermeta} AS UM
					WHERE UM.meta_key = %s", '_wpdigi_unique_key' );
			break;

			case 'term':
				$query = $wpdb->prepare(
					"SELECT max( TM.meta_value + 0 )
					FROM {$wpdb->term_taxonomy} AS T
						INNER JOIN {$wpdb->termmeta} AS TM ON ( T.term_id = TM.term_id )
					WHERE TM.meta_key = %s AND T.taxonomy=%s", '_wpdigi_unique_key', $element_type );
			break;
		}

		$last_unique_key = $wpdb->get_var( $query );

		if ( empty( $last_unique_key ) )
			return 0;

		return $last_unique_key;
	}

	public static function upload_file( $file, $element_id ) {
		$wp_upload_dir = wp_upload_dir();

		// Transfère le thumbnail
		$upload_result = wp_upload_bits( basename( $file ), null, file_get_contents( $file ) );

		$filetype = wp_check_filetype( basename( $upload_result[ 'file' ] ), null );
		/**	Set the default values for the current attachement	*/
		$attachment_default_args = array(
				'guid'           => $wp_upload_dir['url'] . '/' . basename( $upload_result[ 'file' ] ),
				'post_mime_type' => $filetype['type'],
				'post_title'     => preg_replace( '/\.[^.]+$/', '', basename( $upload_result[ 'file' ] ) ),
				'post_content'   => '',
				'post_status'    => 'inherit'
		);

		/**	Save new picture into database	*/
		$attach_id = wp_insert_attachment( $attachment_default_args, $upload_result[ 'file' ], $element_id );

		/**	Create the different size for the given picture and get metadatas for this picture	*/
		$attach_data = wp_generate_attachment_metadata( $attach_id, $upload_result[ 'file' ] );
		/**	Finaly save pictures metadata	*/
		wp_update_attachment_metadata( $attach_id, $attach_data );

		return $attach_id;
	}

	public static function check( $action_nonce ) {

		$nonce = sanitize_key( $_REQUEST['_wpnonce'] );

		/** Est-ce que _wpnonce existe ? */
		if ( !isset( $nonce ) ) {
			wp_send_json_error();
		}

		/**
		 * Vérification du nonce avec la fonction wp_verify_nonce de WordPress. Cette fonction
		 * sanitize la valeur de $nonce
		 */
		if ( !wp_verify_nonce( $nonce, $action_nonce ) ) {
			wp_send_json_error();
		}

		/**
		 * Est ce que je suis bien sur une page admin ?
		 */
		// 		$adminurl = strtolower( admin_url() );
		// 		$referer = strtolower( wp_get_referer() );
		// 		echo __LINE__ . $adminurl . '<br />';
		// 		echo __LINE__ . $referer;

		// 		if( strpos( $referer, $adminurl ) !== 0 ) {
		// 			wp_send_json_error();
		// 		}

		/**
		 * Vérification des capabilities de l'utilisateur courant avec la fonction current_user_can
		 * de WordPress. Est-ce qu'il à droit de crée une tâche ?
		 */
		if ( !current_user_can( 'edit_posts' ) ) {
			wp_send_json_error();
		}
	}

	public static function is_parent( $parent_id, $children_id ) {
		$list_parent_id = get_post_ancestors( $children_id );
		if ( !empty( $list_parent_id) && in_array( $parent_id, $list_parent_id ) )
			return true;

		return false;
	}

}
