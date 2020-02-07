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

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Classe gérant les statistiques
 */
class Statistics_Class extends \eoxia\Singleton_Util {
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
		\eoxia\View_Util::exec( 'digirisk', 'statistics', 'main', array( 'id' => $society_id ) );
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
	function write_data_to_csv( $data, $filepath, $filename='export', $delimiter = ';', $enclosure = '"' ) {

		// I open PHP memory as a file.
		$csv_file = fopen( $filepath, 'w' );

		// I add the array keys as CSV headers.
		fputcsv( $csv_file, array_keys( $data[0] ), $delimiter, $enclosure );

		// Add all the data in the file.
		foreach ( $data as $fields ) {
			echo '<pre>';
			print_r( $data );
			echo '</pre>';
			exit;
			fputcsv( $csv_file, $fields, $delimiter, $enclosure );
		}

		// Close the CSV file.
		fclose( $csv_file );

	}

	public function get_recursive_risks (  $society_id ) {
		global $wpdb;

		$societies = $this->get_recursive_societies( $society_id );

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

								$risk = array(
									'ID'          => $risk->ID,
									'post_title'  => $risk->post_title,
									'post_name'   => $risk->post_name,
									'post_parent' => $risk->post_parent,
									'post_status' => $risk->post_status,
									'post-type'   => $risk->post_type,
									'scale' => '',
									'parent_name' => $society['post_title'],
								);
								$risk['scale'] = $wpdb->get_var( $wpdb->prepare( $query, $risk['ID'] ) );
							}
						}
						$societies_array_filter[$society['post_parent']][] = $society;
					}
				}
			}
		}

		return $societies_array_filter;
	}

	public function  generate_csv_file( $society_id ) {

		$upload_dir   = wp_upload_dir();
		$current_time = current_time( 'YmdHis' );
		$filepath     = $this->statistics_directory . $current_time . '_statistics.csv';
		$filename     = $current_time . '_statistics.csv';
		$url_to_file  = $upload_dir['baseurl'] . '/digirisk/statistics/' . $current_time . '_statistics.csv';

		$data = $this->get_recursive_risks( $society_id );
		echo '<pre>';
		print_r( $data );
		echo '</pre>';
		exit;
		$this->write_data_to_csv( $data, $filepath, $filename, $delimiter = ';', $enclosure = '"' );

		$args = array(
			'filepath'    => $filepath,
			'filename'    => $filename,
			'url_to_file' => $url_to_file,
		);

		return $args;
	}
}

Statistics_Class::g();

