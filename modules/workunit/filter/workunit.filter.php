<?php
/**
 * Ajoutes l'onglet Configuration aux unités de travail
 *
 * @since 6.2.2.0
 * @version 6.2.3.0
 *
 * @package Evarisk\Plugin
 */

if ( ! defined( 'ABSPATH' ) ) { exit; }

/**
 * Ajoutes l'onglet Configuration aux unités de travail
 */
class Workunit_Filter {

	/**
	 * Le constructeur
	 *
	 * @since 6.2.2.0
	 * @version 6.2.2.0
	 */
	public function __construct() {
		add_filter( 'digi_tab', array( $this, 'callback_digi_tab' ), 2, 2 );
	}

	/**
	 * Ajotues l'onglet Configuration aux unités de travail
	 *
	 * @since 6.2.2.0
	 * @version 6.2.3.0
	 *
	 * @param  array $tab_list La liste des filtres.
	 *
	 * @return array
	 */
	function callback_digi_tab( $tab_list, $id ) {
		$tab_list['digi-workunit']['more']['configuration'] = array(
			'text' => __( 'Configuration', 'digirisk' ),
		);

		$tab_list['digi-workunit']['more']['delete'] = array(
			'text' => __( 'Supprimer', 'digirisk' ),
		);

		return $tab_list;
	}
}

new Workunit_Filter();
