<?php
/**
 * Ajoutes deux shortcodes
 * digi_evaluation_method permet d'afficher la méthode d'évaluation simple
 * digi_evaluation_method_complex permet d'afficher la méthode d'évaluation complexe
 *
 * @author Jimmy Latour <jimmy@evarisk.com>
 * @since 0.1
 * @version 6.2.3.0
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
	 * Récupères le niveau et l'équivalence de la méthode d'évaluation du risque courant.
	 *
	 * @param array $param Tableau de donnée.
	 *
	 * @return void
	 */
	public function callback_dropdown_danger( $param ) {
		$id = ! empty( $param ) && ! empty( $param['id'] ) ? $param['id'] : 0;
		$display = ! empty( $param ) && ! empty( $param['display'] ) ? $param['display'] : 'edit';

		if ( 'edit' === $display ) {
			$danger_category_list = category_danger_class::g()->get();
			$first_danger = null;

			if ( ! empty( $danger_category_list ) ) {
				foreach ( $danger_category_list as $element ) {
					$element->danger = Danger_Class::g()->get( array( 'parent' => $element->id ) );

					if ( empty( $first_danger ) && ! empty( $element->danger[0] ) ) {
						$first_danger = $element->danger[0];
					}
				}
			}

			view_util::exec( 'danger', 'dropdown', array( 'id' => $id, 'first_danger' => $first_danger, 'danger_category_list' => $danger_category_list ) );
		} else {
			$risk = risk_class::g()->get( array( 'include' => $id ) );
			$risk = $risk[0];
			view_util::exec( 'danger', 'item', array( 'id' => $id, 'risk' => $risk ) );
		}
	}
}

new Danger_Shortcode();
