<?php
/**
 * Appelle la vue permettant d'afficher la navigation
 *
 * @package Evarisk\Plugin
 */

namespace digi;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Appelle la vue permettant d'afficher la navigation
 */
class Navigation_Class extends Singleton_Util {

	/**
	 * Le constructeur
	 */
	protected function construct() {}

	/**
	 * La méthode qui permet d'afficher la page
	 *
	 * @param int $groupment_id L'ID du groupement à envoyer à la vue navigation/view/main.view.php.
	 * @return void
	 */
	public function display( $groupment_id ) {
		view_util::exec( 'navigation', 'main', array( 'groupment_id' => $groupment_id ) );
	}

	/**
	 * Charges le groupement sélectionné et l'envoie à la vue navigation/toggle/button.view.php avec comme nom de variable $groupment
	 *
	 * @param  int $groupment_id (optional) L'ID du groupement sélectionné.
	 *
	 * @return void
	 */
	public function display_toggle( $groupment_id = 0 ) {
		$groupment = group_class::g()->get( array( 'post__in' => array( $groupment_id ) ) );
		$groupment = $groupment[0];

		view_util::exec( 'navigation', 'toggle/button', array( 'groupment' => $groupment ) );
	}

	/**
	 * Charges les groupements selon le parent_id et les envoies à la vue navigation/toggle/list.view.php
	 *
	 * @param  integer $selected_groupment_id L'ID du groupement sélectionné.
	 * @param  integer $parent_id (optional) 	L'ID du groupement parent.
	 * @return void
	 */
	public function display_toggle_list( $selected_groupment_id, $parent_id = 0 ) {
		$groupments = group_class::g()->get(
			array(
				'posts_per_page' 	=> -1,
				'post_parent'			=> $parent_id,
				'post_status' 		=> array( 'publish', 'draft' ),
				'orderby'					=> array( 'menu_order' => 'ASC', 'date' => 'ASC' ),
			)
		);

		view_util::exec( 'navigation', 'toggle/list', array( 'selected_groupment_id' => $selected_groupment_id, 'groupments' => $groupments ) );
	}

	/**
	 * Charges les unités de travail selon le groupement parent et les envoies à la vue navigation/list.view.php
	 *
	 * @param  integer $parent_id L'ID du groupement parent.
	 * @return void
	 */
	public function display_workunit_list( $parent_id ) {
		$workunits = workunit_class::g()->get( array( 'post_parent' => $parent_id, 'posts_per_page' => -1 ), array( false ) );

		$workunit_selected_id = 0;

		if ( count( $workunits ) > 1 ) {
			$workunit_selected_id = $workunits[0]->id;

			usort( $workunits, function( $a, $b ) {
				if ( $a->unique_key === $b->unique_key ) {
					return 0;
				}
				return ( $a->unique_key < $b->unique_key ) ? -1 : 1;
			} );
		}

		view_util::exec( 'navigation', 'list', array( 'workunit_selected_id' => $workunit_selected_id, 'workunits' => $workunits, 'parent_id' => $parent_id ) );
	}
}

new Navigation_Class();
