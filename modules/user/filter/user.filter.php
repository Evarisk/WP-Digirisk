<?php
/**
 * Les filtres relatives aux utilisateurs
 *
 * @author Jimmy Latour <jimmy@evarisk.com>
 * @since 0.1
 * @version 6.2.5.0
 * @copyright 2015-2017 Evarisk
 * @package user
 * @subpackage filter
 */

namespace digi;

if ( ! defined( 'ABSPATH' ) ) { exit; }

/**
 * Les filtres relatives aux utilisateurs
 */
class User_Filter {

	/**
	 * Le constructeur ajoute le filtre digi_tab
	 *
	 * @since 0.1
	 * @version 6.2.4.0
	 */
	public function __construct() {
		add_filter( 'digi_tab', array( $this, 'callback_tab' ), 3, 2 );
	}

	/**
	 * Ajoutes l'onglet "Utilisateurs" dans les unités de travail.
	 *
	 * @param  array   $list_tab  La liste des onglets.
	 * @param  integer $id        L'ID de la société.
	 * @return array              La liste des onglets et ceux ajoutés par cette méthode.
	 *
	 * @since 0.1
	 * @version 6.2.5.0
	 */
	public function callback_tab( $list_tab, $id ) {
		// $list_tab['digi-workunit']['user'] = array(
		// 	'type' => 'text',
		// 	'text' => __( 'Utilisateurs', 'digirisk' ),
		// 	'title' => __( 'Les utilisateurs de', 'digirisk' ),
		// );

		return $list_tab;
	}
}

new User_Filter();
