<?php
/**
 * Gestion de l'export d'un groupement ainsi que ses enfants:
 * Groupement
 * Unite de travail
 * Risque
 *
 * @author Alexandre Techer <dev@evarisk.com>
 * @since 6.1.5.5
 * @copyright 2015-2016 Evarisk
 * @package Digirisk\dashboard
 * @subpackage class
 */

namespace digi;

if ( ! defined( 'ABSPATH' ) ) { exit; }

/**
 * Gestion de l'export d'un groupement ainsi que ses enfants:
 * Groupement
 * Unite de travail
 * Risque
 */
class Export_Class extends Singleton_Util {
	/**
	 * Le chemin vers le répertoire uploads/Digirisk/export
	 *
	 * @var string
	 */
	private $export_directory;

	/**
	 * Constructeur de la classe. Doit être présent même si vide pour coller à la définition "abstract" des parents / Class constructor. Must be present even if empty for matchin with "abstract" definition of ancestors
	 */
	function construct() {
		/** Définition des chemins vers les exports / Define path where export will be saved */
		$wp_upload_dir = wp_upload_dir();
		$this->export_directory = $wp_upload_dir['basedir'] . '/digirisk/export/';
		wp_mkdir_p( $this->export_directory );
	}

	/**
	 * Appelles différentes méthodes pour récupérer toutes les données pour exporter le DigiRisk
	 *
	 * @return array
	 */
	public function exec() {
		$data_to_export = $this->export_groupments();
		return $this->generate_zip( $data_to_export );
	}

	/**
	 * Exportes tout le contenu d'un groupement
	 *
	 * @param integer $parent_id (optional) Le groupement parent.
	 *
	 * @return array
	 */
	public function export_groupments( $parent_id = 0 ) {
		$list_group = Group_Class::g()->get(
			array(
				'posts_per_page' => -1,
				'post_parent' => $parent_id,
				'post_status' => array( 'publish', 'draft' ),
				'order' => 'ASC',
		) );

		$list_data_exported = array();

		if ( ! empty( $list_group ) ) {
			foreach ( $list_group as $element ) {
				$element = get_full_group( $element );

				uasort( $element->list_workunit, function( $a, $b ) {
					return ( $a->id < $b->id ) ? -1 : 1;
				});

				$groupment_data_to_export = array(
					'title' 				=> $element->title,
					'slug' 					=> $element->slug,
					'content'				=> $element->content,
					'link'					=> $element->link,
					'parent_id'			=> $element->parent_id,
					'list_workunit' => $this->export_workunits( $element->list_workunit ),
					'list_risk'			=> $this->export_risks( $element->list_risk ),
					'list_group'		=> $this->export_groupments( $element->id ),
				);

				$list_data_exported[] = $groupment_data_to_export;
			}
		}

		return $list_data_exported;
	}

	/**
	 * Exportes les champs nécessaires des unités de travail.
	 *
	 * @param  array $workunits  Le tableau des unités de travail.
	 * @return array
	 */
	public function export_workunits( $workunits ) {
		$workunit_data_to_export = array();

		if ( ! empty( $workunits ) ) {
			foreach ( $workunits as $element ) {
				$tmp_workunit_data = array(
					'title' 				=> $element->title,
					'slug' 					=> $element->slug,
					'content'				=> $element->content,
					'link'					=> $element->link,
					'parent_id'			=> $element->parent_id,
					'list_risk'			=> $this->export_risks( $element->list_risk ),
				);

				$workunit_data_to_export[] = $tmp_workunit_data;
			}
		}

		return $workunit_data_to_export;
	}

	/**
	 * Exportes les champs nécessaires d'un risque.
	 *
	 * @param  array $risks  Le tableau des risques.
	 * @return array
	 */
	public function export_risks( $risks ) {
		$data_risks_to_export = array();

		if ( ! empty( $risks ) ) {
			foreach ( $risks as $element ) {
				$tmp_risk_data = array(
					'title' 						=> $element->title,
					'slug' 							=> $element->slug,
					'content'						=> $element->content,
					'link'							=> $element->link,
					'parent_id'					=> $element->parent_id,
					'danger_category'		=> $this->export_danger_category( $element ), // Element car on a besoin $element->danger_category et $element->danger.
					'evaluation'				=> $this->export_evaluation( $element->evaluation ),
					'evaluation_method'	=> $this->export_evaluation_method( $element->evaluation_method ),
					'comment'						=> $this->export_comments( $element->comment ),
				);

				$data_risks_to_export[] = $tmp_risk_data;
			}
		}

		return $data_risks_to_export;
	}

	/**
	 * Exportes la catégorie de danger et le danger d'un risque.
	 *
	 * @param  Risk_Model $element Le risque.
	 * @return array
	 */
	public function export_danger_category( $element ) {
		$danger_category_data = array(
			'name'			=> $element->danger_category->name,
			'slug'			=> $element->danger_category->slug,
			'parent_id'	=> $element->danger_category->parent_id,
			'danger'		=> array(
				'name'			=> $element->danger->name,
				'slug'			=> $element->danger->slug,
				'status'		=> $element->danger->status,
				'parent_id'	=> $element->danger->parent_id,
			),
		);

		return $danger_category_data;
	}

	/**
	 * Exportes l'évaluation d'un risque.
	 *
	 * @param  Evaluation_Model $evaluation L'évaluation.
	 * @return array
	 */
	public function export_evaluation( $evaluation ) {
		$data = array(
			'date'								=> $evaluation->date,
			'content'							=> $evaluation->content,
			'status'							=> $evaluation->status,
			'risk_level'					=> $evaluation->risk_level,
			'quotation_detail'		=> $evaluation->quotation_detail,
			'scale'								=> $evaluation->scale,
			'post_id'							=> $evaluation->post_id,
		);

		return $data;
	}

	/**
	 * Exportes la méthode d'évaluation d'un risque.
	 *
	 * @param  Evaluation_Method__Model $evaluation_method La méthode d'évaluation.
	 * @return array
	 */
	public function export_evaluation_method( $evaluation_method ) {
		$data = array(
			'name'			=> $evaluation_method->name,
			'slug'			=> $evaluation_method->slug,
			'parent_id'	=> $evaluation_method->parent_id,
		);

		return $data;
	}

	/**
	 * Récupères les données des commentaires pour les exporter.
	 *
	 * @param  array $comments 	Tableau de Risk_Evaluation_Comment_Model.
	 * @return array
	 */
	public function export_comments( $comments ) {
		$comments_to_export = array();

		if ( ! empty( $comments ) ) {
			foreach ( $comments as $element ) {
				if ( ! empty( $element->id ) ) {
					$tmp_comment_to_export = array(
						'date'			=> $element->date,
						'content'		=> $element->content,
						'status'		=> $element->status,
						'post_id'		=> $element->post_id,
						'parent_id'	=> $element->parent_id,
						'author_id'	=> $element->author_id,
					);

					$comments_to_export[] = $tmp_comment_to_export;
				}
			}
		}

		return $comments_to_export;
	}

	/**
	 * Créer le zip avec le fichier .json
	 *
	 * @param array $list_data_exported La liste des données à exporter.
	 * @return array
	 */
	public function generate_zip( $list_data_exported ) {
		$list_group = Group_Class::g()->get(
			array(
				'posts_per_page' => 1,
				'post_parent' => 0,
				'post_status' => array( 'publish', 'draft' ),
				'order' => 'ASC',
		) );

		$element = $list_group[0];

		$current_time = current_time( 'YmdHis' );
		$filename = 'global';
		$export_base = $this->export_directory . $current_time . '_' . $filename . '_export';
		$json_filename = $export_base . '.json';
		file_put_contents( $json_filename, wp_json_encode( $list_data_exported, JSON_PRETTY_PRINT ) );

		/** Ajout du fichier json au fichier zip / Add the json file to zip file */
		$sub_response = document_class::g()->create_zip( $export_base . '.zip', array( array( 'link' => $json_filename, 'filename' => basename( $json_filename ) ) ), $element, null );
		$response = array();

		$response = array_merge( $response, $sub_response );

		/** Suppression du fichier json après l'enregistrement dans le fichier zip / Delete the json file after zip saving */
		@unlink( $json_filename );
		$upload_dir = wp_upload_dir();

		$response['url_to_file'] = $upload_dir['baseurl'] . '/digirisk/export/' . $current_time . '_' . $filename . '_export.zip';
		$response['filename'] = current_time( 'YmdHis' ) . '_' . $filename . '_export.zip';

		return $response;
	}
}
