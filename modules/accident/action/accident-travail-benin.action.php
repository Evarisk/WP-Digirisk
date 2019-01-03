<?php
/**
 * Les actions relatives aux accident de travail benin (ODT)
 *
 * @author Evarisk <dev@evarisk.com>
 * @since 6.3.0
 * @version 6.3.0
 * @copyright 2015-2017 Evarisk
 * @package DigiRisk
 */

namespace digi;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Les actions relatives aux accident de travail benin (ODT)
 */
class Accident_Travail_Benin_Action {

	/**
	 * Le constructeur ajoutes l'action wp_ajax_generate_accident_benin
	 *
	 * @since 6.3.0
	 */
	public function __construct() {
		add_action( 'generate_accident_benin', array( $this, 'generate_accident_benin' ), 10, 1 );
	}

	/**
	 * Appel la méthode "generate" de "Accident_Travail_Benin" afin de générer l'accident de travail bénin (ODT).
	 *
	 * @since 6.3.0
	 *
	 * @param integer $accident_id L'ID de l'accident.
	 */
	public function generate_accident_benin( $accident_id ) {
		$society = Society_Class::g()->get( array(
			'posts_per_page' => 1,
		), true );

		$accident = Accident_Class::g()->get( array( 'id' => $accident_id ), true );
		$response = Accident_Travail_Benin_Class::g()->prepare_document( $accident );
		Accident_Travail_Benin_Class::g()->create_document( $response['document']->data['id'] );
	}

}

new Accident_Travail_Benin_Action();
