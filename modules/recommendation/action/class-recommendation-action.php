<?php
/**
 * Les actions des signalisations.
 *
 * @author    Evarisk <dev@evarisk.com>
 * @copyright (c) 2006-2018 Evarisk <dev@evarisk.com>.
 *
 * @license   AGPLv3 <https://spdx.org/licenses/AGPL-3.0-only.html>
 *
 * @package   DigiRisk\Classes
 *
 * @since     6.1.5
 * @version   7.0.0
 */

namespace digi;

defined( 'ABSPATH' ) || exit;

/**
 * Les actions relatives aux recommendations
 */
class Recommendation_Action {

	/**
	 * Constructeur.
	 *
	 * @since   6.1.5
	 * @version 6.2.4
	 */
	public function __construct() {
		add_action( 'wp_ajax_save_recommendation', array( $this, 'ajax_save_recommendation' ) );
		add_action( 'wp_ajax_load_recommendation', array( $this, 'ajax_load_recommendation' ) );
		add_action( 'wp_ajax_delete_recommendation', array( $this, 'ajax_delete_recommendation' ) );
	}

	/**
	 * Charges une recommendation
	 *
	 * @since   6.1.5
	 */
	public function ajax_load_recommendation() {
		check_ajax_referer( 'ajax_load_recommendation' );

		$id = ! empty( $_POST['id'] ) ? (int) $_POST['id'] : 0;

		if ( empty( $id ) ) {
			wp_send_json_error();
		}

		$recommendation = Recommendation::g()->get( array(
			'id' => $id,
		), true );

		ob_start();
		\eoxia\View_Util::exec( 'digirisk', 'recommendation', 'item-edit', array(
			'society_id'     => $recommendation->data['parent_id'],
			'recommendation' => $recommendation,
			), array(
			'\digi\recommendation_category_term',
			'\digi\recommendation_term',
		) );

		wp_send_json_success( array(
			'namespace'        => 'digirisk',
			'module'           => 'recommendation',
			'callback_success' => 'loadedRecommendationSuccess',
			'template'         => ob_get_clean(),
		) );
	}

	/**
	 * Sauvegardes une signalisation.
	 *
	 * @since   6.1.5
	 */
	public function ajax_save_recommendation() {
		check_ajax_referer( 'save_recommendation' );

		$id                     = ! empty( $_POST['id'] ) ? (int) $_POST['id'] : 0;
		$parent_id              = ! empty( $_POST['parent_id'] ) ? (int) $_POST['parent_id'] : 0;
		$image_id               = ! empty( $_POST['image'] ) ? (int) $_POST['image'] : 0;
		$recommendation_term_id = ! empty( $_POST['recommendation_category_id'] ) ? (int) $_POST['recommendation_category_id'] : 0;
		$comments               = ! empty( $_POST['list_comment'] ) ? (array) $_POST['list_comment'] : array();

		$recommendation_args = array(
			'id'        => $id,
			'parent_id' => $parent_id,
			'status'    => 'inherit',
		);

		$recommendation_args['taxonomy'] = array(
			'digi-recommendation-category' => (array) $recommendation_term_id,
		);

		$recommendation = Recommendation::g()->update( $recommendation_args );

		if ( ! empty( $image_id ) ) {
			$args_media = array(
				'id'         => $recommendation->data['id'],
				'file_id'    => $image_id,
				'model_name' => '\digi\Recommendation',
			);

			\eoxia\WPEO_Upload_Class::g()->set_thumbnail( $args_media );
			$args_media['field_name'] = 'image';
			\eoxia\WPEO_Upload_Class::g()->associate_file( $args_media );
		}

		if ( ! empty( $comments ) ) {
			foreach ( $comments as $comment ) {
				if ( ! empty( $comment['content'] ) ) {
					$comment['id']        = (int) $comment['id'];
					$comment['parent_id'] = (int) $comment['parent_id'];
					$comment['author_id'] = (int) $comment['author_id'];
					$comment['post_id']   = (int) $recommendation->data['id'];
					Recommendation_Comment_Class::g()->update( $comment );
				}
			}
		}

		do_action( 'digi_add_historic', array(
			'parent_id' => $recommendation->data['parent_id'],
			'id'        => $recommendation->data['id'],
			'content'   => __( 'Modification de la signalisation', 'digirisk' ) . ' ' . $recommendation->data['unique_identifier'],
		) );

		ob_start();
		Recommendation::g()->display( $recommendation->data['parent_id'] );
		wp_send_json_success( array(
			'namespace'        => 'digirisk',
			'module'           => 'recommendation',
			'callback_success' => 'savedRecommendationSuccess',
			'template'         => ob_get_clean(),
			'element'          => $recommendation,
		) );
	}

	/**
	 * Supprimes une recommendation (Passes son status en "deleted" dans le tableau)
	 *
	 * @return void
	 *
	 * @since 6.1.5
	 * @version 6.4.4
	 */
	public function ajax_delete_recommendation() {
		check_ajax_referer( 'ajax_delete_recommendation' );

		if ( 0 === (int) $_POST['id'] ) {
			wp_send_json_error();
		} else {
			$id = (int) $_POST['id'];
		}

		$recommendation = Recommendation::g()->get( array(
			'id' => $id,
		), true );

		if ( empty( $recommendation ) ) {
			wp_send_json_error();
		}

		$recommendation->data['status'] = 'trash';

		Recommendation::g()->update( $recommendation->data );

		do_action( 'digi_add_historic', array(
			'parent_id' => $recommendation->data['parent_id'],
			'id'        => $recommendation->data['id'],
			'content'   => __( 'Suppression de la signalisation', 'digirisk' ) . ' ' . $recommendation->data['unique_identifier'],
		) );

		wp_send_json_success( array(
			'namespace'        => 'digirisk',
			'module'           => 'recommendation',
			'callback_success' => 'deletedRecommendationSuccess',
			'template'         => ob_get_clean(),
			'element'          => $recommendation,
		) );
	}
}

new Recommendation_Action();
