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
		add_action( 'wp_ajax_digirisk_update_700_update_sheet_groupment', array( $this, 'callback_digirisk_update_700_update_sheet_groupment' ) );
		add_action( 'wp_ajax_digirisk_update_700_update_sheet_workunit', array( $this, 'callback_digirisk_update_700_update_sheet_workunit' ) );
		add_action( 'wp_ajax_digirisk_update_700_update_recommendation_category', array( $this, 'callback_digirisk_update_700_update_recommendation_category' ) );
		add_action( 'wp_ajax_digirisk_update_700_update_duer', array( $this, 'callback_digirisk_update_700_update_duer' ) );
		add_action( 'wp_ajax_digirisk_update_700_update_evaluation_method', array( $this, 'callback_digirisk_update_700_update_evaluation_method' ) );
		add_action( 'wp_ajax_digirisk_update_700_update_accident', array( $this, 'callback_digirisk_update_700_update_accident' ) );
		add_action( 'wp_ajax_digirisk_update_700_registre_at_benin', array( $this, 'callback_digirisk_update_700_registre_at_benin' ) );
		add_action( 'wp_ajax_digirisk_update_700_recommendation_comments', array( $this, 'callback_digirisk_update_700_recommendation_comments' ) );
		add_action( 'wp_ajax_digirisk_update_700_listing_risk', array( $this, 'callback_digirisk_update_700_listing_risk' ) );
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
			'progressionPerCent'       => '100',
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

		// mise à jour des équivalences.
		$risks = get_posts( array(
			'posts_per_page' => -1,
			'post_status'    => 'any',
			'post_type'      => 'digi-risk',
		) );

		$number_risk         = count( $risks );
		$number_risk_treated = 0;

		if ( ! empty( $risks ) ) {
			foreach ( $risks as $risk ) {
				$eval = get_comments( array(
					'post_id' => $risk->ID,
					'type'    => 'digi-risk-eval',
					'orderby' => 'comment_ID',
					'order'   => 'DESC',
					'number'  => 1,
				) );

				if ( ! empty( $eval ) ) {
					\eoxia\Log_Util::log( 'Mise à jour évaluation pour le risque ' . $risk->ID . ' evaluation : ' . json_encode( $eval[0] ), 'digirisk-maj' );
					$equivalence = get_comment_meta( $eval[0]->comment_ID, '_wpdigi_risk_evaluation_equivalence', true );
					update_post_meta( $risk->ID, '_wpdigi_equivalence', $equivalence );

					$risk_evaluation = get_comment_meta( $eval[0]->comment_ID, '_wpdigi_risk_evaluation', true );
					$risk_evaluation = \eoxia\JSON_Util::g()->decode( $risk_evaluation );

					\eoxia\Log_Util::log( 'Eval #' . $eval[0]->comment_ID . ' risk_evaluation : ' . json_encode( $risk_evaluation ), 'digirisk-maj' );
					if ( ! empty( $risk_evaluation['quotation_detail'] ) && isset( $risk_evaluation['quotation_detail']['variable_id'] ) && isset( $risk_evaluation['quotation_detail']['value'] ) ) {
						if ( ! isset( $risk_evaluation['variables'] ) ) {
							$risk_evaluation['variables'] = array();
						}

						$variable_id = $risk_evaluation['quotation_detail']['variable_id'];

						$tmp_term = get_term_by( 'term_id', $risk_evaluation['quotation_detail']['variable_id'], 'digi-method' );

						if ( ! empty( $tmp_term ) ) {
							$tmp_term = get_term_by( 'slug', 'evarisk', 'digi-method-variable' );

							if ( ! empty( $tmp_term ) ) {
								$variable_id = (int) $tmp_term->term_id;
							}
						}

						$risk_evaluation['variables'][ (int) $variable_id ] = (int) $risk_evaluation['quotation_detail']['value'];
					}

					if ( ! empty( $risk_evaluation['quotation_detail'] ) ) {
						foreach ( $risk_evaluation['quotation_detail'] as $quotation_detail ) {
							if ( ! empty( $quotation_detail['variable_id'] ) && isset( $quotation_detail['value'] ) ) {
								if ( ! isset( $risk_evaluation['variables'] ) ) {
									$risk_evaluation['variables'] = array();
								}

								$risk_evaluation['variables'][ (int) $quotation_detail['variable_id'] ] = (int) $quotation_detail['value'];
							}
						}
					}

					$risk_evaluation = \wp_json_encode( $risk_evaluation );
					$risk_evaluation = addslashes( $risk_evaluation );
					$risk_evaluation = preg_replace_callback( '/\\\\u([0-9a-f]{4})/i', function ( $matches ) {
						$sym = mb_convert_encoding( pack( 'H*', $matches[1] ), 'UTF-8', 'UTF-16' );
						return $sym;
					}, $risk_evaluation );
					\eoxia\Log_Util::log( 'Eval #' . $eval[0]->comment_ID . ' UPDATED risk_evaluation : ' . json_encode( $risk_evaluation ), 'digirisk-maj' );

					update_comment_meta( $eval[0]->comment_ID, '_wpdigi_risk_evaluation', $risk_evaluation );

				}

				$number_risk_treated++;
			}
		}

		wp_send_json_success( array(
			'updateComplete'     => false,
			'done'               => true,
			'progression'        => $number_risk_treated . '/' . $number_risk,
			'progressionPerCent' => 0 !== $number_risk ? ( ( $number_risk_treated * 100 ) / $number_risk ) : 0,
			'doneElementNumber'  => $number_risk_treated,
			'errors'             => null,
		) );
	}

	public function callback_digirisk_update_700_update_risk_comments() {
		$comments = get_comments( array(
			'type' => 'digi-riskevalcomment',
			'status' => '-34070',
		) );

		$comments = array_merge( $comments, get_comments( array(
			'type' => 'digi-riskevalcomment',
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
			'progressionPerCent'       => '100',
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
			'progressionPerCent'       => '100',
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
			'progressionPerCent'       => '100',
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

		$posts = get_posts( array(
			'post_type'      => 'digi-diffusion-info',
			'posts_per_page' => -1,
			'post_status'    => array( 'publish', 'inherit' ),
		) );

		if ( ! empty( $posts ) ) {
			foreach ( $posts as $post ) {
				$document_meta = get_post_meta( $post->ID, 'document_meta', true );
				$document_meta = \eoxia\JSON_Util::g()->decode( $document_meta );

				if ( ! empty ( $document_meta['delegues_du_personnels_date']['date_input'] ) ) {
					$document_meta['delegues_du_personnels_date'] = preg_replace('#(\d{2})/(\d{2})/(\d{4})\s(.*)#', '$3-$2-$1 $4', $document_meta['delegues_du_personnels_date']['date_input']['fr_FR']['date_time'] );
				}
				if ( ! empty ( $document_meta['membres_du_comite_entreprise_date']['date_input'] ) ) {
					$document_meta['membres_du_comite_entreprise_date'] = preg_replace('#(\d{2})/(\d{2})/(\d{4})\s(.*)#', '$3-$2-$1 $4', $document_meta['membres_du_comite_entreprise_date']['date_input']['fr_FR']['date_time'] );
				}

				$document_meta = \wp_json_encode( $document_meta );
				$document_meta = addslashes( $document_meta );
				$document_meta = preg_replace_callback( '/\\\\u([0-9a-f]{4})/i', function ( $matches ) {
					$sym = mb_convert_encoding( pack( 'H*', $matches[1] ), 'UTF-8', 'UTF-16' );
					return $sym;
				}, $document_meta );

				update_post_meta( $post->ID, '_wpdigi_diffusion_information', $document_meta );
			}
		}

		wp_send_json_success( array(
			'updateComplete'    => false,
			'done'              => true,
			'progressionPerCent'       => '100',
			'doneDescription'   => '',
			'doneElementNumber' => 0,
			'errors'            => null,
		) );
	}

	public function callback_digirisk_update_700_update_sheet_groupment() {
		global $wpdb;
		$dir = wp_upload_dir();

		$basedir = str_replace( '\\', '/', $dir['basedir'] );
		$baseurl = str_replace( '\\', '/', $dir['baseurl'] );

		$posts = get_posts( array(
			'post_type'      => 'fiche_de_groupement',
			'posts_per_page' => -1,
			'post_status'    => array( 'publish', 'inherit' ),
		) );

		if ( ! empty( $posts ) ) {
			foreach ( $posts as $post ) {
				update_post_meta( $post->ID, '_file_generated', true );

				if ( 0 !== $post->post_parent ) {

					$post_parent = get_post( $post->post_parent );

					$guid  = $baseurl . '/digirisk/';
					$guid .= '/' . $post_parent->post_type . '/' . $post->post_parent . '/';
					$guid .= $post->post_title . '.odt';

					$wpdb->update( $wpdb->posts, array(
						'guid'      => $guid,
						'post_type' => 'sheet_groupment',
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
			'progressionPerCent'       => '100',
			'doneDescription'   => '',
			'doneElementNumber' => 0,
			'errors'            => null,
		) );
	}
	public function callback_digirisk_update_700_update_sheet_workunit() {
		global $wpdb;
		$dir = wp_upload_dir();

		$basedir = str_replace( '\\', '/', $dir['basedir'] );
		$baseurl = str_replace( '\\', '/', $dir['baseurl'] );

		$posts = get_posts( array(
			'post_type'      => 'fiche_de_poste',
			'posts_per_page' => -1,
			'post_status'    => array( 'publish', 'inherit' ),
		) );

		if ( ! empty( $posts ) ) {
			foreach ( $posts as $post ) {
				update_post_meta( $post->ID, '_file_generated', true );

				if ( 0 !== $post->post_parent ) {

					$post_parent = get_post( $post->post_parent );

					$guid  = $baseurl . '/digirisk/';
					$guid .= '/' . $post_parent->post_type . '/' . $post->post_parent . '/';
					$guid .= $post->post_title . '.odt';

					$wpdb->update( $wpdb->posts, array(
						'guid'      => $guid,
						'post_type' => 'sheet_workunit',
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
			'progressionPerCent'       => '100',
			'doneDescription'   => '',
			'doneElementNumber' => 0,
			'errors'            => null,
		) );
	}

	public function callback_digirisk_update_700_update_recommendation_category() {
		global $wpdb;

		$old_categories = get_terms( array(
			'taxonomy'   => 'digi-recommendation-category',
			'hide_empty' => false,
		) );

		if ( ! empty( $old_categories ) ) {
			foreach ( $old_categories as $old_category ) {
				wp_delete_term( $old_category->term_id, 'digi-recommendation-category' );
			}
		}

		register_taxonomy( 'digi-recommendation', 'digi-recommendation' );

		$categories = get_terms( array(
			'taxonomy'   => 'digi-recommendation',
			'hide_empty' => false,
		) );

		if ( ! empty( $categories ) ) {
			foreach ( $categories as $category ) {
				$wpdb->update( $wpdb->term_taxonomy, array(
					'taxonomy' => 'digi-recommendation-category',
				),
				array( 'term_id' => $category->term_id ),
				array(
					'%s'
				),
				array(
					'%d'
				) );
			}
		}

		wp_send_json_success( array(
			'updateComplete'    => false,
			'done'              => true,
			'progressionPerCent'       => '100',
			'doneDescription'   => '',
			'doneElementNumber' => 0,
			'errors'            => null,
		) );
	}

	public function callback_digirisk_update_700_update_duer() {
		global $wpdb;
		$dir = wp_upload_dir();

		$basedir = str_replace( '\\', '/', $dir['basedir'] );
		$baseurl = str_replace( '\\', '/', $dir['baseurl'] );

		$duers = get_posts( array(
			'post_type'      => 'duer',
			'posts_per_page' => -1,
			'post_status'    => array( 'publish', 'inherit' ),
		) );

		if ( ! empty( $duers ) ) {
			foreach ( $duers as $duer ) {
				$document_meta = get_post_meta( $duer->ID, 'document_meta', true );
				$document_meta = \eoxia\JSON_Util::g()->decode( $document_meta );

				if ( ! empty ( $document_meta['dateGeneration']['date_input'] ) && ! empty( $document_meta['dateGeneration']['date_input']['fr_FR'] ) && ! empty( $document_meta['dateGeneration']['date_input']['fr_FR']['date_time'] ) ) {
					$document_meta['dateGeneration'] = preg_replace('#(\d{2})/(\d{2})/(\d{4})\s(.*)#', '$3-$2-$1 $4', $document_meta['dateGeneration']['date_input']['fr_FR']['date_time'] );
				}
				if ( ! empty ( $document_meta['dateDebutAudit']['date_input'] ) && ! empty( $document_meta['dateDebutAudit']['date_input']['fr_FR'] ) && ! empty( $document_meta['dateDebutAudit']['date_input']['fr_FR']['date_time'] ) ) {
					$document_meta['dateDebutAudit'] = preg_replace('#(\d{2})/(\d{2})/(\d{4})\s(.*)#', '$3-$2-$1 $4', $document_meta['dateDebutAudit']['date_input']['fr_FR']['date_time'] );
				}
				if ( ! empty ( $document_meta['dateFinAudit']['date_input'] ) && ! empty( $document_meta['dateFinAudit']['date_input']['fr_FR'] ) && ! empty( $document_meta['dateFinAudit']['date_input']['fr_FR']['date_time'] ) ) {
					$document_meta['dateFinAudit'] = preg_replace('#(\d{2})/(\d{2})/(\d{4})\s(.*)#', '$3-$2-$1 $4', $document_meta['dateFinAudit']['date_input']['fr_FR']['date_time'] );
				}

				$document_meta = \wp_json_encode( $document_meta );
				$document_meta = addslashes( $document_meta );
				$document_meta = preg_replace_callback( '/\\\\u([0-9a-f]{4})/i', function ( $matches ) {
					$sym = mb_convert_encoding( pack( 'H*', $matches[1] ), 'UTF-8', 'UTF-16' );
					return $sym;
				}, $document_meta );

				update_post_meta( $duer->ID, 'document_meta', $document_meta );

				update_post_meta( $duer->ID, '_file_generated', true );

				if ( 0 !== $duer->post_parent ) {

					$duer_parent = get_post( $duer->post_parent );

					$guid  = $baseurl . '/digirisk/';
					$guid .= '/' . $duer_parent->post_type . '/' . $duer->post_parent . '/';
					$guid .= $duer->post_title . '.odt';

					$wpdb->update( $wpdb->posts, array(
						'guid'      => $guid,
					),
					array( 'ID' => $duer->ID ),
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
			'progressionPerCent'       => '100',
			'doneDescription'   => '',
			'doneElementNumber' => 0,
			'errors'            => null,
		) );
	}

	public function callback_digirisk_update_700_update_evaluation_method() {
		$methodes = get_terms( array(
			'hide_empty' => false,
			'taxonomy'   => 'digi-method',
		) );

		if ( ! empty( $methodes ) ) {
			foreach ( $methodes as $method ) {

				$meta = get_term_meta( $method->term_id, '_wpdigi_method', true );
				$meta = \eoxia\JSON_Util::g()->decode( $meta );

				if ( ! empty( $meta['formula'] ) ) {
					foreach ( $meta['formula'] as $key => $element ) {
						if ( $element != '*' ) {
							$meta['formula'][ $key ] = (int) $element;
						} else {
							$meta['formula'][ $key ] = $element;
						}
					}
				}

				if ( 'evarisk-simplified' === $method->slug ) {
					if ( 4 === count( $meta['formula'] ) ) {
						array_splice( $meta['formula'], 1, 3 );
					}
				}

				$meta = \wp_json_encode( $meta );
				$meta = addslashes( $meta );
				$meta = preg_replace_callback( '/\\\\u([0-9a-f]{4})/i', function ( $matches ) {
					$sym = mb_convert_encoding( pack( 'H*', $matches[1] ), 'UTF-8', 'UTF-16' );
					return $sym;
				}, $meta );

				update_term_meta( $method->term_id, '_wpdigi_method', $meta );

			}
		}

		wp_send_json_success( array(
			'updateComplete'    => false,
			'done'              => true,
			'progressionPerCent'       => '100',
			'doneDescription'   => '',
			'doneElementNumber' => 0,
			'errors'            => null,
		) );
	}

	public function callback_digirisk_update_700_update_accident() {
		$accidents = get_posts( array(
			'posts_per_page' => -1,
			'post_type'      => 'digi-accident',
			'post_status'    => array( 'publish', 'inherit' ),
		) );

		if ( ! empty( $accidents ) ) {
			foreach ( $accidents as $accident ) {
				$document_meta = get_post_meta( $accident->ID, '_wpdigi_accident_date', true );
				$document_meta = \eoxia\JSON_Util::g()->decode( $document_meta );

				if ( ! empty ( $document_meta['date_input'] ) ) {
					$document_meta = preg_replace('#(\d{2})/(\d{2})/(\d{4})\s(.*)#', '$3-$2-$1 $4', $document_meta['date_input']['fr_FR']['date_time'] );
				}

				$document_meta = \wp_json_encode( $document_meta );
				$document_meta = addslashes( $document_meta );
				$document_meta = preg_replace_callback( '/\\\\u([0-9a-f]{4})/i', function ( $matches ) {
					$sym = mb_convert_encoding( pack( 'H*', $matches[1] ), 'UTF-8', 'UTF-16' );
					return $sym;
				}, $document_meta );

				update_post_meta( $accident->ID, '_wpdigi_accident_date', $document_meta );

				$document_meta = get_post_meta( $accident->ID, '_wpdigi_registration_date_in_register', true );
				$document_meta = \eoxia\JSON_Util::g()->decode( $document_meta );

				if ( ! empty ( $document_meta['date_input'] ) ) {
					$document_meta = preg_replace('#(\d{2})/(\d{2})/(\d{4})\s(.*)#', '$3-$2-$1 $4', $document_meta['date_input']['fr_FR']['date_time'] );
				}

				$document_meta = \wp_json_encode( $document_meta );
				$document_meta = addslashes( $document_meta );
				$document_meta = preg_replace_callback( '/\\\\u([0-9a-f]{4})/i', function ( $matches ) {
					$sym = mb_convert_encoding( pack( 'H*', $matches[1] ), 'UTF-8', 'UTF-16' );
					return $sym;
				}, $document_meta );

				update_post_meta( $accident->ID, '_wpdigi_registration_date_in_register', $document_meta );

				$comments = get_comments( array(
					'status'  => '-34070',
					'post_id' => $accident->ID,
				) );
				$comments = array_merge( $comments, get_comments( array(
					'status'  => '-34071',
					'post_id' => $accident->ID,
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
							'comment_type'   => 'ping',
						) );
					}
				}
			}
		}


		wp_send_json_success( array(
			'updateComplete'    => false,
			'done'              => true,
			'progressionPerCent'       => '100',
			'doneDescription'   => '',
			'doneElementNumber' => 0,
			'errors'            => null,
		) );
	}

	public function callback_digirisk_update_700_registre_at_benin() {
		global $wpdb;
		$dir = wp_upload_dir();

		$basedir = str_replace( '\\', '/', $dir['basedir'] );
		$baseurl = str_replace( '\\', '/', $dir['baseurl'] );

		$posts = get_posts( array(
			'post_type'      => 'accidents_benin',
			'posts_per_page' => -1,
			'post_status'    => array( 'publish', 'inherit' ),
		) );

		if ( ! empty( $posts ) ) {
			foreach ( $posts as $post ) {
				update_post_meta( $post->ID, '_file_generated', true );

				if ( 0 !== $post->post_parent ) {

					$post_parent = get_post( $post->post_parent );

					$guid  = $baseurl . '/digirisk/';
					$guid .= '/' . $post_parent->post_type . '/' . $post->post_parent . '/';
					$guid .= $post->post_title . '.odt';

					$wpdb->update( $wpdb->posts, array(
						'guid'      => $guid,
						'post_type' => 'registre_at_benin',
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
			'progressionPerCent'       => '100',
			'doneDescription'   => '',
			'doneElementNumber' => 0,
			'errors'            => null,
		) );
	}

	public function callback_digirisk_update_700_recommendation_comments() {
		$comments = get_comments( array(
			'type' => 'digi-re-comment',
			'status' => '-34070',
		) );

		$comments = array_merge( $comments, get_comments( array(
			'type' => 'digi-re-comment',
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
			'progressionPerCent'       => '100',
			'doneDescription'   => '',
			'doneElementNumber' => 0,
			'errors'            => null,
		) );
	}

	public function callback_digirisk_update_700_listing_risk() {
		// Mise à jour des listing de risque.
		global $wpdb;
		$dir = wp_upload_dir();

		$basedir = str_replace( '\\', '/', $dir['basedir'] );
		$baseurl = str_replace( '\\', '/', $dir['baseurl'] );

		$posts = get_posts( array(
			'post_type'      => 'listing_risk',
			'posts_per_page' => -1,
			'post_status'    => array( 'publish', 'inherit' ),
		) );

		if ( ! empty( $posts ) ) {
			foreach ( $posts as $post ) {
				update_post_meta( $post->ID, '_file_generated', true );

				if ( 0 !== $post->post_parent ) {

					$post_parent = get_post( $post->post_parent );

					$guid  = $baseurl . '/digirisk/';
					$guid .= '/' . $post_parent->post_type . '/' . $post->post_parent . '/';
					$guid .= $post->post_title . '.odt';

					$post_type = 'listing_risk_action';


					$terms = wp_get_object_terms( $post->ID, 'attachment_category' );

					if ( ! empty( $terms[0] ) && 'liste_des_risques_actions' !== $terms[0]->slug ) {
						$post_type = 'listing_risk_picture';
					}

					$wpdb->update( $wpdb->posts, array(
						'guid'      => $guid,
						'post_type' => $post_type,
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
			'progressionPerCent'       => '100',
			'doneDescription'   => '',
			'doneElementNumber' => 0,
			'errors'            => null,
		) );
	}

	private function convert_date( $document_meta, $string ) {
		if ( ! empty( $document_meta[ $string ]['date_input'] ) ) {
			$document_meta[ $string ]['raw'] = preg_replace('#(\d{2})/(\d{2})/(\d{4})\s(.*)#', '$3-$2-$1 $4', $document_meta[ $string ]['date_input']['fr_FR']['date_time'] );
			$document_meta[ $string ]['rendered'] = \eoxia\Date_Util::g()->fill_date( $document_meta[ $string ]['raw'] );
			unset( $document_meta[ $string ]['date_input'] );
			unset( $document_meta[ $string ]['date_human_readable'] );
		}

		return $document_meta;
	}
}

new Update_7000();
