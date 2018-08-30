<?php
/**
 * Mise à jour des données pour la 7.0.0
 *
 * @author    Evarisk <dev@evarisk.com>
 * @copyright (c) 2006-2018 Evarisk <dev@evarisk.com>.
 *
 * @license   AGPLv3 <https://spdx.org/licenses/AGPL-3.0-or-later.html>
 *
 * @package   DigiRisk\Classes
 *
 * @since     7.0.0
 */

namespace digirisk;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Mise à jour des données pour la version 7.0.0
 */
class Update_7000 {

	/**
	 * Le constructeur
	 *
	 * @since 7.0.0
	 */
	public function __construct() {
		add_action( 'wp_ajax_digirisk_update_700_update_society', array( $this, 'callback_digirisk_update_700_update_society' ) );
		add_action( 'wp_ajax_digirisk_update_700_update_risk', array( $this, 'callback_digirisk_update_700_update_risk' ) );
		add_action( 'wp_ajax_digirisk_update_700_update_risk_comments', array( $this, 'callback_digirisk_update_700_update_risk_comments' ) );
		add_action( 'wp_ajax_digirisk_update_700_update_legal_display', array( $this, 'callback_digirisk_update_700_update_legal_display' ) );
		add_action( 'wp_ajax_digirisk_update_700_update_legal_display_doc', array( $this, 'callback_digirisk_update_700_update_legal_display_doc' ) );
		add_action( 'wp_ajax_digirisk_update_700_update_diffusion_information', array( $this, 'callback_digirisk_update_700_update_diffusion_information' ) );
	}

	public function callback_digirisk_update_700_update_society() {
		$posts = get_posts( array(
			'posts_per_page' => -1,
			'post_type'      => array( 'digi-group', 'digi-workunit' ),
		) );

		if ( ! empty( $posts ) ) {
			foreach ( $posts as $post ) {
				if ( 'publish' === $post->post_status ) {
					$post->post_status = 'inherit';

					wp_update_post( $post );
				}
			}
		}

		wp_send_json_success( array(
			'updateComplete'    => false,
			'done'              => true,
			'progression'       => '100',
			'doneDescription'   => '',
			'doneElementNumber' => 0,
			'errors'            => null,
		) );
	}

	public function callback_digirisk_update_700_update_risk() {
		$comments = get_comments( array(
			'type' => 'digi-risk-eval',
			'status' => '-34070',
		) );

		$comments = array_merge( $comments, get_comments( array(
			'type' => 'digi-risk-eval',
			'status' => '-34071',
		) ) );

		if ( ! empty( $comments ) ) {
			foreach ( $comments as $comment ) {
				if ( '-34070' == $comment->comment_approved ) {
					$comment->comment_approved = '1';
				}

				if ( '-34071' == $comment->comment_approved ) {
					$comment->comment_approved = 'trash';
				}

				wp_update_comment( array(
					'comment_ID'       => $comment->comment_ID,
					'comment_approved' => $comment->comment_approved,
				) );
			}
		}

		wp_send_json_success( array(
			'updateComplete'    => false,
			'done'              => true,
			'progression'       => '100',
			'doneDescription'   => '',
			'doneElementNumber' => 0,
			'errors'            => null,
		) );
	}

	public function callback_digirisk_update_700_update_risk_comments() {
		$comments = get_comments( array(
			'type' => 'digi-riskevalcomment',
			'status' => '-34070',
		) );

		$comments = array_merge( $comments, get_comments( array(
			'type' => 'digi-risk-evalcomment',
			'status' => '-34071',
		) ) );

		if ( ! empty( $comments ) ) {
			foreach ( $comments as $comment ) {
				if ( '-34070' == $comment->comment_approved ) {
					$comment->comment_approved = '1';
				}

				if ( '-34071' == $comment->comment_approved ) {
					$comment->comment_approved = 'trash';
				}

				wp_update_comment( array(
					'comment_ID'       => $comment->comment_ID,
					'comment_approved' => $comment->comment_approved,
				) );
			}
		}


		wp_send_json_success( array(
			'updateComplete'    => false,
			'done'              => true,
			'progression'       => '100',
			'doneDescription'   => '',
			'doneElementNumber' => 0,
			'errors'            => null,
		) );
	}

	public function callback_digirisk_update_700_update_legal_display() {
		$comments = get_comments( array(
			'type' => 'digi-address',
			'status' => '-34070',
		) );

		$comments = array_merge( $comments, get_comments( array(
			'type' => 'digi-address',
			'status' => '-34071',
		) ) );

		if ( ! empty( $comments ) ) {
			foreach ( $comments as $comment ) {
				if ( '-34070' == $comment->comment_approved ) {
					$comment->comment_approved = '1';
				}

				if ( '-34071' == $comment->comment_approved ) {
					$comment->comment_approved = 'trash';
				}

				wp_update_comment( array(
					'comment_ID'       => $comment->comment_ID,
					'comment_approved' => $comment->comment_approved,
				) );
			}
		}


		wp_send_json_success( array(
			'updateComplete'    => false,
			'done'              => true,
			'progression'       => '100',
			'doneDescription'   => '',
			'doneElementNumber' => 0,
			'errors'            => null,
		) );
	}

	public function callback_digirisk_update_700_update_legal_display_doc() {
		global $wpdb;
		$dir = wp_upload_dir();

		$basedir = str_replace( '\\', '/', $dir['basedir'] );
		$baseurl = str_replace( '\\', '/', $dir['baseurl'] );

		$posts = get_posts( array(
			'post_type'      => 'affichage_legal_a4',
			'posts_per_page' => -1,
			'post_status'    => array( 'publish', 'inherit' ),
		) );

		$posts = array_merge( $posts, get_posts( array(
			'post_type'      => 'affichage_legal_a3',
			'posts_per_page' => -1,
			'post_status'    => array( 'publish', 'inherit' ),
		) ) );

		if ( ! empty( $posts ) ) {
			foreach ( $posts as $post ) {
				update_post_meta( $post->ID, '_file_generated', true );

				if ( 0 !== $post->post_parent ) {

					$post_parent = get_post( $post->post_parent );

					$guid  = $baseurl . '/digirisk/';
					$guid .= '/' . $post_parent->post_type . '/' . $post->post_parent . '/';
					$guid .= $post->post_title . '.odt';

					$wpdb->update( $wpdb->posts, array(
						'guid' => $guid
					),
					array( 'ID' => $post->ID ),
					array(
						'%s'
					),
					array(
						'%d'
					) );
				}
			}
		}

		wp_send_json_success( array(
			'updateComplete'    => false,
			'done'              => true,
			'progression'       => '100',
			'doneDescription'   => '',
			'doneElementNumber' => 0,
			'errors'            => null,
		) );
	}

	public function callback_digirisk_update_700_update_diffusion_information() {
		global $wpdb;
		$dir = wp_upload_dir();

		$basedir = str_replace( '\\', '/', $dir['basedir'] );
		$baseurl = str_replace( '\\', '/', $dir['baseurl'] );

		$posts = get_posts( array(
			'post_type'      => 'diffusion_info_A4',
			'posts_per_page' => -1,
			'post_status'    => array( 'publish', 'inherit' ),
		) );

		$posts = array_merge( $posts, get_posts( array(
			'post_type'      => 'diffusion_info_A3',
			'posts_per_page' => -1,
			'post_status'    => array( 'publish', 'inherit' ),
		) ) );

		if ( ! empty( $posts ) ) {
			foreach ( $posts as $post ) {
				update_post_meta( $post->ID, '_file_generated', true );

				if ( 0 !== $post->post_parent ) {

					$post_parent = get_post( $post->post_parent );

					$guid  = $baseurl . '/digirisk/';
					$guid .= '/' . $post_parent->post_type . '/' . $post->post_parent . '/';
					$guid .= $post->post_title . '.odt';

					$wpdb->update( $wpdb->posts, array(
						'guid' => $guid
					),
					array( 'ID' => $post->ID ),
					array(
						'%s'
					),
					array(
						'%d'
					) );
				}
			}
		}

		wp_send_json_success( array(
			'updateComplete'    => false,
			'done'              => true,
			'progression'       => '100',
			'doneDescription'   => '',
			'doneElementNumber' => 0,
			'errors'            => null,
		) );
	}
}

new Update_7000();
