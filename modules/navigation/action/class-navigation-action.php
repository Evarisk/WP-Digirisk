<?php
/**
 * Gestion des actions principaux pour le menu de navigation.
 *
 * @author    Evarisk <dev@evarisk.com>
 * @copyright (c) 2006 2018 Evarisk <dev@evarisk.com>.
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
 * Navigation action class.
 */
class Navigation_Action {

	/**
	 * Constructeur.
	 *
	 * @since 6.3.0
	 */
	public function __construct() {
		add_action( 'wp_ajax_create_society', array( $this, 'callback_create_society' ) );
		add_action( 'wp_ajax_load_society', array( $this, 'callback_load_society' ) );
	}

	/**
	 * Créer une société.
	 *
	 * @since 6.3.0
	 */
	public function callback_create_society() {
		check_ajax_referer( 'create_society' );

		$class     = ! empty( $_POST['class'] ) ? '\\digi\\' . sanitize_text_field( wp_unslash( $_POST['class'] ) ) : ''; // WPCS: input var ok.
		$parent_id = ! empty( $_POST['parent_id'] ) ? (int) $_POST['parent_id'] : 0; // WPCS: input var ok.
		$title     = ! empty( $_POST['title'] ) ? sanitize_text_field( wp_unslash( $_POST['title'] ) ) : ''; // WPCS: input var ok.

		$society = Society_Class::g()->get( array(
			'posts_per_page' => 1,
		), true );

		$establishment = $class::g()->update( array(
			'title'     => $title,
			'parent_id' => $parent_id,
			'status'    => 'inherit',
		) );

		// Utiles pour la vue main-content.
		$establishment_id = $establishment->data['id'];

		$class = ( $society->data['id'] === $parent_id ) ? 'workunit-list' : 'sub-list';

		ob_start();
		Navigation_Class::g()->display_list( $parent_id, $establishment->data['id'], $class );
		$navigation_view = ob_get_clean();

		ob_start();
		Digirisk::g()->display_main_container( $establishment->data['id'] );
		$content_view = ob_get_clean();
		wp_send_json_success( array(
			'namespace'        => 'digirisk',
			'module'           => 'navigation',
			'callback_success' => 'createdSocietySuccess',
			'navigation_view'  => $navigation_view,
			'content_view'     => $content_view,
			'society_id'       => $establishment->data['id'],
		) );
	}

	/**
	 * Charges le template d'une société
	 *
	 * @since 6.0.0
	 * @todo: 24/01/2018: Nonce.
	 */
	public function callback_load_society() {
		$society_id = ! empty( $_POST['establishment_id'] ) ? (int) $_POST['establishment_id'] : 0;

		ob_start();
		Digirisk::g()->display_main_container( $society_id );
		wp_send_json_success( array(
			'namespace'        => 'digirisk',
			'module'           => 'navigation',
			'callback_success' => 'loadedSocietySuccess',
			'view'             => ob_get_clean(),
		) );
	}
}

new Navigation_Action();
