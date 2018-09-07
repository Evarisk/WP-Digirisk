<?php
/**
 * Classe gérant les listing des risques.
 *
 * @author    Evarisk <dev@evarisk.com>
 * @copyright (c) 2006 2018 Evarisk <dev@evarisk.com>.
 *
 * @license   AGPLv3 <https://spdx.org/licenses/AGPL-3.0-or-later.html>
 *
 * @package   DigiRisk\Classes
 *
 * @since     6.5.0
 */

namespace digi;

defined( 'ABSPATH' ) || exit;

/**
 * Lsting Risk Filter class.
 */
class Listing_Risk_Class extends \eoxia\Singleton_Util {

	/**
	 * Constructor.
	 *
	 * @since 6.5.0
	 */
	protected function construct() {}

	/**
	 * Affichage principale
	 *
	 * @since 6.5.0
	 *
	 * @param integer $parent_id [description]
	 */
	public function display( $parent_id, $types, $can_add = true ) {
		$documents = array();

		if ( ! empty( $types ) ) {
			foreach ( $types as $type ) {
				$documents = wp_parse_args( $documents, $type::g()->get( array(
					'post_parent' => $parent_id,
					'post_status' => array( 'publish', 'inherit' ),
				) ) );
			}
		}

		\eoxia\View_Util::exec( 'digirisk', 'listing-risk', 'main', array(
			'element_id' => $parent_id,
			'documents'  => $documents,
		) );
	}
}

new Listing_Risk_Class();
