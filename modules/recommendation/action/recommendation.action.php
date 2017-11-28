<?php
/**
 * Les actions relatives aux recommendations
 *
 * @author Jimmy Latour <jimmy@evarisk.com>
 * @since 6.0.0
 * @version 6.4.0
 * @copyright 2015-2017 Evarisk
 * @package DigiRisk
 */

namespace digi;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Les actions relatives aux recommendations
 */
class Recommendation_Action {
	/**
	 * Le constructeur
	 *
	 * @since 6.0.0
	 * @version 6.2.4.0
	 */
	function __construct() {
		add_action( 'wp_ajax_save_recommendation', array( $this, 'ajax_save_recommendation' ) );
		add_action( 'wp_ajax_load_recommendation', array( $this, 'ajax_load_recommendation' ) );
		add_action( 'wp_ajax_delete_recommendation', array( $this, 'ajax_delete_recommendation' ) );

		add_action( 'wp_ajax_transfert_recommendation', array( $this, 'ajax_transfert_recommendation' ) );
	}

	/**
	 * Charges une recommendation
	 *
	 * @since 6.0.0
	 * @version 6.2.10.0
	 */
	public function ajax_load_recommendation() {
		check_ajax_referer( 'ajax_load_recommendation' );

		if ( 0 === (int) $_POST['id'] ) {
			wp_send_json_error();
		} else {
			$id = (int) $_POST['id'];
		}

		$recommendation = Recommendation_Class::g()->get( array(
			'id' => $id,
		) );
		$recommendation = $recommendation[0];

		ob_start();
		\eoxia\View_Util::exec( 'digirisk', 'recommendation', 'item-edit', array(
			'society_id' => $recommendation->parent_id,
			'recommendation' => $recommendation,
			), array(
			'\digi\recommendation_category_term',
			'\digi\recommendation_term',
		) );
		wp_send_json_success( array(
			'namespace' => 'digirisk',
			'module' => 'recommendation',
			'callback_success' => 'loadedRecommendationSuccess',
			'template' => ob_get_clean(),
		) );
	}

	/**
	 * Sauvegardes une recommendation ainsi que la liste des commentaires.
	 *
	 * @return void
	 *
	 * @since 6.0.0
	 * @version 6.4.0
	 */
	public function ajax_save_recommendation() {
		check_ajax_referer( 'save_recommendation' );

		$image_id = ! empty( $_POST['image'] ) ? (int) $_POST['image'] : 0;

		$recommendation_term = Recommendation_Term_Class::g()->get( array(
			'include' => $_POST['taxonomy']['digi-recommendation'],
		) );

		$recommendation_term = $recommendation_term[0];
		$_POST['taxonomy']['digi-recommendation-category'][] = $recommendation_term->parent_id;
		$recommendation = Recommendation_Class::g()->update( $_POST );

		if ( ! empty( $image_id ) ) {
			$args_media = array(
				'id' => $recommendation->id,
				'file_id' => $image_id,
				'model_name' => '\digi\Recommendation_Class',
			);

			\eoxia\WPEO_Upload_Class::g()->set_thumbnail( $args_media );
			$args_media['field_name'] = 'image';
			\eoxia\WPEO_Upload_Class::g()->associate_file( $args_media );
		}

		if ( ! empty( $_POST['list_comment'] ) ) {
			foreach ( $_POST['list_comment'] as $element ) {
				if ( ! empty( $element['content'] ) ) {
					$element['post_id'] = $recommendation->id;
					Recommendation_Comment_Class::g()->update( $element );
				}
			}
		}

		do_action( 'digi_add_historic', array(
			'parent_id' => $recommendation->parent_id,
			'id' => $recommendation->id,
			'content' => __( 'Modification de la signalisation', 'digirisk' ) . ' ' . $recommendation->unique_identifier,
		) );

		ob_start();
		Recommendation_Class::g()->display( $recommendation->parent_id );
		wp_send_json_success( array(
			'namespace' => 'digirisk',
			'module' => 'recommendation',
			'callback_success' => 'savedRecommendationSuccess',
			'template' => ob_get_clean(),
		) );
	}

	/**
	 * Supprimes une recommendation (Passes son status en "deleted" dans le tableau)
	 *
	 * @return void
	 *
	 * @since 6.0.0
	 * @version 6.2.10.0
	 */
	public function ajax_delete_recommendation() {
		check_ajax_referer( 'ajax_delete_recommendation' );

		if ( 0 === (int) $_POST['id'] ) {
			wp_send_json_error();
		} else {
			$id = (int) $_POST['id'];
		}

		$recommendation = Recommendation_Class::g()->get( array(
			'id' => $id,
		) );
		$recommendation = $recommendation[0];

		if ( empty( $recommendation ) ) {
			wp_send_json_error();
		}

		$recommendation->status = 'trash';

		Recommendation_Class::g()->update( $recommendation );

		do_action( 'digi_add_historic', array(
			'parent_id' => $recommendation->parent_id,
			'id' => $recommendation->id,
			'content' => __( 'Suppression de la signalisation', 'digirisk' ) . ' ' . $recommendation->unique_identifier,
		) );

		wp_send_json_success( array(
			'namespace' => 'digirisk',
			'module' => 'recommendation',
			'callback_success' => 'deletedRecommendationSuccess',
			'template' => ob_get_clean(),
		) );
	}

	public function ajax_transfert_recommendation() {
		recommendation_class::g()->transfert();
		wp_send_json_success();
	}
}

new Recommendation_Action();
