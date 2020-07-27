<?php
/**
 * Classe gérant les statistiques
 *
 * @author Evarisk <dev@evarisk.com>
 * @since 7.5.3
 * @version 7.5.3
 * @copyright 2015-2020 Evarisk
 * @package DigiRisk
 */

namespace digi;

use eoxia\Singleton_Util;
use eoxia\View_Util;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Classe gérant les statistiques
 */
class Statistics_Class extends Singleton_Util {
	/**
	 * Le chemin vers le répertoire uploads/Digirisk/statistics
	 *
	 * @var string
	 */
	private $statistics_directory;

	/**
	 * Le constructeur
	 */
	protected function construct() {
		$wp_upload_dir              = wp_upload_dir();
		$this->statistics_directory = $wp_upload_dir['basedir'] . '/digirisk/statistics/';

		wp_mkdir_p( $this->statistics_directory );
	}

	/**
	 * Charges la liste des risques même ceux des enfants. Et appelle le template pour les afficher.
	 * Récupères le schéma d'un risque pour l'entrée d'ajout de risque dans le tableau.
	 *
	 * @param  integer $society_id L'ID de la société.
	 *
	 * @since 6.0.0
	 */
	public function display( $society_id ) {

		$element          = get_post( $society_id );
		$nb_chart_display = 0;

		switch ( $element->post_type ) {
			case 'digi-society':
				$nb_chart_display = 6;
				break;
			case 'digi-group':
				$nb_chart_display = 1;
				break;
			case 'digi-workunit':
				$nb_chart_display = 1;
				break;
		}

		View_Util::exec(
			'digirisk',
			'statistics',
			'main',
			array(
				'id'               => $society_id,
				'nb_chart_display' => $nb_chart_display,
			)
		);
	}

	/**
	 * Ceci n'est pas society_in de Society_Class
	 *
	 * @param   int    $parent_id
	 * @param   array  $societies
	 */
	public function get_recursive_societies( $parent_id = 0, $societies = array() ) {
		$current_societies = get_posts( array(
			'post_type'   => array( 'digi-society', 'digi-group', 'digi-workunit' ),
			'post_parent' => $parent_id,
			'numberposts' => -1,
			'post_status' => array( 'publish', 'inherit' ),
		) );

		$societies[ $parent_id ] = $current_societies;

		if ( ! empty( $current_societies ) ) {
			foreach ( $current_societies as $society ) {
				$societies = $this->get_recursive_societies( $society->ID, $societies );
			}
		}

		return $societies;
	}

	/**
	 * Exports an associative array into a CSV file using PHP.
	 *
	 * @param array  $data       The table you want to export in CSV.
	 * @param string $filename   The name of the file you want to export.
	 * @param string $delimiter  The CSV delimiter you wish to use. The default ";" is used for a compatibility with microsoft excel.
	 * @param string $enclosure  The type of enclosure used in the CSV file, by default it will be a quote ".
	 */
	function write_data_to_csv( $data_header, $data, $filepath, $filename='export', $delimiter = ';', $enclosure = '"' ) {

		// I open PHP memory as a file.
		$csv_file = fopen( $filepath, 'w' );

		// Insert the UTF-8 BOM in the file.
		fputs( $csv_file, $bom = ( chr( 0xEF ) . chr( 0xBB ) . chr( 0xBF ) ) );

		// I add the array keys as CSV headers.
		fputcsv( $csv_file, $data_header, $delimiter, $enclosure );

		// Add all the data in the file.
		foreach ( $data as $fields ) {
			fputcsv( $csv_file, $fields, $delimiter, $enclosure );
		}

		// Close the CSV file.
		fclose( $csv_file );

	}

	public function get_recursive_risks (  $society_id ) {
		global $wpdb;
		$societies = $this->get_recursive_societies( $society_id );
		$societies_array_filter = array();
		if ( ! empty( $societies ) ) {
			foreach ( $societies as $parent_id => $sub_societies ) {
				if ( ! empty( $sub_societies ) ) {
					foreach ( $sub_societies as &$society ) {
						$society = array(
							'ID'          => $society->ID,
							'post_title'  => $society->post_title,
							'post_name'   => $society->post_name,
							'post_parent' => $society->post_parent,
							'post_status' => $society->post_status,
							'post-type'   => $society->post_type,
							'risks'       => array(),
						);

						$society['risks'] = get_posts(
							array(
								'numberposts' => -1,
								'post_parent' => $society['ID'],
								'post_status' => array( 'publish', 'inherit' ),
								'post_type'   => 'digi-risk',
							)
						);
						if ( ! empty( $society['risks'] ) ) {
							foreach ( $society['risks'] as &$risk ) {
								$query = "SELECT evalmeta.meta_value 
											FROM {$wpdb->prefix}comments AS eval
										INNER JOIN {$wpdb->prefix}commentmeta AS evalmeta
										 	ON evalmeta.comment_id=eval.comment_ID
										WHERE eval.comment_post_ID=%d
											AND eval.comment_type='digi-risk-eval'
											AND evalmeta.meta_key='_wpdigi_risk_evaluation_scale'";
								$queryCount = "SELECT COUNT( * )
											FROM {$wpdb->prefix}comments AS eval
										INNER JOIN {$wpdb->prefix}commentmeta AS evalmeta
										 	ON evalmeta.comment_id=eval.comment_ID
										WHERE eval.comment_post_ID=%d
											AND eval.comment_type='digi-risk-eval'
											AND evalmeta.meta_key='_wpdigi_risk_evaluation_scale'";

								$risk = array(
									'ID'          => $risk->ID,
									'post_title'  => $risk->post_title,
									'post_name'   => $risk->post_name,
									'post_parent' => $risk->post_parent,
									'post_status' => $risk->post_status,
									'post-type'   => $risk->post_type,
									'scale'       => '',
									'parent_name' => $society['post_title'],
								);
								$count = $wpdb->get_var( $wpdb->prepare( $queryCount, $risk['ID'] ) );

								$risk['scale'] = $wpdb->get_var( $wpdb->prepare( $query, $risk['ID'] ), 0,  $count - 1 );
							}
							$societies_array_filter[$society['post_parent']][] = $society;
						}
					}
				}
			}
			return $societies_array_filter;
		}
	}

	public function  generate_csv_file( $society_id ) {

		$element_id = ! empty( $_POST['id'] ) ? (int) $_POST['id'] : 0;
		$element = get_post( $element_id );

		$upload_dir   = wp_upload_dir();
		$current_time = current_time( 'YmdHis' );
		$filepath     = $this->statistics_directory . $current_time . '_statistics.csv';
		$filename     = $current_time . '_statistics.csv';
		$url_to_file  = $upload_dir['baseurl'] . '/digirisk/statistics/' . $current_time . '_statistics.csv';

		$societies = $this->get_recursive_risks( $society_id );
		$data_header = array (
			 'Name',
			'Grey Risk',
			'Orange Risk',
			'Red Risk',
			'Black Risk',
		);

		$data_csv = array();
		$risk_level       = array();

		if ( ! empty( $societies ) ) {
			foreach ( $societies as $parent_id => $sub_societies ) {
				if ( ! empty( $sub_societies ) ) {
					foreach ( $sub_societies as &$society ) {
						if ( ! empty( $society['risks']) ) {
							foreach ( $society['risks'] as &$risk ) {
								$risk_level[ $society['post_name'] ][ $risk['scale'] ][]   = $risk;
								$data_all[ $society['post_name'] ][ $risk['scale'] ]       = count( $risk_level[ $society['post_name'] ][ $risk['scale'] ] );
							}
						}
						$data['Name']        = $society['post_title'];
						$data['Grey Risk']   = isset( $data_all[ $society['post_name'] ]['1'] ) ? $data_all[ $society['post_name'] ]['1'] : 0;
						$data['Orange Risk'] = isset( $data_all[ $society['post_name'] ]['2'] ) ? $data_all[ $society['post_name'] ]['2'] : 0;
						$data['Red Risk']    = isset( $data_all[ $society['post_name'] ]['3'] ) ? $data_all[ $society['post_name'] ]['3'] : 0;
						$data['Black Risk']  = isset( $data_all[ $society['post_name'] ]['4'] ) ? $data_all[ $society['post_name'] ]['4'] : 0;

						$data_csv[] = $data;
					}

				}
			}
		}
		else {
			$societies = $this->get_recursive_risks( $element->post_parent );

			foreach ( $societies as $post_id => $sub_societies ) {
				if ( ! empty( $sub_societies ) ) {
					foreach ( $sub_societies as &$society ) {
						if ($society['ID'] == $element_id) {
							if ( ! empty( $society['risks']) ) {
								foreach ( $society['risks'] as &$risk ) {
									$risk_level[ $society['post_name'] ][ $risk['scale'] ][]   = $society['risks'];
									$data_all[ $society['post_name'] ][ $risk['scale'] ]       = count( $risk_level[ $society['post_name'] ][ $risk['scale'] ] );
								}
							}

						$data['Name']        = $society['post_title'];
						$data['Grey Risk']   = isset( $data_all[ $society['post_name'] ]['1'] ) ? $data_all[ $society['post_name'] ]['1'] : 0;
						$data['Orange Risk'] = isset( $data_all[ $society['post_name'] ]['2'] ) ? $data_all[ $society['post_name'] ]['2'] : 0;
						$data['Red Risk']    = isset( $data_all[ $society['post_name'] ]['3'] ) ? $data_all[ $society['post_name'] ]['3'] : 0;
						$data['Black Risk']  = isset( $data_all[ $society['post_name'] ]['4'] ) ? $data_all[ $society['post_name'] ]['4'] : 0;

						$data_csv[] = $data;
						}
					}
				}
			}
		}
		$id_main_society = get_posts(array(
			'post_type'  => 'digi-society',
		));

		if ($element->post_parent == $id_main_society[0]->ID) { //$element->post_parent == 80 à remplacer par le post_parent générique

			$societies = Statistics_Class::g()->get_recursive_risks( $element->post_parent );
			$unique_identifier = implode( ',', get_post_meta( $element_id, '_wpdigi_unique_identifier' ) );

			if ( ! empty( $societies ) ) {
				foreach ( $societies as $parent_id => $sub_societies ) {
					if ( ! empty( $sub_societies ) ) {
						foreach ( $sub_societies as &$society ) {
							if ( ! isset( $data_all[ $society['post_name'] ] ) ) {
								$data_all[ $society['post_name'] ] = array();
							}
							if ( ! empty( $society['risks'] ) ) {
								foreach ( $society['risks'] as &$risk ) {

									$risk_data[ $society['post_name'] ][ $risk['scale'] ][]    						= $risk;
									$risk_data[ $society['post_name'] ][ $risk['post_title'] ][ $risk['scale'] ][] 	= $risk;
									$data_all[ $society['post_name'] ][ $risk['scale'] ]       						= count( $risk_data[ $society['post_name'] ][ $risk['scale'] ] );
									$data_type[ $society['post_name'] ][ $risk['scale'] ][ $risk['post_title'] ] 	= count( $risk_data[ $society['post_name'] ][ $risk['post_title'] ][ $risk['scale'] ] );

									$labels_type[] = $risk['post_title'];
									$labels_type   = array_values( array_unique( $labels_type ) );
								}
							}
						}
					}
				}
			}

			$labels           			= array( 'Risque inacceptable', 'Risque à traiter', 'Risque à planifier', 'Risque sans risque' );
			$label           			= $element->post_title;
			$text             			= 'Ensemble des Risques sur ' . $unique_identifier . ' ' . $element->post_title;
			$background_color 			= array( 30, 144, 255, 0.5 );
			$border_color     			= array( 30, 144, 255, 1 );

			$data_value['Name']   		= $element->post_title;
			$data_value['Grey Risk']    = isset( $data_all[ $element->post_name ]['1'] ) ? $data_all[ $element->post_name ]['1'] : 0;
			$data_value['Orange Risk']  = isset( $data_all[ $element->post_name ]['2'] ) ? $data_all[ $element->post_name ]['2'] : 0;
			$data_value['Red Risk']     = isset( $data_all[ $element->post_name ]['3'] ) ? $data_all[ $element->post_name ]['3'] : 0;
			$data_value['Black Risk']   = isset( $data_all[ $element->post_name ]['4'] ) ? $data_all[ $element->post_name ]['4'] : 0;

			array_push($data_csv, $data_value);
		}

		$this->write_data_to_csv( $data_header, $data_csv, $filepath, $filename, $delimiter = ';', $enclosure = '"' );

		$args = array(
			'filepath'    => $filepath,
			'filename'    => $filename,
			'url_to_file' => $url_to_file,
		);

		return $args;
}

	public function load_data_chart_society () {

	}

	public function load_data_chart_group () {

	}

	public function load_data_chart_work_unit () {

	}
}
Statistics_Class::g();

