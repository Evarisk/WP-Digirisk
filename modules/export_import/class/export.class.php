<?php
/**
 * Gestion de l'export d'un groupement ainsi que ses enfants:
 * Groupement
 * Unite de travail
 * Risque
 *
 * @author Evarisk <dev@evarisk.com>
 * @since 6.1.5
 * @version 6.5.0
 * @copyright 2015-2018 Evarisk
 * @package DigiRisk
 */

namespace digi;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Gestion de l'export d'un groupement ainsi que ses enfants:
 * Groupement
 * Unite de travail
 * Risque
 */
class Export_Class extends \eoxia\Singleton_Util {
	/**
	 * Le chemin vers le répertoire uploads/Digirisk/export
	 *
	 * @var string
	 */
	private $export_directory;

	/**
	 * Constructeur obligatoire pour Singleton_Util
	 *
	 * @since 6.1.5
	 * @version 6.4.1
	 *
	 * @return void
	 */
	protected function construct() {
		// Définition des chemins vers les exports.
		$wp_upload_dir          = wp_upload_dir();
		$this->export_directory = $wp_upload_dir['basedir'] . '/digirisk/export/';

		wp_mkdir_p( $this->export_directory );
	}

	/**
	 * Appelles différentes méthodes pour récupérer toutes les données pour exporter le DigiRisk
	 *
	 * @since 6.1.5
	 * @version 6.4.1
	 *
	 * @return array
	 */
	public function exec() {
		$data_to_export = $this->export_groupments();
		return $this->generate_zip( $data_to_export );
	}

	/**
	 * Appelles différentes méthodes pour récupérer toutes les données pour exporter le DigiRisk
	 *
	 * @since 6.1.5
	 * @version 6.4.1
	 *
	 * @return array
	 */
	public function exec_tree() {
		$data_to_export = $this->export_groupments(0,false);
		return $this->generate_zip( $data_to_export, 'arborescence');
	}

	/**
	 * Appelles différentes méthodes pour récupérer toutes les données pour exporter le DigiRisk
	 *
	 * @since 6.1.5
	 * @version 6.4.1
	 *
	 * @return array
	 */
	public function exec_risks() {
		$data_to_export = $this->export_all_risks();
		return $this->generate_zip( $data_to_export, 'risques');
	}

	/**
	 * Exportes tout le contenu d'un groupement
	 *
	 * @since 6.1.5
	 * @version 6.5.0
	 *
	 * @param integer $parent_id (optional) Le groupement parent.
	 *
	 * @return array
	 */
	public function export_all_risks( $parent_id = 0) {
		$society = Society_Class::get_current_society();

		$risks = get_posts(
			array(
				'numberposts' => -1,
				'post_parent' => $society['id'],
				'post_status' => array( 'publish', 'inherit' ),
				'post_type'   => 'digi-risk',
			)
		);

		$list_data_exported = array();

		if ( ! empty( $risks ) ) {
			foreach ( $risks as $element ) {
				// Récupères les risques du groupement.
				$element->list_risk = Risk_Class::g()->get( array( 'id' => $element->ID ) );
				$list_data_exported[] = array_shift($this->export_risks( $element->list_risk ));
			}
		}

		return $list_data_exported;
	}

	/**
	 * Exportes tout le contenu d'un groupement
	 *
	 * @since 6.1.5
	 * @version 6.5.0
	 *
	 * @param integer $parent_id (optional) Le groupement parent.
	 *
	 * @return array
	 */
	public function export_groupments( $parent_id = 0 , $risk = true) {
		$list_group = Society_Class::g()->get( array(
			'posts_per_page' => -1,
			'post_type'      => array( 'digi-society', 'digi-group' ),
			'post_parent'    => $parent_id,
			'post_status'    => array( 'publish', 'inherit', 'draft' ),
			'order'          => 'ASC',
		) );

		$list_data_exported = array();

		if ( ! empty( $list_group ) ) {
			foreach ( $list_group as $element ) {
				$element = $this->get_full_group( $element );

				uasort( $element->list_workunit, function( $a, $b ) {
					return ( $a->data['id'] < $b->data['id'] ) ? -1 : 1;
				});

				$groupment_data_to_export = array(
					'title'         => $element->data['title'],
					'slug'          => $element->data['slug'],
					'type'          => $element->data['type'],
					'status'        => $element->data['status'],
					'content'       => $element->data['content'],
					'link'          => $element->data['link'],
					'id'            => $element->data['id'],
					'parent_id'     => $element->data['parent_id'],
					'list_workunit' => $this->export_workunits( $element->list_workunit, $risk),
					'list_risk'     => ($risk) ? $this->export_risks( $element->list_risk ) : '',
					'list_group'    => $this->export_groupments( $element->data['id'], $risk),
				);

				$list_data_exported[] = $groupment_data_to_export;
			}
		}

		return $list_data_exported;
	}

	/**
	* Récupères tous les éléments nécessaires pour le fonctionnement d'un groupement
	* Groupements enfant, Unités de travail enfant.
	*
	* @param  Group_Model $data L'objet.
	* @return Group_Model L'objet avec tous les éléments ajoutés par cette méthode.
	*/
	function get_full_group( $element ) {
		// Récupères les risques du groupement.
		$element->list_risk = Risk_Class::g()->get( array( 'post_parent' => $element->data['id'] ) );

		$element->list_workunit = Workunit_Class::g()->get( array( 'post_parent' => $element->data['id'], 'posts_per_page' => -1 ) );

		if ( ! empty( $element->list_workunit ) ) {
			foreach ( $element->list_workunit as $workunit ) {
				$workunit->list_risk = Risk_Class::g()->get( array( 'post_parent' => $workunit->data['id'] ) );
			}
		}

		$element->list_group = Group_Class::g()->get(
			array(
				'posts_per_page' 	=> -1,
				'post_parent'			=> $element->data['id'],
				'post_status' 		=> array( 'publish', 'draft' ),
				'orderby'					=> array( 'menu_order' => 'ASC', 'date' => 'ASC' ),
			)
		);

		if ( ! empty( $element->list_group ) ) {
			foreach ( $element->list_group as $group ) {
				$group = get_full_group( $group );
			}
		}

		return $element;
	}

	/**
	 * Exportes les champs nécessaires des unités de travail.
	 *
	 * @since 6.1.5
	 * @version 6.5.0
	 *
	 * @param  array $workunits  Le tableau des unités de travail.
	 * @return array
	 */
	public function export_workunits( $workunits, $risk = true ) {
		$workunit_data_to_export = array();

		if ( ! empty( $workunits ) ) {
			foreach ( $workunits as $element ) {
				$tmp_workunit_data = array(
					'title'     => $element->data['title'],
					'slug'      => $element->data['slug'],
					'type'      => $element->data['type'],
					'status'    => $element->data['status'],
					'content'   => $element->data['content'],
					'link'      => $element->data['link'],
					'id'        => $element->data['id'],
					'parent_id' => $element->data['parent_id'],
					'list_risk' => ($risk) ? $this->export_risks( $element->list_risk ) : '',
				);

				$workunit_data_to_export[] = $tmp_workunit_data;
			}
		}

		return $workunit_data_to_export;
	}

	/**
	 * Exportes les champs nécessaires d'un risque.
	 *
	 * @since 6.1.5
	 * @version 6.5.0
	 *
	 * @param  array $risks  Le tableau des risques.
	 * @return array
	 */
	public function export_risks( $risks ) {
		$data_risks_to_export = array();

		if ( ! empty( $risks ) ) {
			foreach ( $risks as $element ) {
				$tmp_risk_data = array(
					'title'               => $element->data['title'],
					'slug'                => $element->data['slug'],
					'status'              => $element->data['status'],
					'content'             => $element->data['content'],
					'link'                => $element->data['link'],
					'id'                  => $element->data['id'],
					'parent_id'           => $element->data['parent_id'],
					'current_equivalence' => $element->data['current_equivalence'],
					'danger_category'     => $this->export_danger_category( $element ), // Element car on a besoin $element->danger_category et $element->danger.
					'evaluation'          => $this->export_evaluation( $element->data['evaluation'] ),
					'evaluation_method'   => $this->export_evaluation_method( $element->data['evaluation_method'] ),
					'comment'             => $this->export_comments( $element->data['comment'] ),
				);

				$data_risks_to_export[] = $tmp_risk_data;
			}
		}

		return $data_risks_to_export;
	}

	/**
	 * Exportes la catégorie de danger et le danger d'un risque.
	 *
	 * @since 6.1.5
	 * @version 6.4.1
	 *
	 * @param  Risk_Model $element Le risque.
	 * @return array
	 */
	public function export_danger_category( $element ) {
		$danger_category_data = array(
			'name'      => $element->data['risk_category']->data['name'],
			'slug'      => $element->data['risk_category']->data['slug'],
			'parent_id' => $element->data['risk_category']->data['parent_id'],
		);

		return $danger_category_data;
	}

	/**
	 * Exportes l'évaluation d'un risque.
	 *
	 * @since 6.1.5
	 * @version 6.3.0
	 *
	 * @param  Evaluation_Model $evaluation L'évaluation.
	 * @return array
	 */
	public function export_evaluation( $evaluation ) {
		$data = array(
			'date'             => $evaluation->data['date'],
			'content'          => $evaluation->data['content'],
			'status'           => $evaluation->data['status'],
			'scale'            => $evaluation->data['scale'],
			'cotation'         => $evaluation->data['cotation'],
			'equivalence'      => $evaluation->data['equivalence'],
			'variables'        => $evaluation->data['variables'],
			'post_id'          => $evaluation->data['post_id'],
		);

		return $data;
	}

	/**
	 * Exportes la méthode d'évaluation d'un risque.
	 *
	 * @since 6.1.5
	 * @version 6.3.0
	 *
	 * @param  Evaluation_Method__Model $evaluation_method La méthode d'évaluation.
	 * @return array
	 */
	public function export_evaluation_method( $evaluation_method ) {
		$data = array(
			'name'      => $evaluation_method->data['name'],
			'slug'      => $evaluation_method->data['slug'],
			'parent_id' => $evaluation_method->data['parent_id'],
		);

		return $data;
	}

	/**
	 * Récupères les données des commentaires pour les exporter.
	 *
	 * @since 6.1.5
	 * @version 6.3.0
	 *
	 * @param  array $comments 	Tableau de Risk_Evaluation_Comment_Model.
	 * @return array
	 */
	public function export_comments( $comments ) {
		$comments_to_export = array();

		if ( ! empty( $comments ) ) {
			foreach ( $comments as $element ) {
				if ( ! empty( $element->data['id'] ) ) {
					$tmp_comment_to_export = array(
						'date'      => $element->data['date'],
						'content'   => $element->data['content'],
						'status'    => $element->data['status'],
						'post_id'   => $element->data['post_id'],
						'parent_id' => $element->data['parent_id'],
						'author_id' => $element->data['author_id'],
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
	 * @since 6.1.5
	 *
	 * @param array $list_data_exported La liste des données à exporter.
	 * @return array
	 */
	public function generate_zip( $list_data_exported, $filename = 'global') {
		$element = Society_Class::g()->get( array(
			'posts_per_page' => 1,
			'post_parent'    => 0,
			'post_status'    => array( 'publish', 'draft' ),
			'order'          => 'ASC',
		), true );

		$current_time  = current_time( 'YmdHis' );
		$export_base   = $this->export_directory . $current_time . '_' . $filename . '_export';
		$json_filename = $export_base . '.json';

		file_put_contents( $json_filename, wp_json_encode( $list_data_exported, JSON_PRETTY_PRINT ) );

		$zip = new \ZipArchive();

		if ( $zip->open( $export_base . '.zip', \ZipArchive::CREATE ) !== true ) {
			$response['status']  = false;
			$response['message'] = __( 'An error occured while opening zip file to write', 'digirisk' );
			return $response;
		}

		$zip->addFile( $json_filename, basename( $json_filename ) );
		$zip->close();

		$response = array();

		/** Suppression du fichier json après l'enregistrement dans le fichier zip / Delete the json file after zip saving */
		@unlink( $json_filename );
		$upload_dir = wp_upload_dir();

		$response['url_to_file'] = $upload_dir['baseurl'] . '/digirisk/export/' . $current_time . '_' . $filename . '_export.zip';
		$response['filename']    = current_time( 'YmdHis' ) . '_' . $filename . '_export.zip';

		return $response;
	}
}
