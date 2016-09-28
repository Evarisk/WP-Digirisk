<?php if ( !defined( 'ABSPATH' ) ) exit;
/**
 * Fichier du controlleur principal de l'extension digirisk pour wordpress / Main controller file for digirisk plugin
 *
 * @author Evarisk development team <dev@evarisk.com>
 * @version 6.0
 */

/**
 * Classe du controlleur principal de l'extension digirisk pour wordpress / Main controller class for digirisk plugin
 *
 * @author Evarisk development team <dev@evarisk.com>
 * @version 6.0
 */
class group_duer_class extends singleton_util {
	/**
	* Le constructeur
	*/
	protected function construct() {}

	/**
	* Génère le DUER
	*
	* @param array $data Les data à mettre dans le ODT
	*/
	public function generate( $data ) {
		if ( empty( $data ) || empty( $data['element_id'] ) ) {
			return false;
		}

		$id = (int) $data['element_id'];
		$element = group_class::g()->get( array( 'id' => $id ) );
		$element = $element[0];

		/**	Définition des composants du fichier / Define the file component	*/
		$src_logo = $this->get_logo();
		$data['wpdigi_duer'] = $this->securize_duer_data( $data );
		$data_to_document = $this->prepare_skeleton();
		$data_to_document = $this->fill_data_duer( $data['wpdigi_duer'], $data_to_document, $element );
		$data_to_document = $this->fill_data_risk( $data_to_document, $element );

		/**	Possibilité de filtrer les données envoyées au document pour ajout, suppression, traitement supplémentaire / Add capability to filter datas sended to the document for addition, deletion or other treatment	*/
		$data_to_document = apply_filters( 'wpdigi_element_duer_details', $data_to_document );

		/**	Call document creation function / Appel de la fonction de création du document	*/
		$document_creation_response = document_class::g()->create_document( $element, array( 'document_unique' ), $data_to_document );

		if ( !empty( $document_creation_response[ 'id' ] ) ) {
			$element->associated_document_id[ 'document' ][] = $document_creation_response[ 'id' ];
			group_class::g()->update( $element );
		}

		$all_file = $this->generate_child( $element );
		$all_file[] = $document_creation_response;

		$element = group_class::g()->get( array( 'id' => $element->id ) );
		$element = $element[0];

		/**	Generate a zip file with all sheet for current group, sub groups, and sub work units / Génération du fichier zip contenant les fiches du groupement actuel, des sous groupements et des unités de travail	*/
		$version = document_class::g()->get_document_type_next_revision( array( 'zip' ), $element->id );
		$zip_generation_result = document_class::g()->create_zip( document_class::g()->get_digirisk_dir_path() . '/' . $element->type . '/' . $element->id . '/' . mysql2date( 'Ymd', current_time( 'mysql', 0 ) ) . '_' . $element->unique_identifier . '_zip_' . sanitize_title( str_replace( ' ', '_', $element->title ) ) . '_V' . $version . '.zip', $all_file, $element, $version );

		return true;
	}

	/**
	* Securises toutes les données
	*
	* @param array $data Les données à sécuriser
	*
	* @return array Les données sécurisées
	*/
	public function securize_duer_data( $data ) {
		$data_duer = array();

		$data_duer['nomEntreprise'] 			= !empty( $data['nomEntreprise'] ) ? sanitize_text_field( $data['nomEntreprise'] ) : '';
		$data_duer['dateAudit'] 					= $this->formatte_audit_date( $data_duer );
		$data_duer['emetteurDUER'] 				= !empty( $data['emetteurDUER'] ) ? sanitize_text_field( $data['emetteurDUER'] ) : '';
		$data_duer['destinataireDUER'] 		= !empty( $data['destinataireDUER'] ) ? sanitize_text_field( $data['destinataireDUER'] ) : '';
		$data_duer['telephone'] 					= !empty( $data['telephone'] ) ? sanitize_text_field( $data['telephone'] ) : '';
		$data_duer['portable'] 						= !empty( $data['portable'] ) ? sanitize_text_field( $data['portable'] ) : '';

		$data_duer['methodologie'] 				= !empty( $data['methodologie'] ) ? $data['methodologie'] : '';
		$data_duer['sources'] 						= !empty( $data['sources'] ) ? $data['sources'] : '';
		$data_duer['remarqueImportante'] 	= !empty( $data['remarqueImportante'] ) ? $data['remarqueImportante'] : '';
		$data_duer['dispoDesPlans'] 			= !empty( $data['dispoDesPlans'] ) ? $data['dispoDesPlans'] : '';

		return $data_duer;
	}

	/**
	* Prépares un squelette des données
	*
	* @return array Le squelette des données
	*/
	public function prepare_skeleton() {
		/**	Définition de la structure des données du document par défaut / Define the default data structure for document	*/
		$skeleton = array(
			'identifiantElement'	=> '',
			'nomEntreprise'				=> '',
			'dateAudit'						=> '',
			'emetteurDUER'				=> '',
			'destinataireDUER'		=> '',
			'dateGeneration'			=> '',
			'telephone'						=> '',
			'portable'						=> '',

			'methodologie'				=> '',
			'sources'							=> '',
			'remarqueImportante'	=> '',
			'dispoDesPlans'				=> '',

			'elementParHierarchie' => array(
				'type'	=> 'segment',
				'value'	=> array(),
			),

			'risq' => array(
				'type'	=> 'segment',
				'value'	=> array(),
			),

			'risqueFiche' => array(
				'type'	=> 'segment',
				'value'	=> array(),
			),

			'planDactionRisq' => array(
				'type'	=> 'segment',
				'value'	=> array(),
			),

			'planDaction' => array(
				'type'	=> 'segment',
				'value'	=> array(),
			),
		);

		$level_list = array( 48, 51, 80, );
		foreach ( $level_list as $level ) {
			$skeleton[ 'risq' . $level ] = array(
				'type'	=> 'segment',
				'value'	=> array(),
			);
			$skeleton[ 'planDactionRisq' . $level ] = array(
				'type'	=> 'segment',
				'value'	=> array(),
			);
		}

		return $skeleton;
	}

	/**
	* Récupères le logo: todo: Pas utiliser
	*
	* @return string Le chemin vers le logo
	*/
	public function get_logo() {
		$custom_logo_id = get_theme_mod( 'custom_logo' );
		$src_logo = wp_get_attachment_image_src( $custom_logo_id, 'full' );
		return $src_logo;
	}

	/**
	* Remplis les données du duer
	*
	* @param array $data_duer Les données sécurisées
	* @param array $data_to_document Les données qui seront insérées dans le document
	* @param object $element L'objet groupement
	*
	* @return array Les données qui seront insérées dans le document
	*/
	public function fill_data_duer( $data_duer, $data_to_document, $element ) {
		$data_to_document = array_merge( $data_to_document, $data_duer );
		$data_to_document['identifiantElement'] = $element->unique_identifier;
		$data_to_document['dateAudit'] = $this->formatte_audit_date( $data_duer );
		$data_to_document['dateGeneration'] = mysql2date( get_option( 'date_format' ), current_time( 'mysql', 0 ), true );
		$data_to_document['elementParHierarchie']['value'] = group_class::g()->get_element_sub_tree( $element );
		return $data_to_document;
	}

	/**
	* Remplis les données du duer des risques
	*
	* @param array $data_to_document Les données qui seront insérées dans le document
	* @param object $element L'objet groupement
	*
	* @return array Les données qui seront insérées dans le document
	*/
	public function fill_data_risk( $data_to_document, $element ) {
		$list_risk = group_class::g()->get_element_tree_risk( $element );
		$risk_per_element = array();

		if ( count( $list_risk ) > 1 ) {
			usort( $list_risk, function( $a, $b ) {
				if( $a['quotationRisque'] == $b['quotationRisque'] ) {
					return 0;
				}
				return ( $a['quotationRisque'] > $b['quotationRisque'] ) ? -1 : 1;
			} );
		}

		if ( !empty( $list_risk ) ) {
		  foreach ( $list_risk as $risk ) {
				$final_level = !empty( evaluation_method_class::g()->list_scale[$risk[ 'niveauRisque' ]] ) ? evaluation_method_class::g()->list_scale[$risk[ 'niveauRisque' ]] : '';
				$data_to_document[ 'risq' . $final_level ][ 'value' ][] = $risk;
				$data_to_document[ 'planDactionRisq' . $final_level ][ 'value' ][] = $risk;

				if ( !isset( $risk_per_element[ $risk[ 'idElement' ] ] ) ) {
					$risk_per_element[ $risk[ 'idElement' ] ][ 'quotationTotale' ] = 0;
				}
				$risk_per_element[ $risk[ 'idElement' ] ][ 'quotationTotale' ] += $risk[ 'quotationRisque' ];
		  }
		}

		$element_sub_tree = group_class::g()->get_element_sub_tree( $element , '', array( 'default' => array( 'quotationTotale' => 0, ), 'value' => $risk_per_element, ) );
		if ( count( $element_sub_tree ) > 1 ) {
			usort( $element_sub_tree, function( $a, $b ) {
				if( $a['quotationTotale'] == $b['quotationTotale'] ) {
					return 0;
				}
				return ( $a['quotationTotale'] > $b['quotationTotale'] ) ? -1 : 1;
			} );
		}
		$data_to_document[ 'risqueFiche' ][ 'value' ] = $element_sub_tree;

		return $data_to_document;
	}

	/**
	* Formattes la date de l'audit
	*
	* @param array $data_duer Les données sécurisées
	*
	* @return string La date de l'audit formatté
	*/
	public function formatte_audit_date( $data_duer ) {
		$audit_date = '';

		if ( !empty( $data_duer['dateDebutAudit' ] ) ) {
			$audit_date .= sanitize_text_field( $data_duer['dateDebutAudit'] );
		}

		if ( !empty( $data_duer['dateFinAudit'] ) && $audit_date != $data_duer['dateFinAudit'] ) {
			if ( !empty( $audit_date ) ) {
				$audit_date .= ' - ';
			}

			$audit_date .= sanitize_text_field( $data_duer['dateFinAudit'] );
		}

		return $audit_date;
	}

	/**
	* Génère les ODT enfants de ce DUER
	*
	* @param object $element L'élement groupement
	*
	* @return array La liste des ODT enfants
	*/
	public function generate_child( $element ) {
		// if ( !is_object( $element ) ) {
		// 	return false;
		// }
		// Generate children
		$list_id = array();

		/**	Build a file list to set into the final zip / Contruit la liste des fichiers a ajouter dans le zip lorsque les générations sont terminées	*/
		$response = array();
		$response[] = sheet_groupment_class::g()->generate_sheet( $element->id );

		/**	Get workunit list for the current group / Récupération de la liste des unités de travail pour le groupement actuel	*/
		$work_unit_list = workunit_class::g()->get( array( 'posts_per_page' => -1, 'post_parent' => $element->id, 'post_status' => array( 'publish', 'draft', ), ), false );
		foreach( $work_unit_list as $workunit ) {
			$response[] = workunit_sheet_class::g()->generate_workunit_sheet( $workunit->id );
		}

		$list_id = group_class::g()->get_element_sub_tree_id( $element->id, $list_id );
		if ( !empty( $list_id ) ) {
			foreach( $list_id as $element ) {
				if( !empty( $element['workunit'] ) ) {
					if( !empty( $element['id'] ) ) {
						$response[] = sheet_groupment_class::g()->generate_sheet( $element['id'] );
					}
					foreach( $element['workunit'] as $workunit_id ) {
						$response[] = workunit_sheet_class::g()->generate_workunit_sheet( $workunit_id['id'] );
					}
				}
				else {
					if( !empty( $element['id'] ) ) {
						$response[] = sheet_groupment_class::g()->generate_sheet( $element['id'] );
					}
				}
			}
		}

		return $response;
	}
}
