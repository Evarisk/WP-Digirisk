<?php
/**
 * Les actions relatives aux sociétés
 *
 * @author Evarisk <dev@evarisk.com>
 * @since 6.0.0
 * @version 6.6.0
 * @copyright 2015-2018 Evarisk
 * @package DigiRisk
 */

namespace digi;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Les actions relatives aux sociétés
 */
class Society_Action {

	/**
	 * Le constructeur appelle les actions ajax suivantes:
	 * wp_ajax_load_sheet_display
	 * wp_ajax_save_society
	 *
	 * @since 6.0.0
	 * @version 6.4.0
	 */
	public function __construct() {
		add_action( 'wp_ajax_save_society', array( $this, 'callback_save_society' ) );
		add_action( 'wp_ajax_delete_society', array( $this, 'callback_delete_society' ) );
		add_action( 'wp_ajax_search_establishment', array( $this, 'callback_search_establishment' ) );
	}

	/**
	 * Sauvegardes les données d'une societé
	 *
	 * @since 6.0.0
	 * @version 6.4.0
	 */
	public function callback_save_society() {
		check_ajax_referer( 'save_society' );

		// todo: Doublon ?
		if ( 0 === (int) $_POST['id'] ) {
			wp_send_json_error();
		} else {
			$id = (int) $_POST['id'];
		}

		$group_id = $id;
		$workunit_id_selected = 0;

		$society = Society_Class::g()->show_by_type( $_POST['id'] );
		$society->title = $_POST['title'];

		if ( ! empty( $_POST['parent_id'] ) ) {
			$parent_id = (int) $_POST['parent_id'];
			$society->parent_id = $_POST['parent_id'];
		}

		Society_Class::g()->update_by_type( $society );

		if ( 'digi-workunit' === $society->type ) {
			$_POST['workunit_id'] = $society->id;
		}

		ob_start();
		Digirisk_Class::g()->display( $id );
		wp_send_json_success( array(
			'namespace'        => 'digirisk',
			'module'           => 'society',
			'callback_success' => 'savedSocietySuccess',
			'society'          => $society,
			'template'         => ob_get_clean(),
		) );
	}

	/**
	 * Supprimes une société
	 *
	 * @return void
	 *
	 * @since 6.0.0
	 * @version 6.6.0
	 */
	public function callback_delete_society() {
		check_ajax_referer( 'delete_society' );

		$id = ! empty( $_POST['id'] ) ? (int) $_POST['id'] : 0;

		$society = Society_Class::g()->delete( $id );

		ob_start();
		Digirisk_Class::g()->display( $society->parent_id );
		wp_send_json_success( array(
			'template'         => ob_get_clean(),
			'namespace'        => 'digirisk',
			'module'           => 'society',
			'callback_success' => 'deletedSocietySuccess',
		) );
	}

	/**
	 * Recherches une société depuis $_GET['term'].
	 *
	 * @since 6.4.0
	 * @version 6.4.0
	 *
	 * @return void
	 */
	public function callback_search_establishment() {
		global $wpdb;
		$term = sanitize_text_field( $_GET['term'] );

		$posts_type = array(
			'digi-group',
			'digi-workunit',
		);

		$posts_founded = array();
		$ids_founded = array();

		$query = "SELECT ID FROM {$wpdb->posts} WHERE ID LIKE '%" . $term . "%' AND post_type IN('" . implode( $posts_type, '\',\'' ) . "')";
		$results = $wpdb->get_results( $query );

		if ( ! empty( $results ) ) {
			foreach ( $results as $post ) {
				$ids_founded[] = $post->ID;
			}
		}

		$query = new \WP_Query( array(
			'post_type' => $posts_type,
			's' => $term,
			'post_status' => array( 'publish', 'draft' ),
		) );

		if ( ! empty( $query->posts ) ) {
			foreach ( $query->posts as $post ) {
				if ( ! in_array( $post->ID, $ids_founded, true ) ) {
					$ids_founded[] = $post->ID;
				}
			}
		}

		$query = "SELECT PM.post_id FROM {$wpdb->postmeta} AS PM
			JOIN {$wpdb->posts} AS P ON P.ID=PM.post_id
		WHERE PM.meta_key='_wpdigi_unique_identifier'
			AND PM.meta_value LIKE '%" . $term . "%'
			AND P.post_type IN('" . implode( $posts_type, '\',\'' ) . "')";
		$results = $wpdb->get_results( $query );

		if ( ! empty( $results ) ) {
			foreach ( $results as $post ) {
				$ids_founded[] = $post->post_id;
			}
		}

		if ( ! empty( $ids_founded ) ) {
			foreach ( $ids_founded as $id_founded ) {
				$s = Society_Class::g()->show_by_type( $id_founded );

				if ( ! empty( $s ) ) {
					$posts_founded[] = array(
						'label' => $s->modified_unique_identifier . ' ' . $s->title,
						'value' => $s->modified_unique_identifier . ' ' . $s->title,
						'id'    => $s->id,
					);
				}
			}
		}

		if ( empty( $posts_founded ) ) {
			$posts_founded[] = array(
				'label' => __( 'Aucun résultat', 'digirisk' ),
				'value' => __( 'Aucun résultat', 'digirisk' ),
				'id'    => 0,
			);
		}

		wp_die( wp_json_encode( $posts_founded ) );
	}

}

new Society_Action();
