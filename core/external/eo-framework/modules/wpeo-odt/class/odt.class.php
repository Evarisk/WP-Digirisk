<?php
/**
 * Gestion des ODT (POST, PUT, GET, DELETE)
 *
 * @author Eoxia <dev@eoxia.com>
 * @since 1.0.0
 * @copyright 2015-2018
 * @package EO_Framework\EO_Model\Class
 */

namespace eoxia;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! class_exists( '\eoxia\ODT_Class' ) ) {

	/**
	 * Gestion des ODT (POST, PUT, GET, DELETE)
	 */
	class ODT_Class extends Attachment_Class {

		/**
		 * Le nom du modèle
		 *
		 * @var string
		 */
		protected $model_name = '\eoxia\ODT_Model';

		/**
		 * Le type du post
		 *
		 * @var string
		 */
		protected $type = 'document-odt';

		/**
		 * Le type du post
		 *
		 * @var string
		 */
		protected $base = 'eo-attachment';

		/**
		 * La clé principale pour post_meta
		 *
		 * @var string
		 */
		protected $meta_key = 'eo_attachment';

		/**
		 * Nom de la taxonomy
		 *
		 * @var string
		 */
		protected $attached_taxonomy_type = 'attachment_category';


		/**
		 * Le nom pour le resgister post type
		 *
		 * @var string
		 */
		protected $post_type_name = 'ODT';

		/**
		 * Utiles pour récupérer la clé unique
		 *
		 * @todo Rien à faire ici
		 * @var string
		 */
		protected $identifier_helper = 'odt';

		/**
		 * Le chemin vers le modèle
		 *
		 * @var string
		 */
		protected $model_path = '';

		/**
		 * Les types par défaut des modèles.
		 *
		 * @since 1.0.0
		 *
		 * @var array
		 */
		private $default_types = array( 'model', 'default_model' );

		/**
		 * Le nom du modèle ODT.
		 *
		 * @since 1.0.0
		 *
		 * @var string
		 */
		protected $odt_name = '';

		protected $path = '';
		protected $url = '';

		/**
		 * Récupères le chemin vers le dossier frais-pro dans wp-content/uploads
		 *
		 * @param string $path_type (Optional) Le type de path.
		 *
		 * @return string Le chemin vers le document
		 */
		public function get_dir_path( $path_type = 'basedir' ) {
			$upload_dir = wp_upload_dir();
			$response   = str_replace( '\\', '/', $upload_dir[ $path_type ] );
			return $response;
		}

		/**
		 * Récupération de la liste des modèles de fichiers disponible pour un type d'élément
		 *
		 * @since 6.0.0
		 *
		 * @param  array $model_type Le type du document.
		 *
		 * @return array
		 */
		public function get_default_model( $model_type ) {
			if ( 'zip' === $model_type ) {
				return;
			}

			$response = array(
				'status'  => true,
				'id'      => null,
				'path'    => str_replace( '\\', '/', $this->path . 'core/assets/document_template/' . $this->odt_name . '.odt' ),
				'url'     => str_replace( '\\', '/', $this->url . 'core/assets/document_template/' . $this->odt_name . '.odt' ),
				// translators: Pour exemple: Le modèle utilisé est: C:\wamp\www\wordpress\wp-content\plugins\digirisk-alpha\core\assets\document_template\document_unique.odt.
				'message' => sprintf( __( 'Le modèle utilisé est: %1$score/assets/document_template/%2$s.odt', 'digirisk' ), $this->path, $this->odt_name ),
			);

			// Merge tous les types ensembles.
			$types = array_merge( $this->default_types, (array) $model_type );

			// Préparation de la query pour récupérer le modèle par défaut selon $model_type.
			$tax_query = array(
				'relation' => 'AND',
			);

			if ( ! empty( $types ) ) {
				foreach ( $types as $type ) {
					$tax_query[] = array(
						'taxonomy' => $this->get_attached_taxonomy(),
						'field'    => 'slug',
						'terms'    => $type,
					);
				}
			}

			// Lances la Query pour récupérer le document par défaut selon $model_type.
			$query = new \WP_Query( array(
				'fields'         => 'ids',
				'post_status'    => 'inherit',
				'posts_per_page' => 1,
				'tax_query'      => $tax_query,
				'post_type'      => array( 'attachment', 'document-odt' ),
			) );

			// Récupères le document
			if ( $query->have_posts() ) {
				$upload_dir = wp_upload_dir();

				$model_id               = $query->posts[0];
				$attachment_file_path   = str_replace( '\\', '/', get_attached_file( $model_id ) );
				$response['id']   = $model_id;
				$response['path'] = str_replace( '\\', '/', $attachment_file_path );
				$response['url']  = str_replace( str_replace( '\\', '/', $upload_dir['basedir'] ), str_replace( '\\', '/', $upload_dir['baseurl'] ), $attachment_file_path );

				// translators: Pour exemple: Le modèle utilisé est: C:\wamp\www\wordpress\wp-content\plugins\digirisk-alpha\core\assets\document_template\document_unique.odt.
				$response['message'] = sprintf( __( 'Le modèle utilisé est: %1$s', 'digirisk' ), $attachment_file_path );
			}

			if ( ! is_file( $response['path'] ) ) {
				$response['status'] = false;
				$response['message'] = 'Le modèle ' . $response['path'] . ' est introuvable.';
			}

			return $response;
		}

		/**
		 * Récupération de la prochaine version pour un type de document pour le jour J
		 *
		 * @since 6.0.0
		 *
		 * @param string  $type       Le type de document actuellement en cours de création.
		 * @param integer $element_id L'ID de l'élément.
		 *
		 * @return integer            La version +1 du document actuellement en cours de création.
		 */
		public function get_revision( $type, $element_id ) {
			global $wpdb;

			// Récupération de la date courante.
			$today = getdate();

			// Définition des paramètres de la requête de récupération des documents du type donné pour la date actuelle.
			$args = array(
				'count'          => true,
				'posts_per_page' => -1,
				'post_parent'    => $element_id,
				'post_type'      => $type,
				'post_status'    => array( 'publish', 'inherit' ),
				'date_query' => array(
					array(
						'year'  => $today['year'],
						'month' => $today['mon'],
						'day'   => $today['mday'],
					),
				),
			);

			$document_revision = new \WP_Query( $args );
			return ( $document_revision->post_count + 1 );
		}

		/**
		 * Enregistres les données du document.
		 *
		 * @since 1.1.0
		 *
		 * @param  mixed $parent_id     L'ID où est attaché le document.
		 * @param  array $document_meta Les métadonnées du document.
		 * @param  array $args          Arguments supplémentaires.
		 *
		 * @return void
		 */
		public function save_document_data( $parent_id, $document_meta, $args = array() ) {
			$response = array();

			// Récupères le modèle a utiliser pour la futur génération de l'ODT.
			$model_infos = $this->get_default_model( $this->get_type() );

			if ( ! $model_infos['status'] ) {
				$response['message'] = $model_infos['message'];
				$response['path']    = $model_infos['path'];
				return $response;
			}

			// On met à jour les informations concernant le document dans la
			// base de données.
			$document_args = array(
				'model_id'      => $model_infos['id'],
				'model_path'    => $model_infos['path'],
				'parent_id'     => $parent_id,
				'parent'        => $args['parent'],
				'status'        => 'inherit',
				'document_meta' => $document_meta,
			);

			$document = $this->update( $document_args );
			wp_set_object_terms( $document->data['id'], array( $this->get_type(), 'printed' ), $this->attached_taxonomy_type );

			$response['document'] = $document;

			return $response;
		}

		/**
		 * Création du document dans la base de données puis appel de la fonction de génération du fichier
		 *
		 * @since 1.0.0
		 *
		 * @param object $element      L'élément pour lequel il faut créer le document
		 * @param array  $document_meta Les données a écrire dans le modèle de document
		 *
		 * @return object              Le résultat de la création du document
		 */
		public function create_document( $document_id ) {
			$response = array(
				'status'   => true,
				'message'  => '',
				'filename' => '',
				'path'     => '',
			);

			$document = $this->generate_document( $document_id );

			$file_info = $this->check_file( $document );

			if ( $file_info['exists'] ) {
				$document->data['mime_type'] = $file_info['mime_type']['type'];
			}

			$document->data['file_generated'] = true;

			$document = $this->update( $document->data );

			$response['document'] = $document;

			return $response;
		}

		/**
		 * Vérification de l'existence d'un fichier à partir de la définition d'un document.
		 *
		 * 1- On remplace l'url du site "site_url( '/' )" par le chemin "ABSPATH" contenant les fichiers du site: on vérifie si le fichier existe.
		 * 2- Si le fichier n'existe pas:
		 *  2.a- On récupère la meta associée automatiquement par WordPress.
		 *  2.b- Si la méta n'est pas vide, on vérifie que sa valeur concaténée au chemin absolu des uploads "wp_upload_dir()" de WordPress soit bien un fichier
		 *
		 * @since 1.0.0
		 *
		 * @param Document_Model $document La définition du document à vérifier.
		 *
		 * @return array                   Tableau avec le status d'existence du fichier (True/False) et le lien de téléchargement du fichier.
		 */
		public function check_file( $document ) {
			// Définition des valeurs par défaut.
			$file_check = array(
				'exists'    => false,
				'path'      => '',
				'mime_type' => '',
				'link'      => '',
			);

			if ( ! empty( $document->data['link'] ) ) {
				$file_check['path'] = str_replace( site_url( '/' ), ABSPATH, $document->data['link'] );
				$file_check['link'] = $document->data['link'];
			}

			$upload_dir = wp_upload_dir();

			// Vérification principale. cf 1 ci-dessus.
			if ( is_file( $file_check['path'] ) ) {
				$file_check['exists'] = true;
			}

			// La vérification principale n'a pas fonctionnée. cf 2 ci-dessus.
			if ( ! $file_check['exists'] && ! empty( $document->data['_wp_attached_file'] ) ) {
				$file_check['path'] = $upload_dir['basedir'] . '/' . $document->data['_wp_attached_file'];
				$file_check['link'] = $upload_dir['baseurl'] . '/' . $document->data['_wp_attached_file'];
				if ( is_file( $file_check['path'] ) ) {
					$file_check['exists'] = true;
				}
			}

			// Si le fichier existe on récupère le mime type.
			if ( $file_check['exists'] ) {
				$file_check['mime_type'] = wp_check_filetype( $file_check['path'] );
			}

			return $file_check;
		}

		/**
		 * Création d'un fichier odt a partir d'un modèle de document donné et d'un modèle de donnée
		 *
		 * @since 6.0.0
		 *
		 * @param string $model_path       Le chemin vers le fichier modèle a utiliser pour la génération.
		 * @param array  $document_content Un tableau contenant le contenu du fichier à écrire selon l'élément en cours d'impression.
		 * @param string $document_name    Le nom du document.
		 *
		 * array['status']   boolean True si tout s'est bien passé sinon false.
		 * array['message']  string  Le message informatif de la méthode.
		 * array['path']     string  Le chemin absolu vers le fichier.
		 * array['url']      string  L'url vers le fichier.
		 *
		 * @return array                   (Voir au dessus).
		 */
		public function generate_document( $document_id ) {
			$document = $this->get( array( 'id' => $document_id ), true );

			$response = array(
				'status'   => false,
				'message'  => '',
				'path'     => '',
				'url'      => '',
			);

			if ( empty( $document->data['path'] ) ) {
				$response['message'] = 'Document path est vide';
				return $response;
			}

			@ini_set( 'memory_limit', '256M' );


			require_once $this->path . '/core/external/odtPhpLibrary/odf.php';

			$upload_dir = wp_upload_dir();
			$directory  = str_replace( '\\', '/', $upload_dir['basedir'] );

			$config = array(
				'PATH_TO_TMP' => $directory . '/tmp',
			);
			if ( ! is_dir( $config['PATH_TO_TMP'] ) ) {
				wp_mkdir_p( $config['PATH_TO_TMP'] );
			}

			if ( ! is_file( $document->data['model_path'] ) ) {
				$response['message'] = $document->data['model_path'] . ' est introuvable';
				return $response;
			}


			// On créé l'instance pour la génération du document odt.
			$odf_php_lib = new \DigiOdf( $document->data['model_path'], $config );

			// Vérification de l'existence d'un contenu a écrire dans le document.
			if ( ! empty( $document->data['document_meta'] ) ) {
				// Lecture du contenu à écrire dans le document.
				foreach ( $document->data['document_meta'] as $data_key => $data_value ) {
					if ( is_array( $data_value ) && ! empty( $data_value['raw'] ) ) {
						$data_value = $data_value['raw'];
					}

					$odf_php_lib = $this->set_document_meta( $data_key, $data_value, $odf_php_lib );
				}
			}

			// Vérification de l'existence du dossier de destination.
			if ( ! is_dir( dirname( $document->data['path'] ) ) ) {
				wp_mkdir_p( dirname( $document->data['path'] ) );
			}

			// Enregistrement du document sur le disque.
			$odf_php_lib->saveToDisk( $document->data['path'] );

			if ( is_file( $document->data['path'] ) ) {
				$response['status'] = true;
				$response['path']   = $document->data['path'];
			}

			return $document;
		}

		/**
		 * Ecris dans le document ODT
		 *
		 * @since 6.0.0
		 *
		 * @param string $data_key    La clé dans le ODT.
		 * @param string $data_value  La valeur de la clé.
		 * @param object $current_odf Le document courant.
		 *
		 * @return object             Le document courant
		 */
		public function set_document_meta( $data_key, $data_value, $current_odf ) {
			// Dans le cas où la donnée a écrire est une valeur "simple" (texte).
			if ( ! is_array( $data_value ) ) {
				$current_odf->setVars( $data_key, stripslashes( $data_value ), true, 'UTF-8' );
			} else if ( is_array( $data_value ) && isset( $data_value[ 'type' ] ) && !empty( $data_value[ 'type' ] ) ) {
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
												$segment->$segment_detail_key = $this->set_document_meta( $sub_segment_data_key, $sub_segment_data_value, $segment->$segment_detail_key );
											}

											$segment->$segment_detail_key->merge();
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
	}
} // End if().
