<?php
/**
 * Ajoutes le filtre pour ajouter le bouton dans le contenu des onglets
 *
 * @package Evarisk\Plugin
 */

namespace digi;

if ( ! defined( 'ABSPATH' ) ) { exit; }

/**
 * Ajoutes le filtre pour ajouter le bouton dans le contenu des onglets
 */
class Sheet_Workunit_Filter {

	/**
	 * Ajoutes le filtres
	 *
	 * @see add_filter
	 */
	public function __construct() {
		add_filter( 'digi_tab', array( $this, 'callback_digi_tab' ), 16, 2 );
	}

	/**
	 * Ajoutes une entrée dans le tableau $list_tab
	 *
	 * @param  array $list_tab  La liste des filtres.
	 * @return array            La liste des filtres + le filtre ajouté par cette méthode.
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
