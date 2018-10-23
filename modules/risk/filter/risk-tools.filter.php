<?php
/**
 * Les filtres relatives aux outils pour les risques
 *
 * @author Evarisk <dev@evarisk.com>
 * @since 6.4.5
 * @version 6.4.5
 * @copyright 2015-2018 Evarisk
 * @package risk
 * @subpackage filter
 */

namespace digi;

if ( ! defined( 'ABSPATH' ) ) {	exit; }

/**
 * Les filtres relatives à la page des rsiques.
 */
class Risk_Tools_Filter {

	/**
	 * Appel la définition des filtres utilisés pour les interfaces d'outils
	 *
	 * @return void nothing
	 *
	 * @since 6.4.5
	 * @version 6.4.5
	 */
	public function __construct() {
		add_filter( 'digi_tools_interface_tabs', array( $this, 'callback_digi_tools_interface_tabs' ) );
		add_filter( 'digi_tools_interface_content', array( $this, 'callback_digi_tools_interface_content' ) );
	}

	/**
	 * Ajout des onglets dans l'interface des outils
	 *
	 * @param string $current_output Le contenu actuel que l'on souhaite filtrer.
	 */
	public function callback_digi_tools_interface_tabs( $current_output ) {
		\eoxia001\View_Util::exec( 'digirisk', 'risk', 'tools/tab', array() );
	}

	/**
	 * Appel de l'interface permettant de ré associer les catégories de dangers
	 *
	 * @param string $current_output Le contenu actuel que l'on souhaite filtrer.
	 */
	public function callback_digi_tools_interface_content( $current_output ) {
		global $wpdb;

		// Récupération de la correspondance entre les anciennes catégories de danger et les nouvelles catégories de risques.
		$json_matching = array();
		$json_data_file_url_path_et_pif = \eoxia001\Config_Util::$init['digirisk']->update_manager->url . 'asset/json/risk-danger-6400.json';
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
		\eoxia001\View_Util::exec( 'digirisk', 'risk', 'tools/risk-categories', array(
			'digi_danger_category_list' => $digi_danger_category_list,
			'digi_category_risk_list'   => $digi_category_risk_list,
			'json_matching'             => $json_matching,
		) );
	}

}

new Risk_Tools_Filter();
