<?php
/**
 * Manage actions for Evarisk datas transfert to Digirisk storage
 *
 * @package digirisk
 * @subpackage transfert
 */

namespace digi;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Define the main actions for digirisk transfert Datas
 */
class Transfert_Action {

	/**
	 * Instanciation principale de l'extension / Plugin instanciation
	 */
	public function __construct() {
		/**	Call wordpress hook for backend styles and scripts definition	*/
		add_action( 'admin_enqueue_scripts', array( $this, 'backend_assets' ) );
		/**	Launch transfer for elements	*/
		add_action( 'wp_ajax_wpdigi-datas-transfert-config_components', array( TransferData_components_class::g(), 'launch_transfer' ), 150 );
		add_action( 'wp_ajax_wpdigi-datas-transfert', array( $this, 'launch_transfer' ), 150 );
	}

	/**
	 * Call wordpress hook for adding scripts and styles for backend
	 */
	public function backend_assets() {
		wp_enqueue_style( 'atst-backend-css', PLUGIN_DIGIRISK_URL . 'modules/transfer_data/asset/css/backend.css', array(), config_util::$init['digirisk']->version );
	}

	/**
	 * Callback function for datas transfert
	 *
	 * @return void Send datas transfer ajax response
	 */
	function launch_transfer() {
		check_ajax_referer( 'wpdigi-datas-transfert' );
		global $wpdb;

		$log_conf = config_util::$init['wpeo_log'];
		$log_conf->log = true;

		$response = array(
			'status'						=> false,
			'reload_transfert'	=> false,
			'message'						=> __( 'A required parameter is missing, please check your request and try again', 'wp-digi-dtrans-i18n' ),
		);
		$element_type = ! empty( $_POST['element_type_to_transfert'] ) && in_array( $_POST['element_type_to_transfert'] , TransferData_class::g()->element_type, true ) ? sanitize_text_field( $_POST['element_type_to_transfert'] ): '';
		$sub_action = ! empty( $_POST['sub_action'] ) && in_array( $_POST['sub_action'] , array( 'element', 'doc', 'config_components' ), true ) ? sanitize_text_field( wp_unslash( $_POST['sub_action'] ) ) : 'element'; // input var okay.

		/**	Launch transfer for current element direct children of subtype	*/
		switch ( $element_type ) {
			case TABLE_TACHE:
				$sub_element_type = TABLE_ACTIVITE;
				break;
			case TABLE_GROUPEMENT:
				$sub_element_type = TABLE_UNITE_TRAVAIL;
				break;
		}
		$response['element_type'] = $element_type;
		$response['sub_element_type'] = $sub_element_type;

		if ( ! empty( $element_type ) ) {
			/**	Define default message and transfer reload state	*/
			$response['reload_transfert'] = true;
			$response['message'] = __( 'Import will automatically continue while all elements won\'t be transfered into database', 'wp-digi-dtrans-i18n' );

			/**	Get transfert statistics */
			$transfer_progression = TransferData_class::g()->get_transfer_progression( $element_type, $sub_element_type );

			$nb_element_to_transfert = $transfer_progression['to_transfer'];
			$nb_main_element_transfered = 0;
			if ( ! empty( $transfer_progression['transfered'][ $element_type ] ) ) {
				$nb_main_element_transfered = count( $transfer_progression['transfered'][ $element_type ] );
				if ( ! empty( $transfer_progression['transfered'][ $element_type ]['tree'] ) ) {
					$nb_main_element_transfered -= 1;
				}
				if ( ! empty( $transfer_progression['transfered'][ $element_type ]['state'] ) ) {
					$nb_main_element_transfered -= 1;
				}
			}

			$nb_sub_element_transfered = ! empty( $transfer_progression['transfered'][ $sub_element_type ] ) ? count( $transfer_progression['transfered'][ $sub_element_type ] ) : 0;
			$nb_doc_element_transfered = 0;
			$nb_doc_element_transfered += ! empty( $transfer_progression['transfered'] ) && ! empty( $transfer_progression['transfered']['picture'] ) && ! empty( $transfer_progression['transfered']['picture']['ok'] ) ? count( $transfer_progression['transfered']['picture']['ok'] ) : 0;
			$nb_doc_element_transfered += ! empty( $transfer_progression['transfered'] ) && ! empty( $transfer_progression['transfered']['document'] ) && ! empty( $transfer_progression['transfered']['document']['ok'] ) ? count( $transfer_progression['transfered']['document']['ok'] ) : 0;
			$nb_doc_element_transfered += ! empty( $transfer_progression['transfered'] ) && ! empty( $transfer_progression['transfered']['printed_duer'] ) && ! empty( $transfer_progression['transfered']['printed_duer']['ok'] ) ? count( $transfer_progression['transfered']['printed_duer']['ok'] ) : 0;
			$nb_doc_element_transfered += ! empty( $transfer_progression['transfered'] ) && ! empty( $transfer_progression['transfered']['printed_sheet'] ) && ! empty( $transfer_progression['transfered']['printed_sheet']['ok'] ) ? count( $transfer_progression['transfered']['printed_sheet']['ok'] ) : 0;
			$nb_doc_element_not_transfered = 0;
			$nb_doc_element_not_transfered += ! empty( $transfer_progression['transfered'] ) && ! empty( $transfer_progression['transfered']['picture'] ) && ! empty( $transfer_progression['transfered']['picture']['nok'] ) ? count( $transfer_progression['transfered']['picture']['nok'] ) : 0;
			$nb_doc_element_not_transfered += ! empty( $transfer_progression['transfered'] ) && ! empty( $transfer_progression['transfered']['document'] ) && ! empty( $transfer_progression['transfered']['document']['nok'] ) ? count( $transfer_progression['transfered']['document']['nok'] ) : 0;
			$nb_doc_element_not_transfered += ! empty( $transfer_progression['transfered'] ) && ! empty( $transfer_progression['transfered']['printed_duer'] ) && ! empty( $transfer_progression['transfered']['printed_duer']['nok'] ) ? count( $transfer_progression['transfered']['printed_duer']['nok'] ) : 0;
			$nb_doc_element_not_transfered += ! empty( $transfer_progression['transfered'] ) && ! empty( $transfer_progression['transfered']['printed_sheet'] ) && ! empty( $transfer_progression['transfered']['printed_sheet']['nok'] ) ? count( $transfer_progression['transfered']['printed_sheet']['nok'] ) : 0;

			$element_done = $document_done = false;
			if ( ( $nb_main_element_transfered + $nb_sub_element_transfered ) >= ( $nb_element_to_transfert->main_element_nb + $nb_element_to_transfert->sub_element_nb ) ) {
				$element_done = true;
			}
			if ( ( $nb_doc_element_transfered + $nb_doc_element_not_transfered ) >= ( $nb_element_to_transfert->nb_document + $nb_element_to_transfert->nb_picture + $nb_element_to_transfert->nb_fiches + $nb_element_to_transfert->nb_duer ) ) {
				$document_done = true;
			}
			if ( $element_done && $document_done ) {
				$response['status'] = true;
				$response['reload_transfert'] = false;
				$response['redirect_to_url'] = admin_url( 'admin.php?page=digirisk-simple-risk-evaluation' );
				$response['message'] = __( 'All elements have been transfered to new storage way into wordpress database. Please wait a minute we are redirecting you to digirisk main interface', 'wp-digi-dtrans-i18n' );

				/**	Enregistrement de la fin du transfert dans la base de données / Save transfer end into database */
				$digirisk_transfert_options = get_option( '_wpdigirisk-dtransfert', array() );
				$digirisk_transfert_options['state'] = 'complete';
				update_option( '_wpdigirisk-dtransfert', $digirisk_transfert_options );

				/** Met à jour l'option pour dire que l'installation est terminée */
				update_option( config_util::$init['digirisk']->core_option, array( 'installed' => true, 'db_version' => 1 ) );
			} elseif ( $element_done ) {
				$sub_action = 'doc';

				/** First step ( element transfer ) is complete */
				$digirisk_transfert_options = get_option( '_wpdigirisk-dtransfert', array() );
				$digirisk_transfert_options['state'] = 'first_step_complete';
				update_option( '_wpdigirisk-dtransfert', $digirisk_transfert_options );
			}

			$response['sub_action'] = $sub_action;
			switch ( $sub_action ) {
				case 'element':
					$transfer_response = $this->element_transfer( $element_type, $sub_element_type, $nb_element_to_transfert, wp_parse_args( $transfer_progression['transfered'], array( $element_type => array(), $sub_element_type => array() ) ) );
					break;
				case 'doc':
					$transfer_response = $this->document_transfer( $element_type, $sub_element_type, $nb_element_to_transfert, wp_parse_args( $transfer_progression['transfered'], array( 'document' => array( 'ok' => array(), 'nok' => array() ), 'picture' => array( 'ok' => array(), 'nok' => array() ) ) ) );
					break;
			}
		}

		$response = wp_parse_args( $transfer_response, $response );
		wp_die( wp_json_encode( $response ) );
	}

	/**
	 * [element_transfer description]
	 *
	 * @param  string $element_type            Main element type currently being transfered.
	 * @param  string $sub_element_type        Sub element type currently being transfered.
	 * @param  object $nb_element_to_transfert Each element type.
	 * @param  array  $transfered_element      The list of element already transfered.
	 *
	 * @return array                         The transfer result for current request.
	 */
	function element_transfer( $element_type, $sub_element_type, $nb_element_to_transfert, $transfered_element ) {
		global $wpdb;
		$main_element_transfered = $sub_element_transfered = 0;
		$response['element_nb_treated'] = 0;

		/**	Build a response for displaying transfer state and progression	*/
		$main_element_state = 'unstarted';
		if ( isset( $transfered_element[ $element_type ]['state'] ) ) {
			$main_element_state = $transfered_element[ $element_type ]['state'];
			unset( $transfered_element[ $element_type ]['state'] );
		}
		$treated_tree_element = array();
		if ( isset( $transfered_element[ $element_type ]['tree'] ) ) {
			$treated_tree_element = $transfered_element[ $element_type ]['tree'];
			unset( $transfered_element[ $element_type ]['tree'] );
		}
		$response['main_element_nb'] = count( $transfered_element[ $element_type ] );
		$response['sub_element_nb'] = count( $transfered_element[ $sub_element_type ] );
	 	$per_page_element_number = ( ! empty( $_POST ) && ! empty( $_POST['number_per_page'] ) ? (int) $_POST['number_per_page'] : 10 ); // WPCS: CSRF ok.

		/**	Instanciate common datas transfer utilities	*/
		if ( 'complete' !== $main_element_state ) {
			/**
			 * The query to get element list to transfert
			 *
			 * @var string
			 */
			$initial_transfert = false;
			if ( $response['main_element_nb'] !== (int) $nb_element_to_transfert->main_element_nb ) {
		 		$initial_transfert = true;
				$main_element_state = 'in_progress';
			}
			$exclude_list = array( 1 );
			if ( ( true === $initial_transfert ) && ! empty( $transfered_element ) && isset( $transfered_element[ $element_type ] ) ) {
				$exclude_list = wp_parse_args( $transfered_element[ $element_type ], $exclude_list );
			} elseif ( false === $initial_transfert ) {
				$exclude_list = wp_parse_args( $treated_tree_element, $exclude_list );
				$per_page_element_number = $per_page_element_number * 2;
			}
			$query = $wpdb->prepare( "SELECT * FROM {$element_type} WHERE id NOT IN ( " . implode( ',', $exclude_list ) . " ) LIMIT " . $per_page_element_number, '' );
			$main_element_list = $wpdb->get_results( $query );
			if ( ! empty( $main_element_list ) ) {
				foreach ( $main_element_list as $element ) {
					switch ( $element_type ) {
						case TABLE_TACHE:
							// @Todo Transfert data for tasks
						break;

						case TABLE_GROUPEMENT:
							/** Initial transfer is the first steop to transfer all datas without taking care about tree */
							if ( true === $initial_transfert ) {
								$digirisk_group = wpdigi_transferdata_society_class::g()->transfert_groupement( $element );
								if ( ! is_wp_error( $digirisk_group ) && is_int( $digirisk_group->id ) ) {
									/** Increment successfully treated element number */
									$response['element_nb_treated'] += 1;

									/**	Store an option to avoid multiple transfer	*/
									$transfered_element[ $element_type ][] = $element->id;
								}
							} else {
								$element_parent = getPere( TABLE_GROUPEMENT, $element, "1" );
								if ( null !== $element_parent ) {
									$query = $wpdb->prepare( "
										UPDATE {$wpdb->posts}
										SET post_parent = (
											SELECT post_id
											FROM {$wpdb->postmeta}
											WHERE meta_key = %s
												AND meta_value = %s
										)
										WHERE ID = (
											SELECT post_id
											FROM {$wpdb->postmeta}
											WHERE meta_key = %s
												AND meta_value = %s
										)",
											'_wpdigi_element_computed_identifier', TABLE_GROUPEMENT . '#value_sep#' . $element_parent->id,
											'_wpdigi_element_computed_identifier', TABLE_GROUPEMENT . '#value_sep#' . $element->id
									);
									$set_parent = $wpdb->query( $query );
									if ( false !== $set_parent ) {
										$treated_tree_element[] = $element->id;
										log_class::g()->exec( 'digirisk-datas-transfert-' . TABLE_GROUPEMENT . '-tree', '', sprintf( __( 'L\'élément parent %1$d a bien été associé à %2$d', 'wp-digi-dtrans-i18n' ), $element_parent->id, $element->id ), array( 'object_id' => $element->id ), 0 );
									} else {
										log_class::g()->exec( 'digirisk-datas-transfert-' . TABLE_GROUPEMENT . '-tree', '', sprintf( __( 'Aucun parent n\'a pu être associé à %d', 'wp-digi-dtrans-i18n' ), $element->id ), array( 'object_id' => $element->id ), 2 );
									}
								} else {
									$treated_tree_element[] = $element->id;
									log_class::g()->exec( 'digirisk-datas-transfert-' . TABLE_GROUPEMENT . '-tree', '', sprintf( __( 'L\'élément %d ne possédait pas d\'élément parent', 'wp-digi-dtrans-i18n' ), $element->id ), array( 'object_id' => $element->id ), 1 );
								}
							}
						break;
					}
				}
			}

			/** Check if the current element transfered element number correspond to  */
			if ( true === $initial_transfert ) {
				$response['main_element_nb'] += $response['element_nb_treated'];
				if ( ( $response['main_element_nb'] === (int) $nb_element_to_transfert->main_element_nb ) ) {
					$main_element_state = 'tree_to_check';
				}
			} else {
				if ( ( count( $treated_tree_element ) === (int) $nb_element_to_transfert->main_element_nb ) ) {
					$main_element_state = 'complete';
				}
			}

			/**	GSave current transfert state	*/
			$digirisk_transfer_options = get_option( '_wpdigirisk-dtransfert', array() );
			$digirisk_transfer_options[ $element_type ] = $transfered_element[ $element_type ];
			$digirisk_transfer_options[ $element_type ]['state'] = $main_element_state;
			$digirisk_transfer_options[ $element_type ]['tree'] = $treated_tree_element;
			$response['treated_tree'] = count( $treated_tree_element );
			update_option( '_wpdigirisk-dtransfert', $digirisk_transfer_options );

		} elseif ( ( 'complete' === $main_element_state ) && ( count( $transfered_element[ $sub_element_type ] ) < $nb_element_to_transfert->sub_element_nb ) ) {
			/**	Start the query buiding	*/
			$query = 'SELECT * FROM ' . $sub_element_type . ' WHERE 1';
			/**	Check if there are already element of current types that have been transferd in order to exclude them of query	*/
			$transfered_element = get_option( '_wpdigirisk-dtransfert', array() );
			if ( ! empty( $transfered_element ) && ! empty( $transfered_element[ $sub_element_type ] ) && is_array( $transfered_element[ $sub_element_type ] ) ) {
				$query .= " AND id NOT IN ('" . implode( "', '", $transfered_element[ $sub_element_type ] ) . "')";
			}
			$query .= ' LIMIT 0, ' . $per_page_element_number;

			/**	Get current element sub type	*/
			$children = $wpdb->get_results( $query );
			if ( ! empty( $children ) ) {
				foreach ( $children as $child ) {
					switch ( $element_type ) {
						case TABLE_TACHE:
							$field_for_parent = 'id_tache';
							break;

						case TABLE_GROUPEMENT:
							$field_for_parent = 'id_groupement';
							break;
					}
					/**	Get the current element parent identifier into the new system	*/
					$query = $wpdb->prepare( "
						SELECT post_id
						FROM {$wpdb->postmeta}
						WHERE ( meta_value = %s AND meta_key = %s )", $element_type . '#value_sep#' . $child->$field_for_parent, '_wpdigi_element_computed_identifier' );
					$element_parent_id = $wpdb->get_var( $query );

					/**	Launch transfert for element subtype	*/
					$new_children_id = TransferData_common_class::g()->transfer( $sub_element_type, $child, $element_parent_id );
					if ( ! is_wp_error( $new_children_id ) ) {
						$response['element_nb_treated']++;
					}
				}
			}

			$response['sub_element_nb'] += $response['element_nb_treated'];
		}

		return $response;
	}

	/**
	 * Transfert the document
	 *
	 * @param  [type] $element_type            [description].
	 * @param  [type] $sub_element_type        [description].
	 * @param  [type] $nb_element_to_transfert [description].
	 * @param  [type] $transfered_element      [description].
	 *
	 * @return [type]                          [description]
	 */
	function document_transfer( $element_type, $sub_element_type, $nb_element_to_transfert, $transfered_element ) {
		global $wpdb;
		$all_heavy_element_done = false;
		$response['element_nb_treated'] = 0;
		$response['transfered'] = 0;
		$response['not_transfered'] = 0;

		$current_loop_nb = 0;

		/** Picture treatment */
		$where = '';
		$pictures_to_check = array();
		if ( ! empty( $transfered_element['picture']['ok'] ) && is_array( $transfered_element['picture']['ok'] ) ) {
			$pictures_to_check = array_merge( $pictures_to_check, $transfered_element['picture']['ok'] );
			$response['transfered'] += count( $transfered_element['picture']['ok'] );
		}
		if ( ! empty( $transfered_element['picture']['nok'] ) && is_array( $transfered_element['picture']['nok'] ) ) {
			/**	For not ok picture, the foreach is mandatory because implode return an error due to not ok array structure	*/
			foreach ( $transfered_element['picture']['nok'] as $picture_id => $picture_path ) {
				$pictures_to_check[] = $picture_id;
			}
			$response['not_transfered'] += count( $transfered_element['picture']['nok'] );
		}
		if ( ! empty( $pictures_to_check ) ) {
			$where .= "AND PICTURE.id NOT IN ( '" . implode( "', '", $pictures_to_check ) . "' )";
		}
		$pics_are_done = true;
		$query =
			'SELECT PICTURE.*, PICTURE_LINK.status as LINK_STATUS, PICTURE_LINK.isMainPicture, PICTURE_LINK.idElement, PICTURE_LINK.tableElement
      FROM ' . TABLE_PHOTO . ' AS PICTURE
        INNER JOIN ' . TABLE_PHOTO_LIAISON . " AS PICTURE_LINK ON (PICTURE_LINK.idPhoto = PICTURE.id)
			WHERE PICTURE_LINK.tableElement IN ( '{$element_type}', '{$sub_element_type}' )
				{$where}
			ORDER BY PICTURE.id ASC
			LIMIT " . DIGI_DTRANS_NB_ELMT_PER_PAGE;
		$pictures = $wpdb->get_results( $query );
		if ( ! empty( $pictures ) ) {
			foreach ( $pictures as $picture ) {
				$query = $wpdb->prepare(
					"SELECT P.ID
					FROM {$wpdb->posts} AS P
						INNER JOIN {$wpdb->postmeta} AS PMID ON ( PMID.post_id = P.ID )
					WHERE PMID.meta_key = %s
						AND PMID.meta_value = %s",
					array( '_wpdigi_element_computed_identifier', $picture->tableElement . '#value_sep#' . $picture->idElement )
				);
				(int) $new_element_id = $wpdb->get_var( $query );

				$document_id = TransferData_common_class::g()->transfer_document( $picture, $new_element_id, 'picture' );
				if ( ( null !== $document_id ) && ! is_wp_error( $document_id ) ) {
					$response['transfered']++;
					$current_loop_nb++;

					/**	Association des images aux différents éléments / Associate picture to elements	*/
					if ( ! empty( $new_element_id ) ) {
						switch ( $picture->tableElement ) {
							case TABLE_UNITE_TRAVAIL:
									$elt = workunit_class::g()->get( array( 'post_status' => array( 'publish', 'draft', 'trash' ), 'p' => $new_element_id ) );
									$elt = $elt[0];
									$elt->associated_document_id['image'][] = $document_id;
									workunit_class::g()->update( $elt );
								break;
							case TABLE_GROUPEMENT:
									$elt = group_class::g()->get( array( 'post_status' => array( 'publish', 'draft', 'trash' ), 'p' => $new_element_id ) );
									$elt = $elt[0];
									$elt->associated_document_id['image'][] = $document_id;
									group_class::g()->update( $elt );
								break;
							case TABLE_TACHE:
								break;
							case TABLE_ACTIVITE:
								break;
						}
					}

					/**	Certaines images nécessite un traitement spécifique / Do specific treatment for pictures	*/
					/**	Affectation de l'image a un risque / Associate picture to a risk	*/
					$query = $wpdb->prepare(
						"SELECT idElement
            FROM " . TABLE_PHOTO_LIAISON . "
            WHERE idPhoto = %d
              AND tableElement = %s", $picture->id, TABLE_RISQUE
					);
					$picture_to_risk_association = $wpdb->get_var( $query );
					if ( ! empty( $picture_to_risk_association ) ) {
						$query = $wpdb->prepare(
							"SELECT P.ID
							FROM {$wpdb->posts} AS P
								INNER JOIN {$wpdb->postmeta} AS PMID ON ( PMID.post_id = P.ID )
							WHERE PMID.meta_key = %s
								AND PMID.meta_value = %s",
							array( '_wpdigi_element_computed_identifier', TABLE_RISQUE . '#value_sep#' . $picture_to_risk_association )
						);
						$new_risk_id = $wpdb->get_var( $query );
						set_post_thumbnail( $new_risk_id, $document_id );
					}
				} else {
					$response['not_transfered']++;
				}
				$response['element_nb_treated']++;
			}
			$pics_are_done = false;
		}

		/**
		 *	Documents treatment
		 */
		if ( DIGI_DTRANS_NB_ELMT_PER_PAGE !== $current_loop_nb) {
			$where = '';
			$documents_to_check = array();
			if ( ! empty( $transfered_element['document']['ok'] ) && is_array( $transfered_element['document']['ok'] ) ) {
				$documents_to_check = array_merge( $documents_to_check, $transfered_element['document']['ok'] );
				$response['transfered'] += count( $transfered_element['document']['ok'] );
			}
			if ( ! empty( $transfered_element['document']['nok'] ) && is_array( $transfered_element['document']['nok'] ) ) {
				/**	For not ok document, the foreach is mandatory because implode return an error due to not ok array structure	*/
				foreach ( $transfered_element['document']['nok'] as $document_id => $document_path ) {
					$documents_to_check[] = $document_id;
				}
				$response['not_transfered'] += count( $transfered_element['document']['nok'] );
			}
			if ( ! empty( $documents_to_check ) ) {
				$where .= "AND DOCUMENT.id NOT IN ( '" . implode( "', '", $documents_to_check ) . "' )";
			}
			$docs_are_done = true;
			$query =
				'SELECT *
	      FROM ' . TABLE_GED_DOCUMENTS . " AS DOCUMENT
				WHERE table_element IN ( '{$element_type}', '{$sub_element_type}' )
					{$where}
				ORDER BY id ASC
				LIMIT " . ( DIGI_DTRANS_NB_ELMT_PER_PAGE - $current_loop_nb );
			$documents = $wpdb->get_results( $query );
			if ( ! empty( $documents ) ) {
				foreach ( $documents as $document ) {
					$query = $wpdb->prepare(
						"SELECT P.ID
						FROM {$wpdb->posts} AS P
							INNER JOIN {$wpdb->postmeta} AS PMID ON ( PMID.post_id = P.ID )
						WHERE PMID.meta_key = %s
							AND PMID.meta_value = %s",
						array( '_wpdigi_element_computed_identifier', $document->table_element . '#value_sep#' . $document->id_element )
					);
					$new_element_id = $wpdb->get_var( $query );

					$query = $wpdb->prepare(
						'SELECT meta_key, meta_value
	          FROM ' . TABLE_GED_DOCUMENTS_META . '
	          WHERE document_id = %d', $document->id
					);
					$document->meta = $wpdb->get_results( $query );
					$current_meta_index = count( $document->meta );
					$default_meta_index = $current_meta_index + 1;
					$document->meta[ $default_meta_index ] = new \stdClass();
					$document->meta[ $default_meta_index ]->meta_key = 'is_default';
					$document->meta[ $default_meta_index ]->meta_value = $document->parDefaut;

					$document_id = TransferData_common_class::g()->transfer_document( $document, $new_element_id, 'document' );
					if ( ( null !== $document_id ) && ! is_wp_error( $document_id ) ) {
						$response['transfered']++;
						$current_loop_nb++;

						$term_to_associate = array();
						$term_to_associate[] = $document->categorie;
						if ( 'uploads/modeles/' === substr( $document->chemin, 0, 16 ) ) {
							$term_to_associate[] = 'model';
						} else {
							$term_to_associate[] = 'printed';
						}
						wp_set_object_terms( $document_id, $term_to_associate, 'attachment_category' );

						/**	Get the element created for new data transfer	*/
						$doc_model = document_class::g()->get( array( 'p' => $document_id, 'post_status' => array( 'publish', 'pending', 'draft', 'auto-draft', 'future', 'private', 'inherit', 'trash' ) ) );
						$doc_model = $doc_model[0];

						$doc_model->parent_id = $new_element_id;
						$doc_model->unique_key = $document->id;
						$doc_model->unique_identifier = ELEMENT_IDENTIFIER_DOC . $document->id;
						$doc_model->model_id = null;
						document_class::g()->update( $doc_model );
					} else {
						$response['not_transfered']++;
					}
					$response['element_nb_treated']++;
				}
				$docs_are_done = false;
			}
		}

		/**	Printed document treatment */
		if ( DIGI_DTRANS_NB_ELMT_PER_PAGE !== $current_loop_nb) {
			$where = '';
			$documents_to_check = array();
			if ( ! empty( $transfered_element['printed_duer']['ok'] ) && is_array( $transfered_element['printed_duer']['ok'] ) ) {
				$documents_to_check = array_merge( $documents_to_check, $transfered_element['printed_duer']['ok'] );
				$response['transfered'] += count( $transfered_element['printed_duer']['ok'] );
			}
			if ( ! empty( $transfered_element['printed_duer']['nok'] ) && is_array( $transfered_element['printed_duer']['nok'] ) ) {
				/**	For not ok document, the foreach is mandatory because implode return an error due to not ok array structure	*/
				foreach ( $transfered_element['printed_duer']['nok'] as $document_id => $document_path ) {
					$documents_to_check[] = $document_id;
				}
				$response['not_transfered'] += count( $transfered_element['printed_duer']['nok'] );
			}
			if ( ! empty( $documents_to_check ) ) {
				$where .= "AND id NOT IN ( '" . implode( "', '", $documents_to_check ) . "' )";
			}
			$query =
				"SELECT *, element AS table_element, elementID as id_element, 'printed_fiche_action' as categorie, CONCAT( 'documentUnique/', element, '/', elementId, '/', nomDUER, '_V', revisionDUER, '.odt' ) as chemin, null as nom, null as idCreateur, dateGenerationDUER as dateCreation
				FROM " . TABLE_DUER . "
				WHERE element IN ( '{$element_type}', '{$sub_element_type}' )
					{$where}
				ORDER BY id ASC
				LIMIT " . ( DIGI_DTRANS_NB_ELMT_PER_PAGE - $current_loop_nb );
			$duers = $wpdb->get_results( $query );
			if ( ! empty( $duers ) ) {
				foreach ( $duers as $duer ) {
					$query = $wpdb->prepare(
						"SELECT P.ID
							FROM {$wpdb->posts} AS P
							INNER JOIN {$wpdb->postmeta} AS PMID ON ( PMID.post_id = P.ID )
							WHERE PMID.meta_key = %s
							AND PMID.meta_value = %s",
						array( '_wpdigi_element_computed_identifier', $duer->element . '#value_sep#' . $duer->elementId )
					);
					$new_element_id = $wpdb->get_var( $query );

					$document_id = TransferData_common_class::g()->transfer_document( $duer, $new_element_id, 'printed_duer' );
					if ( ( null !== $document_id ) && ! is_wp_error( $document_id ) ) {
						$response['transfered']++;
						$current_loop_nb++;
						wp_set_object_terms( $document_id, array( 'document_unique', 'printed' ), 'attachment_category' );

						/**	Get the element created for new data transfer	*/
						$doc_model = document_class::g()->get( array( 'p' => $document_id, 'post_status' => array( 'publish', 'pending', 'draft', 'auto-draft', 'future', 'private', 'inherit', 'trash' ) ) );
						$doc_model = $doc_model[0];

						/**	Build the model for new data storage */
						$doc_model->type = DUER_Class::g()->get_post_type();
						$doc_model->parent_id = $new_element_id;
						$doc_model->unique_key = $duer->id;
						$doc_model->unique_identifier = ELEMENT_IDENTIFIER_DU . $duer->id;
						$doc_model->model_id = $duer->id_model;
						DUER_Class::g()->update( $doc_model );
					} else {
							$response['not_transfered']++;
					}
					$response['element_nb_treated']++;
				}
				$docs_are_done = false;
			}
		}

		/**	Printed document treatment */
		if ( DIGI_DTRANS_NB_ELMT_PER_PAGE !== $current_loop_nb ) {
			$where = '';
			$documents_to_check = array();
			if ( ! empty( $transfered_element['printed_sheet']['ok'] ) && is_array( $transfered_element['printed_sheet']['ok'] ) ) {
				$documents_to_check = array_merge( $documents_to_check, $transfered_element['printed_sheet']['ok'] );
				$response['transfered'] += count( $transfered_element['printed_sheet']['ok'] );
			}
			if ( ! empty( $transfered_element['printed_sheet']['nok'] ) && is_array( $transfered_element['printed_sheet']['nok'] ) ) {
				/**	For not ok document, the foreach is mandatory because implode return an error due to not ok array structure	*/
				foreach ( $transfered_element['printed_sheet']['nok'] as $document_id => $document_path ) {
					$documents_to_check[] = $document_id;
				}
				$response['not_transfered'] += count( $transfered_element['printed_sheet']['nok'] );
			}
			if ( ! empty( $documents_to_check ) ) {
				$where .= "AND id NOT IN ( '" . implode( "', '", $documents_to_check ) . "' )";
			}
			$query =
				"SELECT *, 'printed_fiche_action' as categorie, CONCAT( 'directory_to_change_later/', table_element, '/', id_element, '/', name, '_V', revision, '.odt' ) as chemin, '' as nom, null as status, null as idCreateur, creation_date as dateCreation
				FROM " . TABLE_FP . "
				WHERE table_element IN ( '{$element_type}', '{$sub_element_type}' )
					{$where}
				ORDER BY id ASC
				LIMIT " . ( DIGI_DTRANS_NB_ELMT_PER_PAGE - $current_loop_nb );
			$sheets = $wpdb->get_results( $query );
			if ( ! empty( $sheets ) ) {
				foreach ( $sheets as $sheet ) {
					$query = $wpdb->prepare(
						"SELECT P.ID
							FROM {$wpdb->posts} AS P
							INNER JOIN {$wpdb->postmeta} AS PMID ON ( PMID.post_id = P.ID )
							WHERE PMID.meta_key = %s
							AND PMID.meta_value = %s",
						array( '_wpdigi_element_computed_identifier', $sheet->table_element . '#value_sep#' . $sheet->id_element )
					);
					$new_element_id = $wpdb->get_var( $query );

					$specific_element_type = '';
					switch ( $sheet->document_type ) {
						case 'fiche_de_groupement':
							$directory_to_use = 'ficheDeGroupement';
							$specific_element_type = 'Fiche_De_Groupement_Class';
							break;
						case 'fiche_de_poste':
							$directory_to_use = 'ficheDePoste';
							$specific_element_type = 'Fiche_De_Poste_Class';
							break;
						case 'listing_des_risques':
							$directory_to_use = 'listingRisque';
							break;
						case 'fiche_exposition_penibilite':
							$directory_to_use = 'ficheDeRisques';
							break;
						case 'user_global_export':
							$directory_to_use = ELEMENT_IDENTIFIER_GUE;
							break;
					}
					$sheet->chemin = str_replace( 'directory_to_change_later', $directory_to_use, $sheet->chemin );

					$document_id = TransferData_common_class::g()->transfer_document( $sheet, $new_element_id, 'printed_sheet' );
					if ( ( null !== $document_id ) && ! is_wp_error( $document_id ) ) {
						$response['transfered']++;
						$current_loop_nb++;

						wp_set_object_terms( $document_id, array( $sheet->document_type, 'printed' ), 'attachment_category' );

						/**	Get the element created for new data transfer	*/
						$doc_model = document_class::g()->get( array( 'p' => $document_id, 'post_status' => array( 'publish', 'pending', 'draft', 'auto-draft', 'future', 'private', 'inherit', 'trash' ) ) );
						$doc_model = $doc_model[0];

						/**	Build the model for new data storage */
						$doc_model->parent_id = $new_element_id;
						$doc_model->unique_key = $sheet->id;
						$doc_model->unique_identifier = ELEMENT_IDENTIFIER_DOC . $sheet->id;
						$doc_model->model_id = $sheet->id_model;

						if ( ! empty( $specific_element_type ) ) {
							switch ( $sheet->document_type ) {
								case 'fiche_de_groupement':
									$doc_model->type = Fiche_De_Groupement_Class::g()->get_post_type();
									Fiche_De_Groupement_Class::g()->update( $doc_model );
									break;
								case 'fiche_de_poste':
									$doc_model->type = Fiche_De_Poste_Class::g()->get_post_type();
									Fiche_De_Poste_Class::g()->update( $doc_model );
									break;
							}
						} else {
							/**	Get the element created for new data transfer	*/
							$doc_model = document_class::g()->get( array( 'p' => $document_id, 'post_status' => array( 'publish', 'pending', 'draft', 'auto-draft', 'future', 'private', 'inherit', 'trash' ) ) );
							$doc_model = $doc_model[0];

							/**	Build the model for new data storage */
							$doc_model->parent_id = $new_element_id;
							$doc_model->unique_key = $sheet->id;
							$doc_model->unique_identifier = ELEMENT_IDENTIFIER_DOC . $sheet->id;
							$doc_model->model_id = $sheet->id_model;

							document_class::g()->update( $doc_model );
						}
					} else {
						$response['not_transfered']++;
					}
					$response['element_nb_treated']++;
				}
				$docs_are_done = false;
			}
		}

		/**	In case all pictures and documents have been treated	*/
		if ( $pics_are_done && $docs_are_done ) {
			$response['reload_transfert'] = false;
		}
		return $response;
	}

}

new Transfert_Action();
