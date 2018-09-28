<?php
/**
 * Mise à jour des données pour la version 6.6.3
 *
 * @author Evarisk
 * @since 6.6.3
 * @version 6.6.3
 * @copyright 2015-2018
 * @package DigiRisk
 */

namespace digi;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Class managing updates for version 6.6.3
 */
class Update_663 {
	private $limit_update = 1;
	/**
	 * Instanciate update for current version
	 */
	public function __construct() {
		add_action( 'wp_ajax_digirisk_merge_data', array( $this, 'callback_digirisk_merge_data' ) );
	}

	/**
	 * Récupères tous les GP et UT avec un status erronnées.
	 *
	 * @since 6.6.3
	 * @version 6.6.3
	 */
	public function callback_digirisk_merge_data() {
		$done = false;
		$societies = get_posts( array(
			'post_type'      => 'digi-workunit',
			'posts_per_page' => -1,
		) );

		if ( ! empty( $societies ) ) {
			foreach ( $societies as $society ) {
				$meta_key = '_wp_workunit';

				$old_meta = get_post_meta( $society->ID, $meta_key, true );
				$old_meta = \eoxia\JSON_Util::g()->decode( $old_meta );

				$new_meta = get_post_meta( $society->ID, '_wpdigi_society', true );
				$new_meta = \eoxia\JSON_Util::g()->decode( $new_meta );

				if ( ! empty( $old_meta ) ) {
					if ( ! empty( $new_meta['user_info']['affected_id'] ) && ! empty( $old_meta['user_info']['affected_id'] ) ) {
						$old_meta['user_info']['affected_id'] = array_merge( $old_meta['user_info']['affected_id'], $new_meta['user_info']['affected_id'] );
					}

					if ( empty( $new_meta ) ) {
						$new_meta = $old_meta;
					} else {
						$new_meta['user_info']['affected_id'] = $old_meta['user_info']['affected_id'];
					}
				}

				$new_meta = \wp_json_encode( $new_meta );
				$new_meta = addslashes( $new_meta );
				$new_meta = preg_replace_callback( '/\\\\u([0-9a-f]{4})/i', function ( $matches ) {
					$sym = mb_convert_encoding( pack( 'H*', $matches[1] ), 'UTF-8', 'UTF-16' );
					return $sym;
				}, $new_meta );
				update_post_meta( $society->ID, '_wpdigi_society', $new_meta );
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

}

new Update_663();
