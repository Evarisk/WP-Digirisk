<?php
/**
 * Les actions relatives aux diffusions informations
 *
 * @author Jimmy Latour <jimmy@evarisk.com>
 * @since 6.2.10.0
 * @version 6.2.10.0
 * @copyright 2015-2017 Evarisk
 * @package legal_display
 * @subpackage shortcode
 */

namespace digi;

if ( ! defined( 'ABSPATH' ) ) { exit; }

/**
 * Les actions relatives aux aux diffusions informations.
 */
class Diffusion_Informations_Shortcode {

	/**
	 * Le constructeur
	 *
	 * @since 6.2.10.0
	 * @version 6.2.10.0
	 */
	public function __construct() {
		add_shortcode( 'digi-diffusion-informations', array( $this, 'callback_digi_diffusion_informations' ) );
	}

	/**
	 * Appelle la fonction display de la class affichage légal
	 *
	 * @param array $param Les paramètres dans le shortcode.
	 *
	 * @since 6.2.10.0
	 * @version 6.2.10.0
	 */
	public function callback_digi_diffusion_informations( $param ) {
		$element_id = $param['post_id'];
		$element = Society_Class::g()->show_by_type( $element_id );

		\eoxia\View_Util::exec( 'digirisk', 'legal_display', 'diffusion_informations/main', array(
			'element' => $element,
		) );
	}
}

new Diffusion_Informations_Shortcode();
