<?php
/**
 * Les actions relatives aux diffusions informations
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
 * Les actions relatives aux aux diffusions informations.
 */
class Diffusion_Informations_Shortcode {

	/**
	 * Le constructeur
	 *
	 * @since 6.4.0
	 * @version 6.4.0
	 */
	public function __construct() {
		add_shortcode( 'digi-diffusion-informations', array( $this, 'callback_digi_diffusion_informations' ) );
	}

	/**
	 * Appelle la fonction display de la class affichage légal
	 *
	 * @param array $param Les paramètres dans le shortcode.
	 *
	 * @since 6.4.0
	 * @version 6.4.0
	 */
	public function callback_digi_diffusion_informations( $param ) {
		$element_id = $param['post_id'];

		Diffusion_Informations_Class::g()->display( $element_id );
	}
}

new Diffusion_Informations_Shortcode();
