<?php
/**
 * Gestion des actions relatif à la recherche
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
 * Gestion des actions des champs de recherche.
 */
class Search_Action {

	/**
	 * Le constructeur
	 */
	function __construct() {
		add_action( 'wp_ajax_digi_search', array( $this, 'callback_digi_search' ) );
	}

	/**
	 * Appelle la méthode search de Search_Class pour récupérer la liste selon le critère $_GET['type']
	 * Si next_action est défini, appelle l'action pour gérer une action différente.
	 *
	 * @return void
	 *
	 * @since 1.0
	 * @version 6.2.4.0
	 */
	public function callback_digi_search() {
		$list = Search_Class::g()->search( $_GET );

		if ( ! empty( $_GET['next_action'] ) ) {
			do_action( $_GET['next_action'], $_GET['id'], $list );
		}

		$return = array();

		foreach ( $list as $element ) {
			$user = User_Class::g()->get( array( 'include' => array( $element ) ) );
			$user = $user[0];
			$return[] = array(
				'label' => $user->login . ' (' . $user->email . ')',
				'value' => $user->login,
				'id'		=> $user->id,
			);
		}

		wp_die( wp_json_encode( $return ) );
	}
}

new Search_Action();
