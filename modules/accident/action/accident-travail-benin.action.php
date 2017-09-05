<?php
/**
 * Les actions relatives aux accident de travail benin (ODT)
 *
 * @author Jimmy Latour <jimmy@evarisk.com>
 * @since 6.3.0
 * @version 6.3.0
 * @copyright 2015-2017 Evarisk
 * @package DigiRisk
 */

namespace digi;

if ( ! defined( 'ABSPATH' ) ) {	exit; }

/**
 * Les actions relatives aux accident de travail benin (ODT)
 */
class Accident_Travail_Benin_Action {

	/**
	 * Le constructeur ajoutes l'action wp_ajax_generate_sheet_groupment
	 *
	 * @since 1.0
	 * @version 6.2.4.0
	 */
	public function __construct() {
		add_action( 'wp_ajax_generate_accident_benin', array( $this, 'ajax_generate_accident_benin' ) );
	}

	/**
	 * Appel la méthode "generate" de "Accident_Travail_Benin" afin de générer l'accident de travail bénin (ODT).
	 *
	 * @return void
	 *
	 * @since 6.3.0
	 * @version 6.3.0
	 */
	function ajax_generate_accident_benin() {
		check_ajax_referer( 'ajax_generate_accident_benin' );

		Accident_Travail_Benin_Class::g()->generate();

		ob_start();
		 Accident_Travail_Benin_Class::g()->display();
		wp_send_json_success( array(
			'namespace' => 'digirisk',
			'module' => 'accident',
			'callback_success' => 'generatedAccidentBenin',
			'view' => ob_get_clean(),
		) );
	}

}

new Accident_Travail_Benin_Action();
