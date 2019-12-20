<?php
/**
 * Mise à jour des données pour la 7.5.2
 *
 * @author    Evarisk <dev@evarisk.com>
 * @copyright (c) 2006-2018 Evarisk <dev@evarisk.com>.
 *
 * @license   AGPLv3 <https://spdx.org/licenses/AGPL-3.0-or-later.html>
 *
 * @package   DigiRisk\Classes
 *
 * @since     7.5.2
 */

namespace digirisk;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Mise à jour des données pour la version 7.5.2
 */
class Update_7520 {

	/**
	 * Le constructeur
	 *
	 * @since 7.0.0
	 */
	public function __construct() {
		add_action( 'wp_ajax_digirisk_update_752_update_signature_accident', array( $this, 'callback_digirisk_update_752_update_signature_accident' ) );
		add_action( 'wp_ajax_digirisk_update_752_update_signature_causerie', array( $this, 'callback_digirisk_update_752_update_signature_causerie' ) );
	}

	public function callback_digirisk_update_752_update_signature_accident() {
		// _wpdigi_accident
		// associated_document_id['signature_of_the_caregiver_id']
		// associated_document_id['signature_of_the_victim_id']

		$accidents = get_posts( array(
			'post_type'      => 'digi-accident',
			'posts_per_page' => -1,
			'post_status'    => array( 'publish', 'inherit' ),
		) );

		if ( ! empty( $accidents ) ) {
			foreach ( $accidents as $accident ) {
				$meta = get_post_meta( $accident->ID, '_wpdigi_accident', true );
				$meta = json_decode( $meta );

				if ( isset( $meta->associated_document_id->signature_of_the_caregiver_id[0] ) ) {
					update_post_meta( $accident->ID, 'signature_of_the_caregiver_id', $meta->associated_document_id->signature_of_the_caregiver_id[0] );
				}

				if ( isset( $meta->associated_document_id->signature_of_the_caregiver_id[0] ) ) {
					update_post_meta( $accident->ID, 'signature_of_the_victim_id', $meta->associated_document_id->signature_of_the_caregiver_id[0] );
				}
			}
		}

		wp_send_json_success( array(
			'updateComplete'     => false,
			'done'               => true,
			'progressionPerCent' => '100',
			'doneDescription'    => '',
			'doneElementNumber'  => 0,
			'errors'             => null,
		) );
	}

	public function callback_digirisk_update_752_update_signature_causerie() {
		// _wpdigi_final_causerie
		// former->signature_id
		// participants[]->signature_id to participants_signature_id_{parent_id}

		$causeries = get_posts( array(
			'post_type'      => 'digi-final-causerie',
			'posts_per_page' => -1,
			'post_status'    => array( 'publish', 'inherit', 'any' ),
		) );

		if ( ! empty( $causeries ) ) {
			foreach ( $causeries as $causerie ) {
				$meta = get_post_meta( $causerie->ID, '_wpdigi_final_causerie', true );
				$meta = json_decode( $meta );

				if ( ! empty( $meta->participants ) ) {
					foreach ( $meta->participants as $participant ) {
						update_user_meta( $participant->user_id, 'participants_signature_id_' . $causerie->ID, $participant->signature_id );
					}
				}
			}
		}

		wp_send_json_success( array(
			'updateComplete'     => false,
			'done'               => true,
			'progressionPerCent' => '100',
			'doneDescription'    => '',
			'doneElementNumber'  => 0,
			'errors'             => null,
		) );
	}
}

new Update_7520();
