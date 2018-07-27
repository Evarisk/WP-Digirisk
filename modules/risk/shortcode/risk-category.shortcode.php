<?php
/**
 * Ajoutes le shortcode pour gérer les catégories de risque.
 *
 * @author    Evarisk <dev@evarisk.com>
 * @since     6.4.0
 * @version   6.6.0
 * @copyright 2018 Evarisk.
 * @package   DigiRisk
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
	}

	/**
	 * Récupères tous les dangers, et appel la vue danger-dropdown.view.php
	 * Si le danger du risque est déjà défini, appel la vue danger-item.view.php
	 *
	 * @since 6.4.0
	 * @version 6.6.0
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
		$id               = ! empty( $param ) && ! empty( $param['id'] ) ? $param['id'] : 0;
		$category_risk_id = ! empty( $param ) && ! empty( $param['category_risk_id'] ) ? (int) $param['category_risk_id'] : 0;
		$display          = ! empty( $param ) && ! empty( $param['display'] ) ? $param['display'] : 'edit';
		$preset           = ! empty( $param ) && ! empty( $param['preset'] ) ? (int) $param['preset'] : 0;

		if ( 'edit' === $display ) {
			$risk = Risk_Class::g()->get( array(
				'id' => $id,
			), true );

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
				'orderby'  => 'meta_value_num',
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

			\eoxia001\View_Util::exec( 'digirisk', 'risk', 'dropdown/dropdown', array(
				'id'                     => $id,
				'risks_categories'       => $risks_categories,
				'preset'                 => $preset,
				'selected_risk_category' => $selected_risk_category,
				'risk'                   => $risk,
			) );
		} else {
			$risk_category = null;
			
			if ( ! empty( $category_risk_id ) ) {
				$risk_category = Risk_Category_Class::g()->get( array(
					'id' => $category_risk_id,
				), true );
			}

			\eoxia001\View_Util::exec( 'digirisk', 'risk', 'dropdown/item', array(
				'risk_category' => $risk_category,
			) );
		}
	}

}

new Risk_Category_Shortcode();
