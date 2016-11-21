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
			), array( 'list_group', 'list_workunit' )
		);

		$display_notice = get_transient( 'display_notice' );

		view_util::exec( 'page_sorter', 'main', array( 'display_notice' => $display_notice, 'groupments' => $groupments ) );
	}
}

new Page_Sorter_Class();
