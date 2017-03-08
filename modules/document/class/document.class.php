<?php namespace digi;

if ( !defined( 'ABSPATH' ) ) exit;
/**
 * Fichier du controlleur principal pour les catégories de documents dans Digirisk / Controller file for attachment categories for Digirisk
 *
 * @author Evarisk development team <dev@evarisk.com>
 * @version 6.0
 */

/**
 * Classe du controlleur principal pour les catégories de documents dans Digirisk / Controller class for attachment categories for Digirisk
 *
 * @author Evarisk development team <dev@evarisk.com>
 * @version 6.0
 */
class Document_Class extends attachment_class {
	protected $model_name   				= '\digi\document_model';
	protected $post_type    				= 'attachment';
	public $attached_taxonomy_type  = 'attachment_category';
	protected $meta_key    					= '_wpdigi_document';
	protected $base 								= 'digirisk/printed-document';
	protected $version 							= '0.1';
	public $element_prefix 					= 'DOC';
	protected $before_put_function = array( '\digi\construct_identifier' );
	protected $after_get_function = array( '\digi\get_identifier' );

	protected $limit_document_per_page = 5;

	public $mime_type_link = array(
		'application/vnd.oasis.opendocument.text' => '.odt',
		'application/zip' => '.zip',
	);
	/**
	 * Instanciation de la gestion des document imprimés / Instanciate printes document
	 */
	protected function construct() {
		add_filter( 'json_endpoints', array( $this, 'callback_register_route' ) );
	}

	/**
	* Récupères le chemin vers le dossier digirisk dans wp-content/uploads
	*
	* @param string $path_type (Optional) Le type de path
	*
	* @return string Le chemin vers le document
	*/
	public function get_digirisk_dir_path( $path_type = 'basedir' ) {
		$upload_dir = wp_upload_dir();
		return str_replace( '\\', '/', $upload_dir[ $path_type ] ) . '/digirisk';
	}

	/**
	 * AFFICHAGE/DISPLAY - Affiche une liste de document associés à un élément selon la liste passée en paramètre du shortcode ou si elle est vide des documents liés dans la base de données / Display a document list associated to a given element passed through shortcode parameters if defined or by getting list into database if nothing tis given in args
	 *
	 * @param array $element Les différents paramètres passés au shortcode lors de son utilisation / Different parameters passed through shortcode when used by user
	 */
	public function display_document_list( $element ) {
		$current_page = !empty( $_REQUEST[ 'next_page' ] ) ? (int)$_REQUEST[ 'next_page' ] : 1;

		$list_document = document_class::g()->get( array(
			// 'post__in'				=> $list_document_id,
			'post_parent'			=> $element->id,
			'post_status'			=> array( 'publish', 'inherit', ),
			// 'posts_per_page'	=> $this->limit_document_per_page,
			// 'offset'					=> ( $current_page - 1 ) * $this->limit_document_per_page,
		), array( 'category' ) );
		$number_page = 0;//ceil( count ( $list_document ) / $this->limit_document_per_page );

		view_util::exec( 'document', 'printed-list', array( 'element_id' => $element->id, 'list_document' => $list_document, 'number_page' => $number_page, 'current_page' => $current_page, ) );
	}

	/**
	 * Récupération de la liste des modèles de fichiers disponible pour un type d'élément / Get file model list for a given element type
	 *
	 * @param array $current_element_type La liste des types pour lesquels il faut récupérer les modèles de documents / Type list we have to get document model list for.
	 *
	 * @return array Un statut pour la réponse, un message si une erreur est survenue, le ou les identifiants des modèles si existants / Response status, a text message if an error occured, model identifier if exists
	 */
	public function get_model_for_element( $current_element_type ) {
		if ( in_array( 'zip', $current_element_type, true ) ) {
			return null;
		}

		$response = array(
			'status'		=> true,
			'message'		=> __( 'Le modèle utilisé est : ' . PLUGIN_DIGIRISK_PATH . 'core/assets/document_template/' . $current_element_type[0] . '.odt', 'digirisk' ),
			'model_id'		=> null,
			'model_path'	=> str_replace( '\\', '/', PLUGIN_DIGIRISK_PATH . 'core/assets/document_template/' . $current_element_type[0] . '.odt' ),
			'model_url' => str_replace( '\\', '/', PLUGIN_DIGIRISK_URL . 'core/assets/document_template/' . $current_element_type[0] . '.odt' ),
		);

		$tax_query = array(
			'relation' => 'AND'
		);

		if ( !empty( $current_element_type ) ) {
		  foreach ( $current_element_type as $element ) {
				$tax_query[] = array(
					'taxonomy' => document_class::g()->attached_taxonomy_type,
					'field'			=> 'slug',
					'terms'			=> $element
				);
		  }
		}

		$query = new \WP_Query( array( 'fields' => 'ids', 'post_status' => 'inherit', 'posts_per_page' => 1, 'tax_query' => $tax_query ) );

		if ( $query->have_posts() ) {
			$upload_dir = wp_upload_dir();

			$model_id = $query->posts[0];
			$attachment_file_path = get_attached_file( $model_id );
			$response['model_id'] = $model_id;
			$response['model_path'] =  str_replace( '\\', '/', $attachment_file_path );
			$response['model_url'] = str_replace( $upload_dir['basedir'], $upload_dir['baseurl'], $attachment_file_path );
			$response['message'] = __( 'Le modèle utilisé est : ' . $attachment_file_path, 'digirisk' );
		}

		return $response;
	}

	/**
	 * Création d'un fichier odt a partir d'un modèle de document donné et d'un modèle de donnée / Create an "odt" file from a given document model and a data model
	 *
	 * @param string $model_path Le chemin vers le fichier modèle a utiliser pour la génération / The path to model file to use for generate the final document
	 * @param array $document_content Un tableau contenant le contenu du fichier a écrire selon l'élément en cours d'impression / An array with the content for building file to print
	 * @param object $element L'élément courant sur lequel on souhaite générer un document / Current element where the user want to generate a file for
	 *
	 */
	public function generate_document( $model_path, $document_content, $document_name ) {
		// if ( !is_string( $model_path ) || !is_array( $document_content ) || !is_string( $document_name ) ) {
		// 	return false;
		// }

		$response = array(
			'status'	=> false,
			'message'	=> '',
			'link'		=> '',
		);

		require_once( PLUGIN_DIGIRISK_PATH . '/core/external/odtPhpLibrary/odf.php');

		$digirisk_directory = $this->get_digirisk_dir_path();
		$document_path = $digirisk_directory . '/' . $document_name;

		$config = array(
			'PATH_TO_TMP' => $digirisk_directory . '/tmp',
		);
		if( !is_dir( $config[ 'PATH_TO_TMP' ] ) ) {
			wp_mkdir_p( $config[ 'PATH_TO_TMP' ] );
		}

		/**	On créé l'instance pour la génération du document odt / Create instance for document generation */
		@ini_set( 'memory_limit', '256M' );
		$DigiOdf = new \DigiOdf( $model_path, $config );

		/**	Vérification de l'existence d'un contenu a écrire dans le document / Check if there is content to put into file	*/
		if ( !empty( $document_content ) ) {
			/**	Lecture du contenu à écrire dans le document / Read the content to write into document	*/
			foreach ( $document_content as $data_key => $data_value ) {
				$DigiOdf = $this->set_document_meta( $data_key, $data_value, $DigiOdf );
			}
		}

		/**	Vérification de l'existence du dossier de destination / Check if final directory exists	*/
		if( !is_dir( dirname( $document_path ) ) ) {
			wp_mkdir_p( dirname( $document_path ) );
		}

		/**	Enregistrement du document sur le disque / Save the file on disk	*/
		$DigiOdf->saveToDisk( $document_path );

		/**	Dans le cas ou le fichier a bien été généré, on met a jour les informations dans la base de données / In case the file have been saved successfully, save information into database	*/
		if ( is_file( $document_path ) ) {
			$response[ 'status' ] = true;
			$response[ 'success' ] = true;
			$response[ 'link' ] = $document_path;
		}

		return $response;
	}

	/**
	* Ecris dans le document ODT
	*
	* @param string $data_key La clé dans le ODT.
	* @param string $data_value La valeur de la clé.
	* @param object $current_odf Le document courant
	*
	* @return object Le document courant
	*/
	public function set_document_meta( $data_key, $data_value, $current_odf ) {
		// if ( !is_string( $data_key ) || !is_string( $data_value ) || !is_object( $current_odf ) ) {
		// 	return false;
		// }
		/**	Dans le cas où la donnée a écrire est une valeur "simple" (texte) / In case the data to write is a "simple" (text) data	*/
		if ( !is_array( $data_value ) ) {
			$current_odf->setVars( $data_key, stripslashes( $data_value ), true, 'UTF-8' );
		}
		else if ( is_array( $data_value ) && isset( $data_value[ 'type' ] ) && !empty( $data_value[ 'type' ] ) ) {
			switch ( $data_value[ 'type' ] ) {

				case 'picture':
					$current_odf->setImage( $data_key, $data_value[ 'value' ], ( !empty( $data_value[ 'option' ] ) && !empty( $data_value[ 'option' ][ 'size' ] ) ? $data_value[ 'option' ][ 'size' ] : 0 ) );
					break;

				case 'segment':
					$segment = $current_odf->setdigiSegment( $data_key );

					if ( $segment && is_array( $data_value[ 'value' ] ) ) {
						foreach ( $data_value[ 'value' ] as $segment_detail ) {
							foreach ( $segment_detail as $segment_detail_key => $segment_detail_value ) {
								if ( is_array( $segment_detail_value ) && array_key_exists( 'type', $segment_detail_value ) && ( 'sub_segment' == $segment_detail_value[ 'type' ] ) ) {
									foreach ( $segment_detail_value[ 'value' ] as $sub_segment_data ) {
										foreach ( $sub_segment_data as $sub_segment_data_key => $sub_segment_data_value ) {
											$segment->$segment_detail_key = $this->set_document_meta( $sub_segment_data_key, $sub_segment_data_value, $segment );
										}
									}
								}
								else {
									$segment = $this->set_document_meta( $segment_detail_key, $segment_detail_value, $segment );
								}
							}

							$segment->merge();
						}

						$current_odf->mergedigiSegment( $segment );
					}
					unset( $segment );
					break;
			}
		}

		return $current_odf;
	}

	public function get_document_path( $element ) {
		$society = society_class::g()->show_by_type( $element->parent_id, array( false ) );
		$path = $this->get_digirisk_dir_path( 'baseurl' );
		$path .= "/" . $society->type . "/" . $society->id . "/";
		$path .= $element->title;
		$path .= $this->mime_type_link[$element->mime_type];
		return $path;
	}

	/**
	 * Récupération de la prochaine version pour un type de document / Get next version number for a document type
	 *
	 * @param array $current_element_type Le type de document actuellement en cours de création / Currently being created document type
	 *
	 * @return int La version du document actuellement en cours de création / Currently being created document version
	 */
	public function get_document_type_next_revision( $current_element_type, $element_id ) {
		global $wpdb;

		/**	Récupération de la date courante / Get current date	*/
		$today = getdate();

		/**	Définition des paramètres de la requête de récupération des documents du type donné pour la date actuelle / Define parameters for query in order to get created document for current date	*/
		$get_model_args = array(
			'nopaging'		=> true,
			'post_parent'	=> $element_id,
			'post_type' 	=> $current_element_type[0],
			'post_status'	=> array( 'publish', 'inherit' ),
			'tax_query' => array(
				array(
					'taxonomy' => $this->attached_taxonomy_type,
					'field'    => 'slug',
					'terms'    => wp_parse_args( $current_element_type, array( 'printed' ) ),
					'operator' => 'AND',
				),
			),
			'date_query' => array(
				array(
					'year'  => $today['year'],
					'month' => $today['mon'],
					'day'   => $today['mday'],
				),
			),
		);

		$element_sheet_default_model = new \WP_Query( $get_model_args );

		return ( $element_sheet_default_model->post_count + 1 );
	}

	/**
	 * Create a zip file with a list of file given in parameter / Créé un fichier au format zip a partir d'une liste de fichiers passé en paramètres
	 *
	 * @param string $final_file_path The zip file path where to save it / Le chemin vers lequel il faut sauvegarder le fichier zip
	 * @param array $file_list The file list to add to the zip file / La liste des fichiers à ajouter au fichier zip
	 * @param object $element The current element where to associate the zip file to / L'élément auquel il faut associer le fichier zip
	 * @param string $version La version du zip
	 */
	 public function create_zip( $final_file_path, $file_list, $element, $version ) {
		$zip = new \ZipArchive();

		$response = array();
		if ( $zip->open( $final_file_path, \ZipArchive::CREATE ) !== true ) {
			$response['status'] = false;
			$response['message'] = __( 'An error occured while opening zip file to write', 'digirisk' );
		}

		if ( ! empty( $file_list ) ) {
			foreach ( $file_list as $file ) {
				if ( ! empty( $file['link'] ) ) {
					$zip->addFile( $file['link'], $file['filename'] );
				}
			}
		}
		$zip->close();

		$document_creation_response = document_class::g()->create_document( $element, array( 'zip' ), $file_list, $version );
		$document_creation_response = wp_parse_args( $document_creation_response, $response );
		// if ( !empty( $document_creation_response[ 'id' ] ) && !empty( $element ) ) {
		// 	$element->associated_document_id[ 'document' ][] = $document_creation_response[ 'id' ];
		// 	group_class::g()->update( $element );
		// }

		return $document_creation_response;
	}

	/**
	 * Create the document into database and call the generation function / Création du document dans la base de données puis appel de la fonction de génération du fichier
	 *
	 * @param object $element The element to create the document for / L'élément pour lequel il faut créer le document
	 * @param array $document_type The document's categories / Les catégories auxquelles associer le document généré
	 * @param array $document_meta Datas to write into the document template / Les données a écrire dans le modèle de document
	 *
	 * @return object The result of document creation / le résultat de la création du document
	 */
	public function create_document( $element, $document_type, $document_meta ) {
		if ( ! empty( $document_type ) && ! empty( $document_type[0] ) && class_exists( '\digi\\' . $document_type[0] . '_model' ) ) {
			$this->set_model( '\digi\\' . $document_type[0] . '_model' );
		}

		$types = $document_type;

		// @todo: Temporaire, il faut repenser cette fonction.
		switch( $document_type[0] ) {
			case "document_unique":
				$types[0] = DUER_Class::g()->get_post_type();
				break;
			case "fiche_de_groupement":
				$types[0] = Fiche_De_Groupement_Class::g()->get_post_type();
				break;
			case "fiche_de_poste":
				$types[0] = Fiche_De_Poste_Class::g()->get_post_type();
				break;
			case "affichage_legal_A3":
				$types[0] = Affichage_Legal_A3_Class::g()->get_post_type();
				break;
			case "affichage_legal_A4":
				$types[0] = Affichage_Legal_A4_Class::g()->get_post_type();
				break;
			case "zip":
				$types[0] = ZIP_Class::g()->get_post_type();
				break;
		}

		$response = array(
			'status' => true,
		);

		/**	Définition du modèle de document a utiliser pour l'impression / Define the document model to use for print sheet */
		$model_to_use = null;
		$model_response = $this->get_model_for_element( wp_parse_args( array( 'model', 'default_model' ), $document_type) );
		$model_to_use = $model_response[ 'model_path' ];

  	/**	Définition de la révision du document / Define the document version	*/
  	$document_revision = $this->get_document_type_next_revision( $types, $element->id );

  	/**	Définition de la partie principale du nom de fichier / Define the main part of file name	*/
  	$main_title_part = $element->title;
  	if ( !empty( $document_type ) && is_array( $document_type ) ) {
  		$main_title_part = $document_type[ 0 ] . '_' . $main_title_part;
  	}

  	/**	Enregistrement de la fiche dans la base de donnée / Save sheet into database	*/
  	$response[ 'filename' ] = mysql2date( 'Ymd', current_time( 'mysql', 0 ) ) . '_' . $element->unique_identifier . '_' . sanitize_title( str_replace( ' ', '_', $main_title_part ) ) . '_V' . $document_revision . '.odt';
  	$document_args = array(
			'post_content'	=> '',
			'post_status'	=> 'inherit',
			'post_author'	=> get_current_user_id(),
			'post_date'		=> current_time( 'mysql', 0 ),
			'post_title'	=> basename( $response[ 'filename' ], '.odt' ),
  	);

  	/**	On créé le document / Create the document	*/
  	$filetype = 'unknown';

		// @todo: A faire
		if ( in_array( 'zip', $document_type ) ) {
			$filetype = "application/zip";
		}

		$path = '';

  	if ( null !== $model_to_use ) {
			$path = $element->type. '/' . $element->id . '/' . $response[ 'filename' ];
  		$document_creation = $this->generate_document( $model_to_use, $document_meta, $path );

  		if ( !empty( $document_creation ) && !empty( $document_creation[ 'status' ] ) && !empty( $document_creation[ 'link' ] ) ) {
  			$filetype = wp_check_filetype( $document_creation[ 'link' ], null );
  			$response[ 'link' ] = $document_creation[ 'link' ];
  			$response[ 'message' ] = __( 'The sheet have been generated successfully. Please find it below', 'digirisk' );
  		}
  		else {
  			$response = wp_parse_args( $document_creation, $response );
  		}
  	}
  	else {
  		$response[ 'status' ] = false;
  		$response[ 'message' ] = $model_response[ 'message' ];
  	}

		$response[ 'id' ] = wp_insert_attachment( $document_args, $this->get_digirisk_dir_path() . '/' . $path, $element->id );

		$attach_data = wp_generate_attachment_metadata( $response['id'], $this->get_digirisk_dir_path() . '/' . $path );
		wp_update_attachment_metadata( $response['id'], $attach_data );

		wp_set_object_terms( $response[ 'id' ], wp_parse_args( $types, array( 'printed', ) ), $this->attached_taxonomy_type );

  	/**	On met à jour les informations concernant le document dans la base de données / Update data for document into database	*/
  	$document_args = array(
			'id'										=> $response[ 'id' ],
			'title'									=> basename( $response[ 'filename' ], '.odt' ),
			'parent_id'							=> $element->id,
			'author_id'							=> get_current_user_id(),
			'date'									=> current_time( 'mysql', 0 ),
			'mime_type'							=> !empty( $filetype[ 'type' ] ) ? $filetype['type'] : $filetype,
			'model_id' 							=> $model_to_use,
			'document_meta' 				=> $document_meta,
			'status'								=> 'inherit',
			'version'								=> $document_revision,
  	);

		// @todo: Temporaire, il faut repenser cette fonction.
		switch( $document_type[0] ) {
			case "document_unique":
				$document_args['type'] = DUER_Class::g()->get_post_type();
				$document = DUER_Class::g()->update( $document_args );
				break;
			case "fiche_de_groupement":
				$document_args['type'] = Fiche_De_Groupement_Class::g()->get_post_type();
				$document = Fiche_De_Groupement_Class::g()->update( $document_args );
				break;
			case "fiche_de_poste":
				$document_args['type'] = Fiche_De_Poste_Class::g()->get_post_type();
				$document = Fiche_De_Poste_Class::g()->update( $document_args );
				break;
			case "affichage_legal_A3":
				$document_args['type'] = Affichage_Legal_A3_Class::g()->get_post_type();
				$document = Affichage_Legal_A3_Class::g()->update( $document_args );
				break;
			case "affichage_legal_A4":
				$document_args['type'] = Affichage_Legal_A4_Class::g()->get_post_type();
				$document = Affichage_Legal_A4_Class::g()->update( $document_args );
				break;
			case "zip":
				$document_args['type'] = ZIP_Class::g()->get_post_type();
				$document = ZIP_Class::g()->update( $document_args );
				break;
			default:
		  	$document = $this->update( $document_args );
				break;
		}

  	return $response;
	}
}

document_class::g();
