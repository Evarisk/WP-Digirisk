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

		$element_id = ! empty( $_POST['id'] ) ? (int) $_POST['id'] : 0;

		$element = get_post( $element_id );

		switch ( $element->post_type ) {
			case 'digi-society':
				$societies = Statistics_Class::g()->get_recursive_risks( $element->ID );

				$info_society = Society_Class::g()->get( array( 'post_id' => $element_id ), true );

				$nb_chart = 6;

				// Construction des data pour chaque graphique en fonction des données attendues.
				for ( $i = 0; $i < $nb_chart; $i++ ) {

					// Data text.
					$label = '';
					$text  = '';

					// Data array commun.
					$data_value       = array();
					$labels           = array();
					$background_color = array();
					$border_color     = array();

					// Data array spécifique.
					$risk_data  = array();
					$data_all   = array();
					$data_type  = array();

					if ( ! empty( $societies ) ) {
						foreach ( $societies as $parent_id => $sub_societies ) {
							if ( ! empty( $sub_societies ) ) {
								foreach ( $sub_societies as &$society ) {
									if ( ! isset( $data_all[ $society['post_name'] ] ) ) {
										$data_all[ $society['post_name'] ] = array();
									}
									$labels[] = $society['post_title'];
									if ( ! empty( $society['risks'] ) ) {
										foreach ( $society['risks'] as &$risk ) {
											$risk_data[ $society['post_name'] ][ $risk['scale'] ][]                        = $risk;
											$risk_data[ $society['post_name'] ][ $risk['post_title'] ][ $risk['scale'] ][] = $risk;

											$data_all[ $society['post_name'] ][ $risk['scale'] ]                         = count( $risk_data[ $society['post_name'] ][ $risk['scale'] ] );
											$data_type[ $society['post_name'] ][ $risk['scale'] ][ $risk['post_title'] ] = count( $risk_data[ $society['post_name'] ][ $risk['post_title'] ][ $risk['scale'] ] );

											$labels_type[] = $risk['post_title'];
											$labels_type   = array_values( array_unique( $labels_type ) );
										}
									}
									switch ( $i ) {
										case 0:
											$label            = 'Risque inacceptable';
											$text             = 'Risque inacceptable sur la societé ' . strtoupper( $info_society->data['title'] );
											$background_color = array( 0, 0, 0, 0.5 );
											$border_color     = array( 0, 0, 0, 1 );
											$data_value[]     = isset( $data_all[ $society['post_name'] ]['4'] ) ? $data_all[ $society['post_name'] ]['4'] : 0;
											break;
										case 1:
											$label            = 'Risque à traiter';
											$text             = 'Risque à traiter sur la societé ' . strtoupper( $info_society->data['title'] );
											$background_color = array( 255, 0, 0, 0.5 );
											$border_color     = array( 255, 0, 0, 1 );
											$data_value[]     = isset( $data_all[ $society['post_name'] ]['3'] ) ? $data_all[ $society['post_name'] ]['3'] : 0;
											break;
										case 2:
											$label            = 'Risque à planifier';
											$text             = 'Risque à planifier sur la societé ' . strtoupper( $info_society->data['title'] );
											$background_color = array( 255, 165, 0, 0.5 );
											$border_color     = array( 255, 165, 0, 1 );
											$data_value[]     = isset( $data_all[ $society['post_name'] ]['2'] ) ? $data_all[ $society['post_name'] ]['2'] : 0;
											break;
										case 3:
											$label            = 'Risque sans risque';
											$text             = 'Risque sans risque sur la societé ' . strtoupper( $info_society->data['title'] );
											$background_color = array( 211, 211, 211, 0.5 );
											$border_color     = array( 211, 211, 211, 1 );
											$data_value[]     = isset( $data_all[ $society['post_name'] ]['1'] ) ? $data_all[ $society['post_name'] ]['1'] : 0;
											break;
										case 4:
											$label            = 'Nombre de risques';
											$text             = 'Nombre de risques sur la societé ' . strtoupper( $info_society->data['title'] );
											$background_color = array( 30, 144, 255, 0.5 );
											$border_color     = array( 30, 144, 255, 1 );
											$data_value[]     = array_sum( $data_all[ $society['post_name'] ] );
											break;
										case 5:
											$text = 'Ensemble des risques sur la societé ' . strtoupper( $info_society->data['title'] );
											break;
										case 6:
//											$label            = 'Risque inacceptable';
//											$text             = 'Famille des Risques inacceptable sur la societé ' . strtoupper( $info_society->data['title'] );
//											$background_color = array( 0, 0, 0, 0.5 );
//											$border_color     = array( 0, 0, 0, 1 );
//											$data_temp = array_values( $data_type[ $society['post_name'] ]['4'] );
//											$data_value[]     = isset( $data_temp )  ? $data_temp : 0;
										case 7:
										case 8:
										case 9:
										case 10:
//											$label            = 'Nombre des Familles des Risques';
//											$text             = 'Nombre de Risques en fonction des Familles des Risques sur la societé ' . strtoupper( $info_society->data['title'] );
//											$background_color = array( 30, 144, 255, 0.5 );
//											$border_color     = array( 30, 144, 255, 1 );
//											$data_value[]     = array_sum( $data_type[ $society['post_name'] ] );
//											break;
										case 11:
									}
								}
							}
						}
					}

					$datasets = array(
						'label'           => $label,
						'data'            => $data_value,
						'backgroundColor' => $background_color,
						'borderColor'     => $border_color,
					);

					$data_chart = array(
						'labels'   => $labels,
						'datasets' => $datasets,
					);

					$title = array(
						'display'  => true,
						'text'     => $text,
						'fontSize' => 20,
					);

					$options = array(
						'barValueSpacing' => isset( $bar_value_spacing ) ? $bar_value_spacing : 0,
						'title'           => $title,
					);

					$chart[] = array(
						'type'    => 'horizontalBar',
						'data'    => $data_chart,
						'options' => $options,
					);
				}

				$datasets_all[] = $chart[0]['data']['datasets'];
				$datasets_all[] = $chart[1]['data']['datasets'];
				$datasets_all[] = $chart[2]['data']['datasets'];
				$datasets_all[] = $chart[3]['data']['datasets'];

				$chart[5]['data']['datasets']           = $datasets_all;
				$chart[5]['options']['barValueSpacing'] = 20;

				wp_send_json_success(
					array(
						'chart'   => $chart,
						'nbChart' => $nb_chart,
					)
				);
				break;
			case 'digi-group':
				$societies = Statistics_Class::g()->get_recursive_risks( $element->post_parent );

				$unique_identifier = implode( ',', get_post_meta( $element_id, '_wpdigi_unique_identifier' ) );

				$nb_chart = 1;

				// Construction des data pour chaque graphique en fonction des données attendues.
				for ( $i = 0; $i < $nb_chart; $i++ ) {

					// Data text.
					$label = '';
					$text  = '';

					// Data array commun.
					$data_value       = array();
					$labels           = array();
					$background_color = array();
					$border_color     = array();

					// Data array spécifique.
					$risk_data  = array();
					$data_all   = array();
					$data_type  = array();

					if ( ! empty( $societies ) ) {
						foreach ( $societies as $parent_id => $sub_societies ) {
							if ( ! empty( $sub_societies ) ) {
								foreach ( $sub_societies as &$society ) {
									if ( ! isset( $data_all[ $society['post_name'] ] ) ) {
										$data_all[ $society['post_name'] ] = array();
									}
									if ( ! empty( $society['risks'] ) ) {
										foreach ( $society['risks'] as &$risk ) {
											$risk_data[ $society['post_name'] ][ $risk['scale'] ][]    = $risk;
											$risk_data[ $society['post_name'] ][ $risk['post_title'] ][ $risk['scale'] ][] = $risk;
											$data_all[ $society['post_name'] ][ $risk['scale'] ]       = count( $risk_data[ $society['post_name'] ][ $risk['scale'] ] );
											$data_type[ $society['post_name'] ][ $risk['scale'] ][ $risk['post_title'] ] = count( $risk_data[ $society['post_name'] ][ $risk['post_title'] ][ $risk['scale'] ] );

											$labels_type[] = $risk['post_title'];
											$labels_type   = array_values( array_unique( $labels_type ) );
										}
									}
								}
							}
						}
					}

					switch ( $i ) {
						case 0:
							$labels           = array( 'Risque inacceptable', 'Risque à traiter', 'Risque à planifier', 'Risque sans risque' );
							$label            = $element->post_title;
							$text             = 'Ensemble des Risques sur ' . $unique_identifier . ' ' . $element->post_title;
							$background_color = array( 30, 144, 255, 0.5 );
							$border_color     = array( 30, 144, 255, 1 );
							$data_value[0]    = isset( $data_all[ $element->post_name ]['4'] ) ? $data_all[ $element->post_name ]['4'] : 0;
							$data_value[1]    = isset( $data_all[ $element->post_name ]['3'] ) ? $data_all[ $element->post_name ]['3'] : 0;
							$data_value[2]    = isset( $data_all[ $element->post_name ]['2'] ) ? $data_all[ $element->post_name ]['2'] : 0;
							$data_value[3]    = isset( $data_all[ $element->post_name ]['1'] ) ? $data_all[ $element->post_name ]['1'] : 0;
							
							break;
						case 1:
							$labels           = array( 'RTHPM', 'RCH', 'RCIV', 'RRM', 'RCPT', 'RMN', 'RPED', 'RAB', 'RET', 'RECO', 'RNB', 'RAT', 'RIE', 'RE', 'RAL', 'RR', 'RP', 'RA', 'RA2' );
							$label            = 'Risque inacceptable';
							$text             = 'Famille des Risques inacceptable sur ' . $unique_identifier . ' ' . $element->post_title;
							$background_color = array( 0, 0, 0, 0.5 );
							$border_color     = array( 0, 0, 0, 1 );
							//$data_temp = array_fill_keys( $labels, 'test' );
//							$data_temp = isset( $data_type[ $element->post_name ]['4'][ $risk['post_title'] ] ) ? $data_type[ $element->post_name ]['4'][ $risk['post_title'] ] : 0;
//							for ( $b = 0; $b < count ( $labels ); $b++ ) {
//								$data_value[] = array_shift( $data_temp );
//								//$data_value[] = isset( $data_temp ) ? $data_temp : 0;
//							}
							break;
					}

					$datasets = array(
						'label'           => $label,
						'data'            => $data_value,
						'backgroundColor' => $background_color,
						'borderColor'     => $border_color,
					);

					$data_chart = array(
						'labels'   => $labels,
						'datasets' => $datasets,
					);

					$title = array(
						'display'  => true,
						'text'     => $text,
						'fontSize' => 20,
					);

					$options = array(
						'barValueSpacing' => isset( $bar_value_spacing ) ? $bar_value_spacing : 0,
						'title'           => $title,
					);

					$chart[] = array(
						'type'    => isset( $type ) ? $type : 'horizontalBar',
						'data'    => $data_chart,
						'options' => $options,
					);
				}

				wp_send_json_success(
					array(
						'chart'   => $chart,
						'nbChart' => $nb_chart,
					)
				);
				break;
			case 'digi-workunit':
				$element_workunit = get_post( $element->post_parent );

				$societies = Statistics_Class::g()->get_recursive_risks( $element_workunit->post_parent );

				$unique_identifier = implode( ',', get_post_meta( $element_id, '_wpdigi_unique_identifier' ) );

				$nb_chart = 1;

				// Construction des data pour chaque graphique en fonction des données attendues.
				for ( $i = 0; $i < $nb_chart; $i++ ) {

					// Data text.
					$label = '';
					$text  = '';

					// Data array commun.
					$data_value       = array();
					$data_all         = array();
					$labels           = array();
					$background_color = array();
					$border_color     = array();

					// Data array spécifique.
					$risk_data = array();

					if ( ! empty( $societies ) ) {
						foreach ( $societies as $parent_id => $sub_societies ) {
							if ( ! empty( $sub_societies ) ) {
								foreach ( $sub_societies as &$society ) {
									if ( ! isset( $data_all[ $society['post_name'] ] ) ) {
										$data_all[ $society['post_name'] ] = array();
									}
									if ( ! empty( $society['risks'] ) ) {
										foreach ( $society['risks'] as &$risk ) {
											$risk_data[ $society['post_name'] ][ $risk['scale'] ][]    = $risk;
											$data_all[ $society['post_name'] ][ $risk['scale'] ]       = count( $risk_data[ $society['post_name'] ][ $risk['scale'] ] );
											$data_type[ $society['post_name'] ][ $risk['post_title'] ] = count( $risk );
										}
									}
									switch ( $i ) {
										case 0:
											$labels           = array( 'Risque inacceptable', 'Risque à traiter', 'Risque à planifier', 'Risque sans risque' );
											$label            = $element->post_title;
											$text             = 'Ensemble des risques sur ' . $unique_identifier . ' ' . $element->post_title;
											$background_color = array( 30, 144, 255, 0.5 );
											$border_color     = array( 30, 144, 255, 1 );
											$data_value[0]    = isset( $data_all[ $element->post_name ]['4'] ) ? $data_all[ $element->post_name ]['4'] : 0;
											$data_value[1]    = isset( $data_all[ $element->post_name ]['3'] ) ? $data_all[ $element->post_name ]['3'] : 0;
											$data_value[2]    = isset( $data_all[ $element->post_name ]['2'] ) ? $data_all[ $element->post_name ]['2'] : 0;
											$data_value[3]    = isset( $data_all[ $element->post_name ]['1'] ) ? $data_all[ $element->post_name ]['1'] : 0;
											break;
									}
								}
							}
						}
					}

					$datasets = array(
						'label'           => $label,
						'data'            => $data_value,
						'backgroundColor' => $background_color,
						'borderColor'     => $border_color,
					);

					$data_chart = array(
						'labels'   => $labels,
						'datasets' => $datasets,
					);

					$title = array(
						'display'  => true,
						'text'     => $text,
						'fontSize' => 20,
					);

					$options = array(
						'barValueSpacing' => isset( $bar_value_spacing ) ? $bar_value_spacing : 0,
						'title'           => $title,
					);

					$chart[] = array(
						'type'    => 'horizontalBar',
						'data'    => $data_chart,
						'options' => $options,
					);
				}

				wp_send_json_success(
					array(
						'chart'    => $chart,
						'nbChart' => $nb_chart,
					)
				);
				break;
		}
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

