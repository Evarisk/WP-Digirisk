<?php
/**
 * Classe gérant les shortcode du listing de risque.
 *
 * @author    Evarisk <dev@evarisk.com>
 * @copyright (c) 2006 2018 Evarisk <dev@evarisk.com>.
 *
 * @license   AGPLv3 <https://spdx.org/licenses/AGPL-3.0-or-later.html>
 *
 * @package   DigiRisk\Classes
 *
 * @since     6.5.0
 */

namespace digi;

defined( 'ABSPATH' ) || exit;

/**
 * Lsting Risk Shortcode class.
 */
class Listing_Risk_Shortcode {

	/**
	 * Constructor.
	 *
	 * @since 6.5.0
	 */
	public function __construct() {
		add_shortcode( 'digi-listing-risk-action-corrective', array( $this, 'callback_digi_listing_risk_action_corrective' ) );
		add_shortcode( 'digi-listing-risk-photo', array( $this, 'callback_digi_listing_risk_photo' ) );
	}

	/**
	 * Appelle la méthode display de l'objet Risk_Class pour gérer le rendu du listing des risques.
	 *
	 * @version 6.5.0
	 *
	 * @param  array $param  Les arguments du shortcode.
	 */
	public function callback_digi_listing_risk_action_corrective( $param ) {
		$element_id = ! empty( $param['post_id'] ) ? (int) $param['post_id'] : 0;
		Listing_Risk_Corrective_Task_Class::g()->display( $element_id, array( '\digi\Listing_Risk_Corrective_Task_Class' ) );
	}

	/**
	 * Appelle la méthode display de l'objet Risk_Class pour gérer le rendu du listing des risques.
	 *
	 * @version 7.0.0
	 *
	 * @param  array $param  Les arguments du shortcode.
	 */
	public function callback_digi_listing_risk_photo( $param ) {
		$element_id = ! empty( $param['post_id'] ) ? (int) $param['post_id'] : 0;
		Listing_Risk_Picture_Class::g()->display( $element_id, array( '\digi\Listing_Risk_Picture_Class' ) );
	}
}

new Listing_Risk_Shortcode();
