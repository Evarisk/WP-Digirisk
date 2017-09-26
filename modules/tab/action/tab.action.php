<?php
/**
 * Gestion des actions relatif aux onglets
 *
 * @author Jimmy Latour <jimmy@evarisk.com>
 * @since 6.0.0
 * @version 6.3.0
 * @copyright 2015-2017 Evarisk
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
	 * @version 6.2.4
	 */
	public function __construct() {
		add_action( 'wp_ajax_load_tab_content', array( $this, 'callback_load_tab_content' ) );
	}

	/**
	 * Charges le contenu d'un onglet
	 *
	 * @since 6.0.0
	 * @version 6.3.0
	 *
	 * @todo: Méthode pas appelé
	 */
	public function callback_load_tab_content() {
		check_ajax_referer( 'load_content' );

		$element_id = ! empty( $_POST['element_id'] ) ? (int) $_POST['element_id'] : 0;
		$tab_to_display = ! empty( $_POST['tab_to_display'] ) ? sanitize_key( $_POST['tab_to_display'] ) : '';
		$title = ! empty( $_POST['title'] ) ? sanitize_text_field( $_POST['title'] ) : '';

		// Modification du titre.
		$element = Society_Class::g()->show_by_type( $element_id );
		if ( Society_Class::g()->get_post_type() !== $element->type ) {
			$title .= ' ' . $element->unique_identifier . ' -';
		}
		$title .= ' ' . $element->title;

		ob_start();
		\eoxia\View_Util::exec( 'digirisk', 'tab', 'content', array(
			'title' => $title,
			'element_id' => $element_id,
			'tab_to_display' => $tab_to_display,
		), false );

		wp_send_json_success( array(
			'template' => ob_get_clean(),
		) );
	}
}

new Tab_Action();
