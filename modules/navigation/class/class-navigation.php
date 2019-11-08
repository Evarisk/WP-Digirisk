<?php
/**
 * Classe gérant la navigation.
 *
 * @author    Evarisk <dev@evarisk.com>
 * @copyright (c) 2006 2018 Evarisk <dev@evarisk.com>.
 *
 * @license   AGPLv3 <https://spdx.org/licenses/AGPL-3.0-or-later.html>
 *
 * @package   DigiRisk\Classes
 *
 * @since     6.0.0
 */

namespace digi;

defined( 'ABSPATH' ) || exit;

/**
 * Navigation class.
 */
class Navigation_Class extends \eoxia\Singleton_Util {

	/**
	 * Le constructeur
	 *
	 * @since 6.0.0
	 */
	protected function construct() {}

	/**
	 * La méthode qui permet d'afficher la navigation.
	 *
	 * @since 6.0.0
	 *
	 * @param integer $selected_society_id L'ID du groupement à envoyer à la vue navigation/view/main.view.php.
	 */
	public function display( $selected_society_id, $with_children = false ) {
		$society = new \WP_Query( array(
			'posts_per_page' => 1,
			'post_type'      => Society_Class::g()->get_type(),
		) );

		$society   = $society->post;
		$societies = array();

		if( $with_children ) {
			$societies = $this->get_children( $society->ID );
		}

		\eoxia\View_Util::exec( 'digirisk', 'navigation', 'main', array(
			'selected_society_id' => $selected_society_id,
			'societies'           => $societies,
			'society'             => $society,
			'with_children'       => $with_children,
		) );
	}

	/**
	 * Charges le groupement sélectionné et l'envoie à la vue navigation/toggle/button.view.php avec comme nom de variable $groupment
	 *
	 * @since 6.0.0
	 *
	 * @param integer $id (optional)                  L'ID de la société parent.
	 * @param integer $selected_society_id (optional) L'ID de la société selectionné.
	 * @param string  $class (optianal)               La classe utilisé pour la vue.
	 */
	public function display_list( $id = 0, $selected_society_id = 0, $with_children = false, $class = 'sub-list' ) {
		if ( ! empty( $id ) ) {
			if( $with_children ) {
				$societies = $this->get_children( $id );
			}

			\eoxia\View_Util::exec( 'digirisk', 'navigation', 'list', array(
				'id'                  => $id,
				'selected_society_id' => $selected_society_id,
				'societies'           => $societies,
				'class'               => $class,
				'with_children'       => $with_children,
			) );
		}
	}

	public function get_children( $parent_id ) {
		$societies = new \WP_Query( array(
			'post_parent'    => $parent_id,
			'posts_per_page' => -1,
			'post_type'      => array( Group_Class::g()->get_type(), Workunit_Class::g()->get_type() ),
			'post_status'    => 'inherit',
		) );

		if ( ! empty( $societies->posts ) ) {
			foreach ( $societies->posts as &$child_society ) {
				$child_society->unique_identifier = get_post_meta( $child_society->ID, '_wpdigi_unique_identifier', true );
			}
		}

		return $societies;
	}
}

Navigation_Class::g();
