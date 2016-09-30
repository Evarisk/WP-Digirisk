<?php namespace digi;

if ( !defined( 'ABSPATH' ) ) exit;

/**
 * @author Jimmy Latour <jimmy.eoxia@gmail.com>
 * @version 1.0
 */

class post_util extends singleton_util {
	protected function construct() {}

	/**
	* Est ce que le post est un parent des enfants ?
	*
	* @param int $parent_id (test: 10) L'id du post parent
	* @param int $children_id (test: 11) L'id du post enfant
	*
	* @return bool true|false
	*/
	public static function is_parent( $parent_id, $children_id ) {
		$list_parent_id = get_post_ancestors( $children_id );
		if ( !empty( $list_parent_id) && in_array( $parent_id, $list_parent_id ) )
			return true;
		return false;
	}
}
