<?php
/**
 * Gestion de l'export en CSV des risques
 *
 * @author Evarisk <dev@evarisk.com>
 * @since 6.2.6
 * @copyright 2015-2018 Evarisk
 * @package DigiRisk
 */

namespace digi;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Gestion de l'export en CSV des risques.
 */
class Export_CSV_Class extends \eoxia\Singleton_Util {
	/**
	 * Le chemin vers le répertoire uploads/Digirisk/export
	 *
	 * @var string
	 */
	private $export_directory;

	/**
	 * Le nombre de risque à exporter par requête.
	 *
	 * @var integer
	 */
	private $posts_per_page = 50;

	/**
	 * Constructeur de la classe. Doit être présent même si vide pour coller à la définition "abstract" des parents / Class constructor. Must be present even if empty for matchin with "abstract" definition of ancestors
	 */
	function construct() {
		$wp_upload_dir          = wp_upload_dir();
		$this->export_directory = $wp_upload_dir['basedir'] . '/digirisk/export/';

		wp_mkdir_p( $this->export_directory );
	}

	/**
	 * Appelles différentes méthodes pour récupérer tous les risques pour exporter le DigiRisk
	 *
	 * @param array $args Les paramètres pour récupérer les risques à exporter.
	 *
	 * @return array
	 *
	 * @since 6.2.6
	 */
	public function exec( $args ) {
		if ( empty( $args['filepath'] ) ) {
			$upload_dir          = wp_upload_dir();
			$current_time        = current_time( 'YmdHis' );
			$args['filepath']    = $this->export_directory . $current_time . '_export_risks.csv';
			$args['filename']    = $current_time . '_export_risks.csv';
			$args['url_to_file'] = $upload_dir['baseurl'] . '/digirisk/export/' . $current_time . '_export_risks.csv';
		}

		if ( empty( $args['number_risks'] ) ) {
			$args['number_risks'] = count( get_posts( array(
				'post_type'      => Risk_Class::g()->get_type(),
				'posts_per_page' => -1,
				'meta_key'       => '_wpdigi_preset',
				'meta_value'     => 1,
				'meta_compare'   => '!=',
			) ) );
		}

		$risks = Risk_Class::g()->get( array(
			'offset'         => $args['offset'],
			'posts_per_page' => $this->posts_per_page,
			'meta_key'       => '_wpdigi_preset',
			'meta_value'     => 1,
			'meta_compare'   => '!=',
		) );

		// Au augmente le offset pour la prochaine requête.
		$args['offset'] += $this->posts_per_page;

		$this->write_csv( $args['filepath'], $risks );

		if ( $args['offset'] >= $args['number_risks'] ) {
			$args['end'] = true;
		}

		return $args;
	}

	/**
	 * Ecris les données des risques dans un fichier CSV.
	 *
	 * @param string $filepath Le chemin vers le fichier CSV.
	 * @param array  $risks    Les données des risques.
	 * @return void
	 *
	 * @since 6.2.6
	 * @version 6.4.0
	 */
	public function write_csv( $filepath, $risks ) {
		$csv_file = fopen( $filepath, 'a' );

		if ( ! empty( $risks ) ) {
			foreach ( $risks as $risk ) {
				$risk_data_to_export = array(
					'unique_identifier' => $risk->data['unique_identifier'] . ' - ' . $risk->data['evaluation']->data['unique_identifier'],
					'risque'            => $risk->data['risk_category']->data['name'],
					'cotation'          => $risk->data['evaluation']->data['equivalence'],
					'comment_date'      => $risk->data['comment'][0]->data['date']['rendered']['date'],
					'comment_content'   => $risk->data['comment'][0]->data['content'],
				);

				fputcsv( $csv_file, $risk_data_to_export, ',' );
			}
		}

		fclose( $csv_file );
	}
}

Export_CSV_Class::g();
