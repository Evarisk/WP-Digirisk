<?php
/**
 * Classe gérant la recherche.
 *
 * @author    Evarisk <dev@evarisk.com>
 * @copyright (c) 2006-2018 Evarisk <dev@evarisk.com>.
 *
 * @license   AGPLv3 <https://spdx.org/licenses/AGPL-3.0-or-later.html>
 *
 * @package   DigiRisk\Classes
 *
 * @since     6.2.3
 */

namespace digi;

defined( 'ABSPATH' ) || exit;

/**
 * Search class.
 */
class Search_Class extends \eoxia\Singleton_Util {

	/**
	 * Le constructeur.
	 */
	protected function construct() {}

	/**
	 * Récupères les éléments selon le term et le type de la recherche.
	 *
	 * @param  array $data Les données pour la recherche.
	 * @return array       Les élements trouvés par la recherche.
	 *
	 * @since 6.2.3
	 */
	public function search( $data ) {
		$list = array();

		if ( 'user' === $data['type'] ) {
			if ( ! empty( $data['term'] ) ) {
				$list = get_users( array(
					'fields' => 'ID',
					'search' => '*' . $data['term'] . '*',
				) );

				$list = wp_parse_args( $list, get_users( array(
					'fields' => 'ID',
					'meta_query' => array(
						'relation' => 'OR',
						array(
							'key' => 'first_name',
							'value' => $data['term'],
							'compare' => 'LIKE',
						),
						array(
							'key' => 'last_name',
							'value' => $data['term'],
							'compare' => 'LIKE',
						),
					),
				) ) );

				$list = array_unique( $list );
			} else {
				$list = get_users( array(
					'fields' => 'ID',
					'exclude' => array( 1 ),
				) );
			}

			// Force le tableau de integer.
			$list = \eoxia\Array_Util::g()->to_int( $list );

		} elseif ( 'post' === $data['type'] ) {
			$model_name = '\digi\\' . $data['class'];
			$list = $model_name::g()->search( $data['term'], array(
				'option' => array( '_wpdigi_unique_identifier' ),
				'post_title'
			) );
		}

		return $list;
	}
}

Search_Class::g();
