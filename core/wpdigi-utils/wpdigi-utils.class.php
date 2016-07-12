<?php if ( !defined( 'ABSPATH' ) ) exit;
class wpdigi_utils {

	/**
	* Le constructeur
	*/
	function __construct() {}

	/**
	* Récupères le template par rapport au chemin donné
	*
	* @param string $plugin_dir_name (test: path/to/plugin) Le chemin vers le dossier du plugin
	* @param string $main_template_dir (test: path/to/template) Le chemin vers le dossier du template
	* @param string $side (test: backend) Le sous dossier dans template
	* @param string $slug (test: main) Le nom du template
	* @param string $name (test: view) Le sous nom du template
	* @param bool $debug (test: bool) Active le mode debug
	*/
	static function get_template_part( $plugin_dir_name, $main_template_dir, $side, $slug, $name = null, $debug = null ) {
		if ( !is_string( $plugin_dir_name ) || !is_string( $main_template_dir ) || !is_string( $side ) || !is_string( $slug ) ) {
			return false;
		}

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

	/**
	* test
	*/
	public static function activation() {
		do_action( 'digi-extra-module-activation' );

		flush_rewrite_rules( false );/**	False allow to avoid htaccess rewriting	*/
	}


	/**
	 * Récupération du dernier index unique pour un type
	 *
	 * @param string $wp_type (test: post) Le type de la donnée
	 * @param string $element_type (test: digi-risk) Le type de la donnée
	 *
	 * @return integer Retourne la valeur du dernier index unique pour les éléments digirisk / Return the last index for digirisk element
	 */
	public static function get_last_unique_key( $wp_type, $element_type ) {
		if ( empty( $wp_type ) || empty( $element_type ) || !is_string( $wp_type ) || !is_string( $element_type ) )
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

		if ( !empty( $query ) ) {
			$last_unique_key = $wpdb->get_var( $query );
		}

		if ( empty( $last_unique_key ) )
			return 0;

		return $last_unique_key;
	}

	/**
	* Upload un fichier et créer ensuite les meta données
	*
	* @param string $file Le chemin vers le fichier
	* @param int $element_id L'id de l'élement parent
	*
	* @return int L'attachement id
	*/
	public static function upload_file( $file, $element_id ) {
		if ( !is_string( $file ) || !is_int( $element_id ) || !is_file( $file ) ) {
			return false;
		}

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

	/**
	* Est ce que le post est un parent des enfants ?
	*
	* @param int $parent_id (test: 10) L'id du post parent
	* @param int $children_id (test: 11) L'id du post enfant
	*
	* @return bool true|false
	*/
	public static function is_parent( $parent_id, $children_id ) {
		$list_parent_id = get_post_ancestors( $children_id );
		if ( !empty( $list_parent_id) && in_array( $parent_id, $list_parent_id ) )
			return true;

		return false;
	}

}
