<?php
/**
 * Classe gérant la navigation
 *
 * @author Evarisk <dev@evarisk.com>
 * @since 6.2.3
 * @version 7.0.0
 * @copyright 2015-2018 Evarisk
 * @package DigiRisk
 */

namespace digi;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Appelle la vue permettant d'afficher la navigation
 */
class Navigation_Class extends \eoxia\Singleton_Util {

	/**
	 * Le constructeur
	 *
	 * @since 6.0.0
	 * @version 6.2.4
	 */
	protected function construct() {}

	/**
	 * La méthode qui permet d'afficher la navigation.
	 *
	 * @since 6.0.0
	 * @version 7.0.0
	 *
	 * @param integer $selected_society_id L'ID du groupement à envoyer à la vue navigation/view/main.view.php.
	 * @return void
	 */
	public function display( $selected_society_id ) {
		$society = Society_Class::g()->get( array(
			'posts_per_page' => 1,
		), true );

		$societies = Society_Class::g()->get_societies_in( $society->data['id'] );

		\eoxia\View_Util::exec( 'digirisk', 'navigation', 'main', array(
			'selected_society_id' => $selected_society_id,
			'societies'           => $societies,
			'society'             => $society,
		) );
	}

	/**
	 * Charges le groupement sélectionné et l'envoie à la vue navigation/toggle/button.view.php avec comme nom de variable $groupment
	 *
	 * @since 6.0.0
	 * @version 7.0.0
	 *
	 * @param integer $id (optional)                  L'ID de la société parent.
	 * @param integer $selected_society_id (optional) L'ID de la société selectionné.
	 * @param string  $class (optianal)               La classe utilisé pour la vue.
	 *
	 * @return void
	 */
	public function display_list( $id = 0, $selected_society_id = 0, $class = 'sub-list' ) {
		if ( ! empty( $id ) ) {
			$societies = Society_Class::g()->get_societies_in( $id );

			\eoxia\View_Util::exec( 'digirisk', 'navigation', 'list', array(
				'id'                  => $id,
				'selected_society_id' => $selected_society_id,
				'societies'           => $societies,
				'class'               => $class,
			) );
		}
	}

	/**
	 * Charges les groupements selon le parent_id et les envoies à la vue navigation/toggle/list.view.php
	 *
	 * @since 6.0.0
	 * @version 7.0.0
	 *
	 * @param  integer $selected_groupment_id L'ID du groupement sélectionné.
	 * @param  integer $parent_id (optional) 	L'ID du groupement parent.
	 *
	 * @return void
	 */
	public function display_toggle_list( $selected_groupment_id, $parent_id = 0 ) {
		$groupments = Group_Class::g()->get(
			array(
				'posts_per_page' => -1,
				'post_parent'    => $parent_id,
				'post_status'    => array( 'publish', 'draft' ),
				'orderby'        => array( 'menu_order' => 'ASC', 'meta_value_num' => 'ASC' ),
				'meta_key'       => '_wpdigi_unique_key',
			)
		);

		if ( !empty( $groupments ) ) {
			foreach ( $groupments as $groupment ) {
				$groupment->count_workunit = count( Workunit_Class::g()->get( array(
					'post_parent' => $groupment->id,
					'posts_per_page' => -1,
				) ) );
			}
		}

		\eoxia\View_Util::exec( 'digirisk', 'navigation', 'toggle/list', array(
			'selected_groupment_id' => $selected_groupment_id,
			'groupments' => $groupments,
		) );
	}
}

new Navigation_Class();
