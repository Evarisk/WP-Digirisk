<?php
/**
 * Ajoutes le shortcode pour gérer les outils des catégories de risque.
 *
 * @author Evarisk <dev@evarisk.com>
 * @since 6.4.5
 * @version 6.4.5
 * @copyright 2015-2017 Evarisk
 * @package DigiRisk
 */

namespace digi;


if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Ajoutes le shortcode pour gérer les outils des catégories de risque.
 */
class Risk_Category_Tools_Shortcode {

	/**
	 * Le constructeur
	 *
	 * @since 6.4.5
	 * @version 6.4.5
	 */
	public function __construct() {
		add_shortcode( 'digi-fix-risk-categories', array( $this, 'callback_fix_risk_categories' ) );
	}

	/**
	 * Shortcode permettant l'affichage de l'interterface de correction d'affectation des catégories de danger aux risques ayant été affectés lors du transfert en version 6.4.à
	 *
	 * @param array $param La liste des arguments passés au shortcode.
	 *
	 * @since 6.4.5
	 * @version 6.4.5
	 *
	 * @return void
	 */
	public function callback_fix_risk_categories( $param ) {
		global $wpdb;

		// Récupération de la correspondance entre les anciennes catégories de danger et les nouvelles catégories de risques.
		$json_matching = array();
		$json_data_file_url_path_et_pif = \eoxia\Config_Util::$init['digirisk']->update_manager->url . 'asset/json/risk-danger-6400.json';
		$request = wp_remote_get( $json_data_file_url_path_et_pif );
		if ( ! is_wp_error( $request ) ) {
			$data = wp_remote_retrieve_body( $request );
			if ( ! is_wp_error( $data ) ) {
				$json_matching = json_decode( $data, true );
			}
		}

		// Récupération de la liste des catégories de danger qui sont affectées à au moins un risque.
		$digi_danger_category_list = $wpdb->get_results( $wpdb->prepare(
			"SELECT T.*
		 	FROM {$wpdb->term_relationships} AS TR
				JOIN {$wpdb->term_taxonomy} AS TT ON ( TT.term_taxonomy_id = TR.term_taxonomy_id )
				JOIN {$wpdb->terms} AS T ON ( T.term_id = TT.term_id )
			WHERE TT.taxonomy = %s
			GROUP BY T.term_id", 'digi-danger-category' ) );

		// Récuération de la liste des catégories de risques existantes.
		$digi_category_risk_list = $wpdb->get_results( $wpdb->prepare(
			"SELECT T.*
		 	FROM {$wpdb->term_taxonomy} AS TT
				JOIN {$wpdb->terms} AS T ON ( T.term_id = TT.term_id )
			WHERE TT.taxonomy = %s
			GROUP BY T.term_id", 'digi-category-risk' ) );

		// Affichage de l'interface.
		\eoxia\View_Util::exec( 'digirisk', 'risk', 'tools/main', array(
			'digi_danger_category_list' => $digi_danger_category_list,
			'digi_category_risk_list'   => $digi_category_risk_list,
			'json_matching'             => $json_matching,
		) );
	}

}

new Risk_Category_Tools_Shortcode();
