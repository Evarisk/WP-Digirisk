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
class Sheet_Groupment_Filter {

	/**
	 * Ajoutes le filtres
	 *
	 * @see add_filter
	 */
	public function __construct() {
		add_filter( 'digi_tab', array( $this, 'callback_digi_tab' ), 16, 1 );
	}

	/**
	 * Ajoutes une entrée dans le tableau $list_tab
	 *
	 * @param  array $list_tab  La liste des filtres.
	 * @return array            La liste des filtres + le filtre ajouté par cette méthode.
	 */
	public function callback_digi_tab( $list_tab ) {
		$list_tab['digi-group']['fiche-de-groupement'] = array(
			'text' => __( 'Sheet groupment', 'digirisk' ),
			'class' => 'wp-digi-sheet-generation-button dashicons-before dashicons-share-alt2',
		);

		return $list_tab;
	}
}

new Sheet_Groupment_Filter();
