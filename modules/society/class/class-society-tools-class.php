<?php
/**
 * Classe gérant les sociétés dans la page outils.
 *
 * @author Evarisk <dev@evarisk.com>
 * @since 6.6.0
 * @version 6.6.0
 * @copyright 2015-2018 Evarisk
 * @package DigiRisk
 */

namespace digi;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Classe gérant les sociétés dans la page outils.
 */
class Society_Tools_Class extends \eoxia\Singleton_Util {

	/**
	 * Constructeur obligatoire pour Singleton_Util.
	 *
	 * @since 6.6.0
	 */
	protected function construct() {}

	/**
	 * Récupères les sociétés pour ensuite leur mettre le bon status.
	 *
	 * @since 6.6.0
	 *
	 * @param  integer $parent_id         L'ID de la société parent.
	 * @param  array   $list_to_recompile La liste des sociétés à l'instant T.
	 * @param  boolean $is_child          Est-ce un enfant ? (Defaut false).
	 * @return array                      La liste des sociétés avec les nouvelles.
	 */
	public function prepare_list_to_recompile( $parent_id, $list_to_recompile = array(), $is_child = false ) {
		$societies = get_posts( array(
			'post_parent'    => $parent_id,
			'posts_per_page' => -1,
			'post_type'      => array( 'digi-group', 'digi-workunit' ),
			'post_status'    => array( 'publish', 'draft', 'inherit', 'trash' ),
			'orderby'        => array(
				'menu_order' => 'ASC',
				'date'       => 'ASC',
			),
		) );

		if ( ! empty( $societies ) ) {
			foreach ( $societies as $society ) {
				if ( 'trash' === $society->post_status || $is_child ) {
					$child = get_children( array(
						'posts_per_page' => 1,
						'post_parent'    => $society->ID,
						'post_status'    => array( 'publish', 'draft', 'inherit', 'trash' ),
						'post_type'      => array( 'digi-group', 'digi-workunit' ),
					) );

					if ( count( $child ) > 0 ) {
						$list_to_recompile   = $this->prepare_list_to_recompile( $society->ID, $list_to_recompile, true );
						$list_to_recompile[] = $society->ID;
					} else {
						$list_to_recompile[] = $society->ID;
					}
				}
			}
		}

		return $list_to_recompile;
	}

	/**
	 * Passes les sociétés en trash.
	 *
	 * @param  array $list_to_recompile La liste des sociétés.
	 * @return boolean                  true si tout s'est bien passé.
	 */
	public function compile_list( $list_to_recompile ) {
		if ( ! empty( $list_to_recompile ) ) {
			foreach ( $list_to_recompile as $sub_list_to_recompile ) {
				wp_update_post( array(
					'ID'          => $sub_list_to_recompile,
					'post_status' => 'trash',
				) );
			}
		}

		return true;
	}
}

Society_Tools_Class::g();
