<?php
/**
 * Les actions relatives aux statistiques.
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
 * Les actions relatives aux statistiques.
 */
class Statistics_Action {

	/**
	 * Le constructeur appelle une action personnalisée:
	 * callback_display_statistics
	 *
	 * @since 7.5.3
	 */
	public function __construct() {
		add_action( 'wp_ajax_load_data_chart', array( $this, 'load_data_chart' ) );
		add_action( 'wp_ajax_export_csv_file', array( $this, 'export_csv_file' ) );
	}



	public function load_data_chart() {
		global $wpdb;

		$society_id = ! empty( $_POST['id'] ) ? (int) $_POST['id'] : 0;

		$society = get_post( $society_id );
		$societies = Statistics_Class::g()->get_recursive_societies( $society_id );

		if ( ! empty( $societies ) ) {
			foreach ( $societies as $parent_id => $sub_societies ) {
				if ( ! empty( $sub_societies ) ) {
					foreach ( $sub_societies as &$society ) {
						$society->risks = get_posts( array(
							'numberposts' => -1,
							'post_parent' => $society->ID,
							'post_status' => array( 'publish', 'inherit' ),
							'post_type'   => 'digi-risk',
						) );

						if ( ! empty( $society->risks ) ) {
							foreach ( $society->risks as &$risk ) {
								$query = "SELECT evalmeta.meta_value 
											FROM {$wpdb->prefix}comments AS eval 
										INNER JOIN {$wpdb->prefix}commentmeta AS evalmeta
										 	ON evalmeta.comment_id=eval.comment_ID 
										WHERE eval.comment_post_ID=%d 
											AND eval.comment_type='digi-risk-eval'
											AND evalmeta.meta_key='_wpdigi_risk_evaluation_scale'";
								$risk->scale = $wpdb->get_var( $wpdb->prepare( $query, $risk->ID ) );
								$risk->parent_name = $society->post_title;
							}
						}
					}
				}
			}
		}

		$label = array(
			'Risque inacceptable par établissement',
			'Risque à traiter par établissement',
			'Risque à planifier par établissement',
			'Risque sans risque par établissement',
			'Nombre de Risques par UT par GP',
			'Type de Risques par UT par GP',
		);

		//Construct de data en fonction des données attendues

		for ( $i = 0 ; $i < count( $label ) ; $i++ ) {

			$data_value       = array();
			$data_all         = array();
			$labels           = array();
			$risk_level       = array();
			$background_color = array();
			$border_color     = array();

			if ( ! empty( $societies ) ) {
				foreach ( $societies as $parent_id => $sub_societies ) {
					if ( ! empty( $sub_societies ) ) {
						foreach ( $sub_societies as &$society ) {
							if ( ! isset( $data_all[ $society->post_name ] ) ) {
								$data_all[ $society->post_name ] = array();
							}
							$labels[] = $society->post_title;
							if ( ! empty( $society->risks ) ) {
								foreach ( $society->risks as &$risk ) {
									$risk_level[ $society->post_name ][ $risk->scale ][]   = $risk;
									$data_all[ $society->post_name ][ $risk->scale ]       = count( $risk_level[ $society->post_name ][ $risk->scale ] );
									$data_type[ $society->post_name ][ $risk->post_title ] = count( $risk );
								}
							}
							switch ( $i ) {
								case 0:
									$background_color = array( 0, 0, 0, 0.5 );
									$border_color     = array( 0, 0, 0, 1 );
									$data_value[]     = isset( $data_all[ $society->post_name ]['4'] ) ? $data_all[ $society->post_name ]['4'] : 0;
									break;
								case 1:
									$background_color = array( 255, 0, 0, 0.5 );
									$border_color     = array( 255, 0, 0, 1 );
									$data_value[]     = isset( $data_all[ $society->post_name ]['3'] ) ? $data_all[ $society->post_name ]['3'] : 0;
									break;
								case 2:
									$background_color = array( 255, 165, 0, 0.5 );
									$border_color     = array( 255, 165, 0, 1 );
									$data_value[]     = isset( $data_all[ $society->post_name ]['2'] ) ? $data_all[ $society->post_name ]['2'] : 0;
									break;
								case 3:
									$background_color = array( 211, 211, 211, 0.5 );
									$border_color     = array( 211, 211, 211, 1 );
									$data_value[]     = isset( $data_all[ $society->post_name ]['1'] ) ? $data_all[ $society->post_name ]['1'] : 0;
									break;
								case 4:
									$background_color = array( 30, 144, 255, 0.5 );
									$border_color     = array( 30, 144, 255, 1 );
									$data_value[]     = array_sum( $data_all[ $society->post_name ] );
									break;
								case 5:
									//$label[] = $risk->post_title;
									$background_color = array( 100, 100, 100, 0.5 );
									$border_color     = array( 100, 100, 100, 0.5 );
									$data_value[]     = isset( $data_type[ $society->post_title ] ) ? $data_type[ $society->post_title ] : 0;
									break;
							}
						}
					}
				}
			}

			$datasets = array(
				'label'           => $label[ $i ],
				'data'            => $data_value,
				'backgroundColor' => $background_color,
				'borderColor'     => $border_color,
			);

			$data_chart = array(
				'labels'   => $labels,
				'datasets' => $datasets,
			);

			$chart[] = array(
				'type' => 'bar',
				'data' => $data_chart,
				'options',
			);
		}

		wp_send_json_success( array(
			'chart' => $chart,
		) );
	}

	public function export_csv_file() {
		check_ajax_referer( 'export_csv_file' );

		$society_id = ! empty( $_POST['id'] ) ? (int) $_POST['id'] : 0;
		$args       = Statistics_Class::g()->generate_csv_file( $society_id );

		wp_send_json_success(
			array(
				'namespace'        => 'digirisk',
				'module'           => 'statistics',
				'callback_success' => 'exportedCSVFileSuccess',
				'filename'         => $args['filename'],
				'link'             => $args['url_to_file'],
			)
		);
	}
}

new Statistics_Action();

