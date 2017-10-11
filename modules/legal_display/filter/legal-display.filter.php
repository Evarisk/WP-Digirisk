<?php
/**
 * Gestion des filtres relatifs aux affichages légaux
 *
 * @author Jimmy Latour <jimmy@evarisk.com>
 * @since 6.0.0
 * @version 6.3.0
 * @copyright 2015-2017 Evarisk
 * @package DigiRisk
 */

namespace digi;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Gestion des filtres relatifs aux affichages légaux
 */
class Legal_Display_Filter {

	/**
	 * Utilises le filtre digi_tab
	 */
	public function __construct() {
		add_filter( 'digi_tab', array( $this, 'callback_tab' ), 3, 2 );
	}

	/**
	 * Ajoutes l'onglet affichage légal dans les groupements.
	 *
	 * @since 6.0.0
	 * @version 6.3.0
	 *
	 * @param  array   $list_tab Les onglets déjà présents.
	 * @param  integer $id       L'ID de la société.
	 * @return array             Les onglets déjà présents et ceux ajoutés par cette méthode.
	 */
	public function callback_tab( $list_tab, $id ) {
		$list_tab['digi-society']['legal_display'] = array(
			'type' => 'text',
			'text' => __( 'Affichage légal', 'digirisk' ),
			'title' => __( 'Les affichages légales', 'digirisk' ),
		);
		return $list_tab;
	}
}

new Legal_Display_Filter();
