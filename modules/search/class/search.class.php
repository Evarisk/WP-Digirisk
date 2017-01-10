<?php
/**
 * Classe gérant la recherche
 *
 * @author Jimmy Latour <jimmy@evarisk.com>
 * @since 6.2.3.0
 * @version 6.2.4.0
 * @copyright 2015-2017 Evarisk
 * @package search
 * @subpackage action
 */

namespace digi;

if ( ! defined( 'ABSPATH' ) ) { exit; }

/**
 * Classe gérant la recherche
 */
class Search_Class extends singleton_util {

	/**
	 * Le constructeur
	 */
	protected function construct() {}

	/**
	 * Récupères les éléments selon le term et le type de la recherche.
	 *
	 * @param  array $data Les données pour la recherche.
	 * @return array       Les élements trouvés par la recherche.
	 *
	 * @since 1.0
	 * @version 6.2.4.0
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
			$list = Array_Util::g()->to_int( $list );

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
