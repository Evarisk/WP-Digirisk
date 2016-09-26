<?php
/**
* @TODO : A Détailler
*
* @author Jimmy Latour <jimmy.latour@gmail.com>
* @version 0.1
* @copyright 2015-2016 Eoxia
* @package chemical_product
* @subpackage filter
*/

if ( !defined( 'ABSPATH' ) ) exit;

class chemical_product_filter {
	public function __construct() {
		add_filter( 'digi_tab', array( $this, 'callback_tab' ) );
	}

	public function callback_tab( $list_tab ) {
		$list_tab['digi-workunit']['chemical-product'] = array(
			'text' => __( 'Produit chimique', 'digirisk' ),
		);
		$list_tab['digi-group']['chemical-product'] = array(
			'text' => __( 'Produit chimique', 'digirisk' ),
		);

		return $list_tab;
	}
}

new chemical_product_filter();
