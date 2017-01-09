<?php
/**
 * Ajoutes le shortcode pour afficher le toggle des dangers
 *
 * @author Jimmy Latour <jimmy@evarisk.com>
 * @since 0.1
 * @version 6.2.4.0
 * @copyright 2015-2017 Evarisk
 * @package danger
 * @subpackage shortcode
 */

namespace digi;


if ( ! defined( 'ABSPATH' ) ) { exit; }

/**
 * Les shortcodes relatifs aux dangers
 */
class Danger_Shortcode {

	/**
	 * Le constructeur
	 */
	public function __construct() {
		add_shortcode( 'dropdown_danger', array( $this, 'callback_dropdown_danger' ) );
	}

	/**
	 * Récupères tous les dangers, et appel la vue danger-dropdown.view.php
	 * Si le danger du risque est déjà défini, appel la vue danger-item.view.php
	 *
	 * @param array $param Tableau de donnée.
	 *
	 * @return void
	 */
	public function callback_dropdown_danger( $param ) {
		$id = ! empty( $param ) && ! empty( $param['id'] ) ? $param['id'] : 0;
		$display = ! empty( $param ) && ! empty( $param['display'] ) ? $param['display'] : 'edit';

		if ( 'edit' === $display ) {
			$danger_category_list = Category_Danger_Class::g()->get();

			if ( ! empty( $danger_category_list ) ) {
				foreach ( $danger_category_list as $element ) {
					$element->danger = Danger_Class::g()->get( array( 'parent' => $element->id ) );
				}
			}

			View_Util::exec( 'danger', 'dropdown', array( 'id' => $id, 'danger_category_list' => $danger_category_list ) );
		} else {
			$risk = Risk_Class::g()->get( array( 'include' => $id ) );
			$risk = $risk[0];
			View_Util::exec( 'danger', 'item', array( 'id' => $id, 'risk' => $risk ) );
		}
	}
}

new Danger_Shortcode();
