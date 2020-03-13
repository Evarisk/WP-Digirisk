<?php
/**
 * Ajoutes un shortcode qui permet d'afficher la liste de tous les statistiques d'une société/GP/UT.
 *
 * @author Evarisk <dev@evarisk.com>
 * @since 7.5.3
 * @version 7.5.3
 * @copyright 2015-2020 Evarisk
 * @package DigiRisk
 */

namespace digi;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Ajoutes un shortcode qui permet d'afficher la liste de tous les statistiques d'une société/GP/UT.
 */
class Statistics_Shortcode {

	/**
	 * Ajoutes le shortcode digi_risk qui permet l'affichage de la liste des statistiques.
	 */
	public function __construct() {
		add_shortcode( 'digi-statistic', array( $this, 'callback_digi_statistics' ) );
	}

	/**
	 * Appelle la méthode display de l'objet Statistics_Class pour gérer le rendu de la liste des statistiques.
	 *
	 * @param  array $param  Les arguments du shortcode.
	 * @return void
	 *
	 * @since 7.5.3
	 * @version 7.5.3
	 */
	public function callback_digi_statistics( $param ) {
		$element_id = ! empty( $param['post_id'] ) ? (int) $param['post_id'] : 0;
		Statistics_Class::g()->display( $element_id );
	}
}

new Statistics_Shortcode();

