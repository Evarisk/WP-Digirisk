<?php
/**
 * Gestion des actions relatif aux onglets
 *
 * @author Evarisk <dev@evarisk.com>
 * @since 6.0.0
 * @version 7.0.0
 * @copyright 2015-2018 Evarisk
 * @package DigiRisk
 */

namespace digi;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Gestion des actions relatif aux onglets
 */
class Tab_Action {

	/**
	 * Le constructeur
	 *
	 * @since 6.0.0
	 */
	public function __construct() {
		add_action( 'wp_ajax_load_tab_content', array( $this, 'callback_load_tab_content' ) );
	}

	/**
	 * Charges le contenu d'un onglet
	 *
	 * @since 6.0.0
	 */
	public function callback_load_tab_content() {
		check_ajax_referer( 'load_content' );

		$element_id = ! empty( $_POST['element_id'] ) ? (int) $_POST['element_id'] : 0;
		$target     = ! empty( $_POST['target'] ) ? sanitize_key( $_POST['target'] ) : '';
		$title      = ! empty( $_POST['title'] ) ? sanitize_text_field( $_POST['title'] ) : '';

		$tab        = new \stdClass();
		$tab->title = $title;
		$tab->slug  = $target;

		ob_start();
		Tab_Class::g()->load_tab_content( $element_id, $tab );
		wp_send_json_success( array(
			'view' => ob_get_clean(),
		) );
	}
}

new Tab_Action();
