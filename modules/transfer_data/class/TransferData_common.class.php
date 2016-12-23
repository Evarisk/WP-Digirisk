<?php
namespace digi;

if ( !defined( 'ABSPATH' ) ) exit;

class TransferData_common_class extends singleton_util {

	protected function construct() { }

	function transfer( $element_type, $element, $element_parent = null ) {
		global $wpdb;
		$element_id = 0;

		/**	Define the fields that have to be treated for wordpress element creation from evarisk internal element	*/
		$custom_fields = array();
		$custom_fields[ 'post_title' ] = 'nom';
		$custom_fields[ 'post_content' ] = 'description';
		switch( $element_type ) {
			case TABLE_TACHE:
			case TABLE_ACTIVITE:
				$custom_fields[ 'post_author' ] = 'idCreateur';
				$custom_fields[ 'post_date' ]	= 'firstInsert';
				break;

			case TABLE_GROUPEMENT:
			case TABLE_UNITE_TRAVAIL:
				$custom_fields[ 'post_date' ]	= 'creation_date';
				break;
		}

		/**	Get already transfered elements	*/
		$digirisk_transfer_options = get_option( '_wpdigirisk-dtransfert', array() );

		/**	Define the default field for new element into wordpress	*/
		$element_wp_definition = array(
			'post_type' => TransferData_class::g()->post_type[ $element_type ],
		);
		if ( !empty( $element_parent ) ) {
			$element_wp_definition[ 'post_parent' ] = $element_parent;
		}

		/**	In case the element is already transfered don't treat it	*/
		if ( empty( $digirisk_transfer_options ) || empty( $digirisk_transfer_options[ $element_type ] ) || !in_array( $element->id, $digirisk_transfer_options[ $element_type ]) ) {
			/**	Define the post status from the current one	*/
			$element_wp_definition[ 'post_status' ] = ( $element->Status == 'Valid' ? 'publish' : ( $element->Status == 'Moderated' ? 'draft' : 'trash' ) );

			if ( !empty( $custom_fields ) ) {
				foreach ( $custom_fields as $post_field => $custom_field ) {
					$specific = false;
					if ( 'idCreateur' == $custom_field ) {
						$idCreateur = ( 0 == $element->$custom_field ) ? 1 : $element->$custom_field;
						if ( empty( $_POST[ 'wpdigi-dtrans-userid-behaviour' ] ) && !empty( $_POST[ 'wp_new_user' ] ) && !empty( $_POST[ 'wp_new_user' ][ $idCreateur ] ) ) {
							$element_wp_definition[ $post_field ] = $_POST[ 'wp_new_user' ][ $idCreateur ];
							$specific = true;
						}
					}

					if ( !$specific ) {
						$element_wp_definition[ $post_field ] = null !== $element->$custom_field ? $element->$custom_field : "";
					}

					unset( $element->$custom_field );
				}
			}
			/**	Create element into wordpress database */
			$element_id = wp_insert_post( $element_wp_definition, true );

			/**	In case insertion has been successfull, read children in order to do same treatment and save extras informations into meta for the moment	*/
			if ( is_int( $element_id ) && ( 0 !== (int)$element_id ) ) {
				/**	Log creation	*/
				log_class::g()->exec( 'digirisk-datas-transfert-' . $element_type, '', sprintf( __( 'Transfered from evarisk on post having id. %d', 'wp-digi-dtrans-i18n' ), $element_id), array( 'object_id' => $element->id, ), 0 );

				/**	Store an option to avoid multiple transfer	*/
				$digirisk_transfer_options[ $element_type ][] = $element->id;
				update_option( '_wpdigirisk-dtransfert', $digirisk_transfer_options );

				/**	Start transfering user notification if exists	*/
				$this->transfer_notification( $element->id, $element_type, $element_id, '' );

				/**	Start transfering survey that have been done with wp-easy-survey	*/
				$this->transfer_surveys( $element->id, $element_type, $element_id, '' );

				/**	Check curren type of element to launch specific transfer	*/
				switch( $element_type ) {
					case TABLE_TACHE:
					case TABLE_ACTIVITE:
						TransferData_task_class::g()->transfer( $element, $element_type, $element_id );
					break;

					case TABLE_GROUPEMENT:
						/**
						 * Risques
						 * Preconisations
						 * //Accidents de travail
						 * Produits
						 */

					//	wpdigi_transferdata_society_class::g()->transfer_groupement( $element, $element_type, $element_id );
					break;

					case TABLE_UNITE_TRAVAIL:
						/**
						 * Risques
						 * Preconisations
						 * //Accidents de travail
						 * Produits
						 */

						wpdigi_transferdata_society_class::g()->transfer_unite( $element, $element_type, $element_id );
					break;
				}

				/**	Store the other data into meta	*/
				update_post_meta( $element_id, '_wpdigi_element_computed_identifier', $element_type . '#value_sep#' . $element->id );
				update_post_meta( $element_id, '_wpdigi_element_old_definition', json_encode( array( $element_type, serialize( $element ) ) ) );

				/**	Lauch transfer for current element direct children of same type	*/
				if ( property_exists( $element, 'limiteGauche') ) {
					$query = "
						SELECT *
						FROM {$element_type} AS table1
						WHERE table1.limiteGauche > " . $element->limiteGauche . "
							AND table1.limiteDroite < " . $element->limiteDroite . "
							AND NOT EXISTS (
								SELECT *
								FROM {$element_type} AS table2
								WHERE table2.limiteGauche > " . $element->limiteGauche . "
									AND table2.limiteDroite < " . $element->limiteDroite . "
									AND table1.limiteGauche > table2.limiteGauche
									AND table1.limiteDroite < table2.limiteDroite
							)
						ORDER BY limiteGauche ASC";
					$sub_elements = $wpdb->get_results($query);
					foreach ( $sub_elements as $element ) {
						$new_children_id = $this->transfer( $element_type, $element, $element_id );
					}
				}
			}
			else {
				log_class::g()->exec( 'digirisk-datas-transfert-' . $element_type, '', sprintf( __( 'Error transferring from evarisk to post. error %s', 'wp-digi-dtrans-i18n' ), json_encode( $element_id ) ), array( 'object_id' => $element_type . '-' . $element->id, ), 2 );
			}
		}

		return $element_id;
	}

	function transfer_surveys( $old_element_id, $old_element_type, $new_element_id ) {
		global $wpdb;
		$survey_results = array();

		/**	Get existing surveys	*/
		$query = $wpdb->prepare( "SELECT * FROM " .  TABLE_FORMULAIRE_LIAISON . " WHERE tableElement = %s AND idELement = %d ", $old_element_type, $old_element_id );
		$surveys = $wpdb->get_results( $query );

		/**	Check if there are surveys to transfer from evarisk storage way to wordpress storage way	*/
		if ( !empty( $surveys ) ) {
			foreach ( $surveys as $survey ) {
				$survey_results[ $survey->idFormulaire ][ $survey->state ][] = array(
					'date_started' => $survey->date_started,
					'date_closed' => $survey->date_closed,
					'state' => $survey->state,
					'user' => $survey->user,
					'user_closed' => $survey->user_closed,
					'survey_id' => $survey->survey_id,
				);
			}
		}

		/**	Save survey datas into the associated element	*/
		if ( !empty( $survey_results ) ) {
			foreach ( $survey_results as $original_survey_id => $final_survey ) {
				update_post_meta( $new_element_id, '_wpes_audit_' . $original_survey_id, $final_survey );
				log_class::g()->exec( 'digirisk-datas-transfert-survey' , '', __( 'Survey association have been transfered to normal way', 'wp-digi-dtrans-i18n' ), array( 'object_id' => $original_survey_id, ), 0 );
			}
		}
	}

	function transfer_document( $document, $new_element_id, $document_origin = 'picture', $main_file_directory = EVA_GENERATED_DOC_DIR ) {
		if ( !function_exists( 'wp_generate_attachment_metadata' ) )
			require_once( ABSPATH . 'wp-admin/includes/image.php' );

		/**	Get wordpress uploads directory	*/
		$wp_upload_dir = wp_upload_dir();
		$associate_document_list = array();
		$attach_id = null;

		/**	Get associated picture list	*/
		$main_type = $document_origin;
		switch ( $document_origin ) {
			case 'picture':
				$field_name = 'photo';
			break;
			case 'document':
			case 'document_model':
			case 'printed_duer':
			case 'printed_sheet':
				$main_type = 'document';
			break;
		}

		$digirisk_transfert_options = get_option( '_wpdigirisk-dtransfert', array() );
		/**	Get the file content - force error ignore	*/
		$filename = ( 'document' == $main_type ? ( 'printed_fiche_action' == $document->categorie ? 'results/' : '' ) . $document->chemin . $document->nom : str_replace( 'medias/images/Pictos', 'core/assets/images', $document->$field_name ) );
		$file = $main_file_directory . $filename;
		if ( !is_file( $file ) && ( $main_file_directory != EVA_GENERATED_DOC_DIR ) ) {
			$file = EVA_GENERATED_DOC_DIR . $filename;
		}

		if ( is_file( $file ) ) {
			$the_file_content = @file_get_contents( $file );

			/**	Check if file is a valid one	*/
			if ( $the_file_content !== false ) {
				$attachment_args = array();

				/**	Get associated picture list	*/
				switch ( $main_type ) {
					case 'document':
						$path_document_complete = document_class::g()->get_digirisk_dir_path() . '/' . ( empty( $new_element_id ) ? 'document_models/' : get_post_type( $new_element_id ) . '/' . $new_element_id . '/' );
						$guid = document_class::g()->get_digirisk_dir_path('baseurl') . '/' . ( empty( $new_element_id ) ? 'document_models/' : get_post_type( $new_element_id ) . '/' . $new_element_id . '/' ) . basename($file);
						wp_mkdir_p( $path_document_complete );
						copy( $file, $path_document_complete . '/' . basename($file) );

						$idCreateur = !isset( $document->idCreateur ) && ( 0 == $document->idCreateur ) ? 1 : $document->idCreateur;
						if ( empty( $_POST[ 'wpdigi-dtrans-userid-behaviour' ] ) && !empty( $_POST[ 'wp_new_user' ] ) && !empty( $_POST[ 'wp_new_user' ][ $idCreateur ] ) ) {
							$idCreateur = $_POST[ 'wp_new_user' ][ $idCreateur ];
						}
						$attachment_args[ 'post_author' ] = $idCreateur;
						$attachment_args[ 'post_date' ] = $document->dateCreation;
					break;

					default:
						/**	Start by coping picture into wordpress uploads directory	*/
						$path_document_complete = $wp_upload_dir['path'];
						$path_document = $wp_upload_dir['path'] . '/' . basename($file);
						copy( $file, $path_document );
						$guid = $wp_upload_dir['url'] . '/' . basename( $file );
					break;
				}

				/**	Get informations about the picture	*/
				$filetype = wp_check_filetype( basename( $file ), null );
				$document_status = ( 'valid' === $document->status ? 'inherit' : 'trash' );
				/**	Set the default values for the current attachement	*/
				$attachment_default_args = array(
					'guid'           => $guid,
					'post_mime_type' => $filetype['type'],
					'post_title'     => preg_replace( '/\.[^.]+$/', '', basename( $file ) ),
					'post_content'   => '',
					'post_status'    => $document_status,
				);

				/**	Save new picture into database	*/
				$attach_id = wp_insert_attachment( wp_parse_args( $attachment_args, $attachment_default_args ), $guid );

				/**	Create the different size for the given picture and get metadatas for this picture	*/
				$attach_data = wp_generate_attachment_metadata( $attach_id, $path_document_complete . '/' . basename( $file ) );
				/**	Finaly save pictures metadata	*/
				wp_update_attachment_metadata( $attach_id, $attach_data );

				/**	Set the post thumbnail if necessary	*/
				if ( !empty( $new_element_id ) && ( 'picture' == $main_type ) && ( 'yes' == $document->isMainPicture ) ) {
					set_post_thumbnail( $new_element_id, $attach_id );
					log_class::g()->exec( 'digirisk-datas-transfert-' . $main_type , '', sprintf( __( 'Définition de l\'image principale %2$d de l\'élément %1$d', 'wp-digi-dtrans-i18n' ), $new_element_id, $attach_id ), array( 'object_id' => $document->id, 'document_old_def' => $document ), 0 );
				}

				if ( ! isset( $document->LINK_STATUS ) || ( 'valid' === $document->LINK_STATUS ) ) {
					$associate_document_list[] = $attach_id;
				}

				/**	store old document complete definition	*/
				switch ( $main_type ) {
					case 'picture':
						/**	Get the element created for new data transfer	*/
						$doc_model = attachment_class::g()->get( array( 'p' => $attach_id, 'post_status' => $document_status ) );
						$doc_model = $doc_model[0];

						/**	Build the model for new data storage */
						$doc_model->parent_id = $new_element_id;
						$doc_model->unique_key = $document->id;
						$doc_model->unique_identifier = ELEMENT_IDENTIFIER_PIC . $document->id;
						attachment_class::g()->update( $doc_model );
					break;
					case 'document':
						/** Do a backup of old document */
						update_post_meta( $attach_id, '_digi_old_doc', $document );
						$document_meta = array();
						if ( isset( $document->meta ) ) {
							foreach ( $document->meta as $doc_meta ) {
								$document_meta[ $doc_meta->meta_key ] = maybe_unserialize( $doc_meta->meta_value );
							}
						}
						update_post_meta( $attach_id, '_digi_old_doc_meta', json_encode( $document_meta ) );
					break;
				}

				log_class::g()->exec( 'digirisk-datas-transfert-' . $main_type , '', sprintf( __( '%1$s #%2$d transférée dans les médias de WordPress vers #%3$d sur l\'élément %4$s ', 'wp-digi-dtrans-i18n' ), $main_type, $document->id, $attach_id, $new_element_id), array( 'object_id' => $document->id, ), 0 );
				$digirisk_transfert_options[ $document_origin ][ 'ok' ][] = $document->id;
			} else {
				$digirisk_transfert_options[ $document_origin ][ 'nok' ][ $document->id ][ 'file' ] = $file;
				if ( 'picture' == $main_type ) {
					$tocheck = $document->tableElement;
				} else {
					$tocheck = $document->table_element;
				}

				switch ( $tocheck ) {
					case TABLE_TACHE:
						$old_evarisk_element = ELEMENT_IDENTIFIER_T;
						break;
					case TABLE_ACTIVITE:
						$old_evarisk_element = ELEMENT_IDENTIFIER_ST;
						break;
					case TABLE_GROUPEMENT:
						$old_evarisk_element = ELEMENT_IDENTIFIER_GP;
						break;
					case TABLE_UNITE_TRAVAIL:
						$old_evarisk_element = ELEMENT_IDENTIFIER_UT;
						break;
					case TABLE_DANGER:
						$old_evarisk_element = ELEMENT_IDENTIFIER_D;
						break;
					case TABLE_CATEGORIE_DANGER:
						$old_evarisk_element = ELEMENT_IDENTIFIER_CD;
						break;
					case TABLE_PRECONISATION:
						$old_evarisk_element = ELEMENT_IDENTIFIER_P;
						break;
					case TABLE_CATEGORIE_PRECONISATION:
						$old_evarisk_element = ELEMENT_IDENTIFIER_CP;
						break;
					case TABLE_METHODE:
						$old_evarisk_element = ELEMENT_IDENTIFIER_ME;
						break;
				}

				if ( ( 'all' != $tocheck ) && !empty( $old_evarisk_element ) ) {
					$old_evarisk_element .= ( 'picture' == $main_type  ? $document->idElement : $document->id_element );
				} else {
					$old_evarisk_element = __( 'Document model', 'wp-digi-dtrans-i18n' );
				}

				log_class::g()->exec( 'digirisk-datas-transfert-' . $main_type , '', sprintf( __( '%s could not being transfered to wordpress element. Filename: %s. Wordpress element: %d. Evarisk old element: %s', 'wp-digi-dtrans-i18n' ), $main_type, $file, $new_element_id, $old_evarisk_element ), array( 'object_id' => $document->id, ), 2 );
			}
		} else {
			$digirisk_transfert_options[ $document_origin ][ 'nok' ][ $document->id ][ 'file' ] = $file;
			log_class::g()->exec( 'digirisk-datas-transfert-' . $main_type , '', sprintf( __( '%1$s could not being transfered to wordpress element because it is not a file. Path: %2$s.', 'wp-digi-dtrans-i18n' ), $main_type, $file ), array( 'object_id' => $document->id, ), 2 );
		}

		/**	Set the new list of element treated	*/
		update_option( '_wpdigirisk-dtransfert', $digirisk_transfert_options );

		return $attach_id;
	}

	function transfert_picture_linked_to_element( $element_type, $old_element_id, $new_element_id = null ) {
		global $wpdb;
		$associated_document_list = array(
			'_thumbnail' => null,
			'associated_list' => array(),
		);

		$query = $wpdb->prepare(
				"SELECT PICTURE.*, PICTURE_LINK.isMainPicture, PICTURE_LINK.idElement, PICTURE_LINK.tableElement
					FROM " . TABLE_PHOTO . " AS PICTURE
						INNER JOIN " . TABLE_PHOTO_LIAISON . " AS PICTURE_LINK ON (PICTURE_LINK.idPhoto = PICTURE.id)
					WHERE PICTURE_LINK.tableElement = %s
						AND PICTURE_LINK.idElement = %d
					ORDER BY PICTURE.id ASC",
				$element_type, $old_element_id );
		$pictures = $wpdb->get_results( $query );
		if ( !empty( $pictures ) ) {
			foreach ( $pictures as $picture ) {
				$document_id = $this->transfer_document( $picture, $new_element_id, 'picture', PLUGIN_DIGIRISK_PATH . '/' );
				if ( ( null !== $document_id ) && !is_wp_error( $document_id ) ) {
					if ( 'yes' == $picture->isMainPicture ) {
						$associated_document_list[ '_thumbnail' ] = $document_id;
						log_class::g()->exec( 'digirisk-datas-transfert-picture' , '', sprintf( __( 'Association de l\'image %2$d à l\'élément %1$d', 'wp-digi-dtrans-i18n' ), $new_element_id, $document_id ), array( 'object_id' => $picture->id, 'document_old_def' => $picture ), 0 );
					} elseif ( in_array( $element_type, array( TABLE_RISQUE ) ) ) {
						/**	Set the post thumbnail in case it is the case	*/
						set_post_thumbnail( $new_element_id, $document_id );
						$associated_document_list[ '_thumbnail' ] = $document_id;
						log_class::g()->exec( 'digirisk-datas-transfert-picture' , '', sprintf( __( 'Définition de l\'image principale %2$d de l\'élément %1$d', 'wp-digi-dtrans-i18n' ), $new_element_id, $document_id ), array( 'object_id' => $picture->id, 'document_old_def' => $picture ), 0 );
					}
					$associated_document_list[ 'associated_list' ][] = $document_id;
				}
			}
		}

		return $associated_document_list;
	}

	function transfer_notification( $old_element_id, $old_element_type, $new_element_id ) {
		global $wpdb;

		/**	Get the current user notification list for current element being transfered	*/
		$query = $wpdb->prepare("
			SELECT LUN.*, NOTI.action, NOTI.message_to_send, NOTI.message_subject
			FROM " . DIGI_DBT_LIAISON_USER_NOTIFICATION_ELEMENT . " AS LUN
				INNER JOIN " . DIGI_DBT_ELEMENT_NOTIFICATION . " AS NOTI ON (NOTI.id = LUN.id_notification)
			WHERE LUN.status = 'valid'
				AND LUN.table_element = %s
				AND LUN.id_element = %d", array( $old_element_type, $old_element_id ) );
		$current_user_notification_list = $wpdb->get_results( $query );

		/**	If there are notification setted transfer them to new element	*/
		if ( !empty( $current_user_notification_list ) ) {
			$notifications = array();
			$n = 0;
			foreach ( $current_user_notification_list as $notification ) {
				$notifications[ $n ][ 'status' ] = $notification->status;
				$notifications[ $n ][ 'date_affectation' ] = $notification->date_affectation;

				$idAttributeur = ( 0 == $notification->id_attributeur ) ? 1 : $notification->id_attributeur;
				if ( empty( $_POST[ 'wpdigi-dtrans-userid-behaviour' ] ) && !empty( $_POST[ 'wp_new_user' ] ) && !empty( $_POST[ 'wp_new_user' ][ $idAttributeur ] ) ) {
					$idAttributeur = (int)$_POST[ 'wp_new_user' ][ $idAttributeur ];
				}
				$notifications[ $n ][ 'id_attributeur' ] = $idAttributeur;
				$notifications[ $n ][ 'date_desAffectation' ] = $notification->date_desAffectation;

				$idDesAttributeur = ( 0 == $notification->id_desAttributeur ) ? 1 : $notification->id_desAttributeur;
				if ( empty( $_POST[ 'wpdigi-dtrans-userid-behaviour' ] ) && !empty( $_POST[ 'wp_new_user' ] ) && !empty( $_POST[ 'wp_new_user' ][ $idDesAttributeur ] ) ) {
					$idDesAttributeur = (int)$_POST[ 'wp_new_user' ][ $idDesAttributeur ];
				}
				$notifications[ $n ][ 'id_desAttributeur' ] = $idDesAttributeur;
				$notifications[ $n ][ 'id_user' ] = $notification->id_user;
				$notifications[ $n ][ 'id_notification' ] = $notification->id_notification;
			}
			update_post_meta( $new_element_id, '_wpeo_element_notification', $notifications );
		}
	}
}

TransferData_common_class::g();
