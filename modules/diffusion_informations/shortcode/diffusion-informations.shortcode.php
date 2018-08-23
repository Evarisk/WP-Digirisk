<?php
/**
 * Gestion des shortcode des diffusions d'information.
 *
 * @author    Evarisk <dev@evarisk.com>
 * @copyright (c) 2006-2018 Evarisk <dev@evarisk.com>.
 *
 * @license   AGPLv3 <https://spdx.org/licenses/AGPL-3.0-or-later.html>
 *
 * @package   DigiRisk\Classes
 *
 * @since     6.0.0
 */

namespace digi;

defined( 'ABSPATH' ) || exit;

/**
 * Diffusion Informations Shortcode class.
 */
class Diffusion_Informations_Shortcode {

	/**
	 * Le constructeur
	 *
	 * @since 6.4.0
	 */
	public function __construct() {
		add_shortcode( 'digi-diffusion-informations', array( $this, 'callback_digi_diffusion_informations' ) );
	}

	/**
	 * Appelle la fonction display de la class affichage légal
	 *
	 * @since 6.4.0
	 *
	 * @param array $atts Les paramètres dans le shortcode.
	 */
	public function callback_digi_diffusion_informations( $atts ) {
		$element_id = ! empty( $atts['post_id'] ) ? (int) $atts['post_id'] : 0;

		Diffusion_Informations_Class::g()->display( $element_id, array( '\digi\Diffusion_Informations_A4_Class', '\digi\Diffusion_Informations_A3_Class' ), false );
		Diffusion_Informations_Class::g()->display_form( $element_id );
	}
}

new Diffusion_Informations_Shortcode();
