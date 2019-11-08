<?php
/**
 * Gestion de la page 'organiseur'
 *
 * @author Evarisk <dev@evarisk.com>
 * @since 6.0.0
 * @version 6.4.5
 * @copyright 2015-2017 Evarisk
 * @package DigiRisk
 */

namespace digi;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Gestion de la page 'organiseur'
 */
class Page_Sorter_Class extends \eoxia\Singleton_Util {

	/**
	 * Le constructeur
	 */
	protected function construct() {}

	/**
	 * La méthode qui permet d'afficher la page
	 *
	 * @since 6.0.0
	 */
	public function display() {
		$main_society = Society_Class::g()->get( array(
			'posts_per_page' => 1,
		), true );

		$establishments = Society_Class::g()->get( array(
			'post_parent'    => $main_society->data['id'],
			'posts_per_page' => -1,
			'post_type'      => array( 'digi-group', 'digi-workunit' ),
			'post_status'    => array( 'publish', 'draft', 'inherit' ),
			'orderby'        => array( 'menu_order' => 'ASC', 'meta_value_num' => 'ASC' ),
			'meta_key'       => '_wpdigi_unique_key',
		) );

		if ( ! empty( $establishments ) ) {
			foreach ( $establishments as $establishment ) {
				$establishment->data['count_workunit'] = count( Workunit_Class::g()->get( array(
					'post_parent'    => $establishment->data['id'],
					'posts_per_page' => -1,
				) ) );
			}
		}

		$display_notice = get_transient( 'display_notice' );

		\eoxia\View_Util::exec( 'digirisk', 'page_sorter', 'main', array(
			'main_society'   => $main_society,
			'display_notice' => $display_notice,
			'establishments' => $establishments,
		) );
	}

	/**
	 * Charges les groupements selon le parent_id et les envoies à la vue page_sorter/list.view.php
	 *
	 * @since 6.0.0
	 *
	 * @param  integer $i                    La clé qui permet de gérer le niveau des blocs.
	 * @param  integer $parent_id (optional) L'ID du groupement parent.
	 */
	public function display_list( $i, $parent_id = 0 ) {

		$establishments = Society_Class::g()->get( array(
			'post_parent'    => $parent_id,
			'posts_per_page' => -1,
			'post_type'      => array( 'digi-group', 'digi-workunit' ),
			'post_status'    => array( 'publish', 'draft', 'inherit' ),
			'orderby'        => array( 'menu_order' => 'ASC', 'meta_value_num' => 'ASC' ),
			'meta_key'       => '_wpdigi_unique_key',
		) );

		if ( ! empty( $establishments ) ) {
			foreach ( $establishments as $establishment ) {
				$establishment->data['count_workunit'] = count( Workunit_Class::g()->get( array(
					'post_parent'    => $establishment->data['id'],
					'posts_per_page' => -1,
				) ) );
			}
		}

		\eoxia\View_Util::exec( 'digirisk', 'page_sorter', 'list', array(
			'i'              => $i,
			'establishments' => $establishments,
		) );
	}
}

new Page_Sorter_Class();
