<?php
/**
 * Ajoutes le shortcode pour gérer les catégories de risque.
 *
 * @author Jimmy Latour <jimmy@evarisk.com>
 * @since 6.4.0
 * @version 6.4.0
 * @copyright 2015-2017 Evarisk
 * @package DigiRisk
 */

namespace digi;


if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Ajoutes le shortcode pour gérer les catégories de risque.
 */
class Risk_Category_Shortcode {

	/**
	 * Le constructeur
	 *
	 * @since 6.4.0
	 * @version 6.4.0
	 */
	public function __construct() {
		add_shortcode( 'digi-dropdown-categories-risk', array( $this, 'callback_dropdown_categories_risk' ) );

		add_shortcode( 'digi-fix-risk-categories', array( $this, 'callback_fix_risk_categories' ) );
	}

	/**
	 * Récupères tous les dangers, et appel la vue danger-dropdown.view.php
	 * Si le danger du risque est déjà défini, appel la vue danger-item.view.php
	 *
	 * @since 6.4.0
	 * @version 6.4.0
	 *
	 * @param array $param {
	 *                     Les propriété de tableau.
	 *
	 *                     @type integer $id               L'ID de la société.
	 *                     @type integer $category_risk_id L'ID de la catégorie sélectionnée.
	 *                     @type string  $display          Le mode d'affichage: 'edit' ou 'view'.
	 *                     @type integer $preset           1 ou 0.
	 * }
	 *
	 * @return void
	 */
	public function callback_dropdown_categories_risk( $param ) {
		$id = ! empty( $param ) && ! empty( $param['id'] ) ? $param['id'] : 0;
		$category_risk_id = ! empty( $param ) && ! empty( $param['category_risk_id'] ) ? (int) $param['category_risk_id'] : 0;
		$display = ! empty( $param ) && ! empty( $param['display'] ) ? $param['display'] : 'edit';
		$preset = ! empty( $param ) && ! empty( $param['preset'] ) ? (int) $param['preset'] : 0;

		if ( 'edit' === $display ) {
			$risks_categories_preset = Risk_Class::g()->get( array(
				'post_status' => array( 'publish' ),
				'meta_query'  => array(
					array(
						'key'     => '_wpdigi_preset',
						'value'   => 1,
						'compare' => '=',
					),
				),
			) );

			$risks_categories = Risk_Category_Class::g()->get( array(
				'meta_key' => '_position',
				'orderby' => 'meta_value_num',
			) );

			$selected_risk_category = '';

			if ( ! empty( $risks_categories ) ) {
				foreach ( $risks_categories as &$risk_category ) {
					$risk_category->is_preset = false;

					// Est-ce que c'est une catégorie de risque prédéfinie ?
					if ( ! empty( $risks_categories_preset ) ) {
						foreach ( $risks_categories_preset as $risk_category_preset ) {
							if ( ! empty( $risk_category_preset ) && ! empty( $risk_category_preset->taxonomy['digi-category-risk'] ) && $risk_category_preset->taxonomy['digi-category-risk'][0] === $risk_category->id && ! empty( $risk_category_preset->taxonomy['digi-method'] ) ) {
								$risk_category->is_preset = true;
								break;
							}
						}
					}

					if ( $risk_category->id === $category_risk_id ) {
						$selected_risk_category = $risk_category;
					}
				}
			}

			\eoxia\View_Util::exec( 'digirisk', 'risk', 'dropdown/dropdown', array(
				'id' => $id,
				'risks_categories' => $risks_categories,
				'preset' => $preset,
				'selected_risk_category' => $selected_risk_category,
			) );
		} else {
			$risk = Risk_Class::g()->get( array(
				'id' => $id,
			), true );

			\eoxia\View_Util::exec( 'digirisk', 'risk', 'dropdown/item', array(
				'id' => $id,
				'risk' => $risk,
			) );
		}
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

new Risk_Category_Shortcode();
