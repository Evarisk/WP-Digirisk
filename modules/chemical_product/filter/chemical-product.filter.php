<?php
/**
 * Gestion des filtres relatifs aux produits chimiques
 *
 * @author Jimmy Latour <jimmy@evarisk.com>
 * @since 0.1
 * @version 6.2.3.0
 * @copyright 2015-2017 Evarisk
 * @package chemical_product
 * @subpackage filter
 */

if ( ! defined( 'ABSPATH' ) ) { exit; }

/**
 * Gestion des filtres relatifs aux produits chimiques
 */
class Chemical_Product_Filter {

	/**
	 * Utilises le filtre digi_tab
	 */
	public function __construct() {
		add_filter( 'digi_tab', array( $this, 'callback_tab' ), 10, 2 );
	}

	/**
	 * Ajoutes l'onglet produit chimique dans les groupements et les unités de travail
	 *
	 * @param  array   $list_tab Les onglets déjà présents.
	 * @param  integer $id       L'ID de la société.
	 * @return array             Les onglets déjà présents et ceux ajoutés par cette méthode.
	 */
	public function callback_tab( $list_tab, $id ) {
		$list_tab['digi-workunit']['chemical-product'] = array(
			'type' => 'text',
			'text' => __( 'Produit chimique', 'digirisk' ),
		);
		$list_tab['digi-group']['chemical-product'] = array(
			'type' => 'text',
			'text' => __( 'Produit chimique', 'digirisk' ),
		);

		return $list_tab;
	}
}

new Chemical_Product_Filter();
