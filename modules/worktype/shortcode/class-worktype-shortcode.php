<?php
/**
 * Ajoutes le shortcode pour gérer les types de travaux
 *
 * @author Evarisk <dev@evarisk.com>
 * @since 7.3.3
 * @version 7.3.3
 * @copyright 2019 Evarisk
 * @package DigiRisk
 */

namespace digi;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Ajoutes le shortcode pour gérer les types de travaux
 */
class Worktype_Category_Shortcode {

	/**
	 * Le constructeur
	 *
	 * @since 6.4.0
	 * @version 6.4.0
	 */
	public function __construct() {
		add_shortcode( 'digi_dropdown_worktype', array( $this, 'callback_dropdown_worktype' ) );
	}

	/**
	 * Récupères tous les types de travaux, et appel la vue danger-dropdown.view.php
	 * Si le travaux est déjà défini, appel la vue worktype-item.view.php
	 *
	 * @since 6.4.0
	 *
	 * @param array $param {
	 *                     Les propriété de tableau.
	 *
	 *                     @type integer $id               L'ID de la société.
	 *                     @type integer $category_risk_id L'ID de la catégorie sélectionnée.
	 *                     @type string  $display          Le mode d'affichage: 'edit' ou 'view'.
	 *                     @type integer $preset           1 ou 0.
	 * }
	 */
	public function callback_dropdown_worktype( $param ) {
		$id       = ! empty( $param ) && ! empty( $param['id'] ) ? $param['id'] : 0;
		$display  = ! empty( $param ) && ! empty( $param['display'] ) ? $param['display'] : 'edit';
		$worktype_id = ! empty( $param ) && ! empty( $param['category_worktype_id'] ) ? (int) $param['category_worktype_id'] : 0;

		$select_category_worktype = "";

		if ( 'edit' === $display ) {
			$worktype_categories = Worktype_Category_Class::g()->get( array(
				'meta_key' => '_position',
				'orderby'  => 'meta_value_num',
			) );

			if( $worktype_id != 0 ){
				$select_category_worktype = Worktype_Category_Class::g()->get( array( 'id' => $worktype_id ), true );
			}

			\eoxia\View_Util::exec( 'digirisk', 'worktype', 'category/dropdown', array(
				'id'                         => $id,
				'worktype_categories'        => $worktype_categories,
				'select_category_worktype'   => $select_category_worktype
			) );

		} else {
			$worktype_categories = null;

			if ( ! empty( $worktype_id ) ) {
				$worktype_category = Worktype_Category_Class::g()->get( array(
					'id' => $worktype_id,
				), true );
			}

			\eoxia\View_Util::exec( 'digirisk', 'worktype', 'category/item', array(
				'worktype_category' => $worktype_category,
			) );
		}
	}
}

new Worktype_Category_Shortcode();
