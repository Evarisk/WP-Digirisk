<?php
/**
 * Affichages de la page pour trier les sociétées
 *
 * @package Evarisk\Plugin
 */

namespace digi;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Ajoutes la page pour trier les sociétées
 */
class Page_Sorter_Class extends Singleton_Util {

	/**
	 * Le constructeur
	 */
	protected function construct() {}

	/**
	 * La méthode qui permet d'afficher la page
	 *
	 * @return void
	 */
	public function display() {
		$groupments = group_class::g()->get(
			array(
				'posts_per_page' => -1,
				'post_parent' => 0,
				'post_status' => array( 'publish', 'draft' ),
				'orderby' => array( 'menu_order' => 'ASC', 'date' => 'ASC' ),
			)
		);

		if ( ! empty( $groupments ) ) {
			foreach ( $groupments as $groupment ) {
				$groupment->count_workunit = count( workunit_class::g()->get( array( 'post_parent' => $groupment->id, 'posts_per_page' => -1 ) ) );
			}
		}

		$display_notice = get_transient( 'display_notice' );

		view_util::exec( 'page_sorter', 'main', array( 'display_notice' => $display_notice, 'groupments' => $groupments ) );
	}

	/**
	 * Charges les groupements selon le parent_id et les envoies à la vue page_sorter/list.view.php
	 *
	 * @param  integer $i La clé qui permet de gérer le niveau des blocs.
	 * @param  integer $parent_id (optional) 	L'ID du groupement parent.
	 * @return void
	 */
	public function display_list( $i, $parent_id = 0 ) {
		$groupments = group_class::g()->get(
			array(
				'posts_per_page' => -1,
				'post_parent' => $parent_id,
				'post_status' => array( 'publish', 'draft' ),
				'orderby' => array( 'menu_order' => 'ASC', 'date' => 'ASC' ),
			)
		);

		if ( ! empty( $groupments ) ) {
			foreach ( $groupments as $groupment ) {
				$groupment->count_workunit = count( workunit_class::g()->get( array( 'post_parent' => $groupment->id, 'posts_per_page' => -1 ) ) );
			}
		}

		view_util::exec( 'page_sorter', 'list', array( 'i' => $i, 'groupments' => $groupments ) );
	}
}

new Page_Sorter_Class();
