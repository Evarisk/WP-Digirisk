<?php
/**
 * Classe gérant la navigation
 *
 * @author Jimmy Latour <jimmy@evarisk.com>
 * @since 6.2.3.0
 * @version 6.2.4.0
 * @copyright 2015-2017 Evarisk
 * @package navigation
 * @subpackage class
 */
namespace digi;

if ( ! defined( 'ABSPATH' ) ) {	exit; }

/**
 * Appelle la vue permettant d'afficher la navigation
 */
class Navigation_Class extends Singleton_Util {

	/**
	 * Le constructeur
	 *
	 * @since 0.1
	 * @version 6.2.4.0
	 */
	protected function construct() {}

	/**
	 * La méthode qui permet d'afficher la page
	 *
	 * @param int $groupment_id L'ID du groupement à envoyer à la vue navigation/view/main.view.php.
	 * @return void
	 *
	 * @since 0.1
	 * @version 6.2.5.0
	 */
	public function display( $groupment_id ) {
		View_Util::exec( 'navigation', 'main', array( 'groupment_id' => $groupment_id ) );
	}

	/**
	 * Charges le groupement sélectionné et l'envoie à la vue navigation/toggle/button.view.php avec comme nom de variable $groupment
	 *
	 * @param  int $groupment_id (optional) L'ID du groupement sélectionné.
	 *
	 * @return void
	 *
	 * @since 0.1
	 * @version 6.2.5.0
	 */
	public function display_toggle( $groupment_id = 0 ) {
		$groupment = Group_Class::g()->get( array( 'post__in' => array( $groupment_id ) ) );
		$groupment = $groupment[0];

		View_Util::exec( 'navigation', 'toggle/button', array( 'groupment' => $groupment ) );
	}

	/**
	 * Charges les groupements selon le parent_id et les envoies à la vue navigation/toggle/list.view.php
	 *
	 * @param  integer $selected_groupment_id L'ID du groupement sélectionné.
	 * @param  integer $parent_id (optional) 	L'ID du groupement parent.
	 * @return void
	 *
	 * @since 0.1
	 * @version 6.2.4.0
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

		if ( !empty( $groupments ) ) {
			foreach ( $groupments as $groupment ) {
				$groupment->count_workunit = count( Workunit_Class::g()->get( array( 'post_parent' => $groupment->id, 'posts_per_page' => -1 ) ) );
			}
		}

		view_util::exec( 'navigation', 'toggle/list', array( 'selected_groupment_id' => $selected_groupment_id, 'groupments' => $groupments ) );
	}

	/**
	 * Vérifie si on affiche le formulaire pour créer une unité de travail ou pas.
	 * Charges les unités de travail selon le groupement parent et les envoies à la vue navigation/list.view.php.
	 *
	 * @param  integer $parent_id L'ID du groupement parent.
	 * @return void
	 *
	 * @since 0.1
	 * @version 6.2.5.0
	 */
	public function display_workunit_list( $parent_id ) {
		$display_create_workunit_form = ( count( group_class::g()->get( array( 'post_parent' => $parent_id, 'posts_per_page' => -1 ) ) ) === 0 ) ? true : false;

		$workunits = workunit_class::g()->get( array( 'post_parent' => $parent_id, 'posts_per_page' => -1 ) );

		$workunit_selected_id = 0;

		if ( count( $workunits ) > 1 ) {
			usort( $workunits, function( $a, $b ) {
				if ( $a->unique_key === $b->unique_key ) {
					return 0;
				}
				return ( $a->unique_key < $b->unique_key ) ? -1 : 1;
			} );
		}

		if ( ! empty( $_GET['workunit_id'] ) ) {
			$workunit_selected_id = (int) $_GET['workunit_id'];
		}

		if ( ! empty( $_POST['workunit_id'] ) ) {
			$workunit_selected_id = (int) $_POST['workunit_id'];
		}

		View_Util::exec( 'navigation', 'list', array( 'display_create_workunit_form' => $display_create_workunit_form, 'workunit_selected_id' => $workunit_selected_id, 'workunits' => $workunits, 'parent_id' => $parent_id ) );
	}
}

new Navigation_Class();
