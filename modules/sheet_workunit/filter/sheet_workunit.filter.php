<?php
/**
 * Les filtres relatifs aux fiches de poste
 *
 * @author Jimmy Latour <jimmy@evarisk.com>
 * @since 0.1
 * @version 6.2.4.0
 * @copyright 2015-2017 Evarisk
 * @package sheet_workunit
 * @subpackage filter
 */

namespace digi;

if ( ! defined( 'ABSPATH' ) ) { exit; }

/**
 * Les filtres relatifs aux fiches de poste
 */
class Sheet_Workunit_Filter {

	/**
	 * Ajoutes le filtre "digi_tab"
	 *
	 * @since 0.1
	 * @version 6.2.4.0
	 */
	public function __construct() {
		add_filter( 'digi_tab', array( $this, 'callback_digi_tab' ), 6, 2 );
	}

	/**
	 * Ajoutes l'onglet "Fiche de poste"" aux unités de travail
	 *
	 * @since 6.2.2.0
	 * @version 6.2.4.0
	 *
	 * @param  array   $list_tab La liste des filtres.
	 * @param  integer $id L'ID de la société.
	 *
	 * @return array
	 */
	public function callback_digi_tab( $list_tab, $id ) {
		$list_tab['digi-workunit']['fiche-de-poste'] = array(
			'type' => 'text',
			'text' => __( 'Fiche de poste', 'digirisk' ),
			'class' => 'wp-digi-sheet-generation-button dashicons-before dashicons-share-alt2',
		);

		return $list_tab;
	}
}

new Sheet_Workunit_Filter();
