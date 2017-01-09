<?php
/**
 * Ajoutes l'onglet Configuration aux unités de travail
 *
 * @since 6.2.2.0
 * @version 6.2.4.0
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
	 * Ajoutes l'onglet Configuration aux unités de travail
	 *
	 * @since 6.2.2.0
	 * @version 6.2.4.0
	 *
	 * @param  array   $tab_list La liste des filtres.
	 * @param  integer $id L'ID de la société.
	 *
	 * @return array
	 */
	function callback_digi_tab( $tab_list, $id ) {
		$tab_list['digi-workunit']['more']['configuration'] = array(
			'type' => 'text',
			'text' => __( 'Configuration', 'digirisk' ),
		);

		$tab_list['digi-workunit']['more']['delete'] = array(
			'type' => 'text',
			'text' => __( 'Supprimer', 'digirisk' ),
		);

		return $tab_list;
	}
}

new Workunit_Filter();
