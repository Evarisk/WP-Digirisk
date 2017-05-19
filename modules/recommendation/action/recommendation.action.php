<?php
/**
 * Les actions relatives aux recommendations
 *
 * @author Jimmy Latour <jimmy@evarisk.com>
 * @since 1.0
 * @version 6.2.9.0
 * @copyright 2015-2017 Evarisk
 * @package recommendation
 * @subpackage action
 */

namespace digi;

if ( ! defined( 'ABSPATH' ) ) { exit; }

/**
 * Les actions relatives aux recommendations
 */
class Recommendation_Action {
	/**
	 * Le constructeur
	 *
	 * @since 0.1
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
	 * @since 0.1
	 * @version 6.2.9.0
	 */
	public function ajax_load_recommendation() {
		check_ajax_referer( 'ajax_load_recommendation' );

		if ( 0 === (int) $_POST['id'] ) {
			wp_send_json_error( array( 'error' => __LINE__ ) );
		} else {
			$id = (int) $_POST['id'];
		}

		$recommendation = Recommendation_Class::g()->get( array( 'id' => $id ) );
		$recommendation = $recommendation[0];

		ob_start();
		View_Util::exec( 'recommendation', 'item-edit', array( 'society_id' => $recommendation->parent_id, 'recommendation' => $recommendation ), array( '\digi\recommendation_category_term', '\digi\recommendation_term' ) );
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
	 * @since 0.1
	 * @version 6.2.9.0
	 */
	public function ajax_save_recommendation() {
		check_ajax_referer( 'save_recommendation' );

		$recommendation_term = Recommendation_Term_Class::g()->get( array( 'include' => $_POST['taxonomy']['digi-recommendation'] ) );
		$recommendation_term = $recommendation_term[0];
		$_POST['taxonomy']['digi-recommendation-category'][] = $recommendation_term->parent_id;
		$recommendation = Recommendation_Class::g()->update( $_POST );

		if ( ! empty( $_POST['list_comment'] ) ) {
			foreach ( $_POST['list_comment'] as $element ) {
				if ( ! empty( $element['content'] ) ) {
					$element['post_id'] = $recommendation->id;
					Recommendation_Comment_Class::g()->update( $element );
				}
			}
		}

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
	 * @since 0.1
	 * @version 6.2.9.0
	 */
	public function ajax_delete_recommendation() {
		check_ajax_referer( 'ajax_delete_recommendation' );

		if ( 0 === (int) $_POST['id'] ) {
			wp_send_json_error();
		} else {
			$id = (int) $_POST['id'];
		}

		$recommendation = Recommendation_Class::g()->get( array( 'id' => $id ) );
		$recommendation = $recommendation[0];

		if ( empty( $recommendation ) ) {
			wp_send_json_error();
		}

		$recommendation->status = 'trash';

		Recommendation_Class::g()->update( $recommendation );

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
