<?php
/**
 * Les filtres relatives au listing des risques
 *
 * @author Evarisk <dev@evarisk.com>
 * @since 6.5.0
 * @version 6.5.0
 * @copyright 2015-2018 Evarisk
 * @package DigiRisk
 */

namespace digi;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Les filtres relatives au linsting des risques
 */
class Listing_Risk_Filter {

	/**
	 * Le constructeur ajoute le filtre society_header_end
	 *
	 * @since 6.5.0
	 * @version 6.5.0
	 */
	public function __construct() {
		add_filter( 'digi_tab', array( $this, 'callback_digi_listing_risk' ), 8, 2 );
	}


	/**
	 * Ajoutes une entrée dans le tableau $list_tab pour les groupements
	 *
	 * @param  array   $list_tab  La liste des filtres.
	 * @param  integer $id        L'ID de la société.
	 * @return array              La liste des filtres + le filtre ajouté par cette méthode.
	 *
	 * @since 6.5.0
	 * @version 6.5.0
	 */
	public function callback_digi_listing_risk( $list_tab, $id ) {
		$list_tab['digi-group']['listing-risk'] = array(
			'type'  => 'text',
			'text'  => __( 'Listing des risques ', 'digirisk' ),
			'title' => __( 'Listing des risques', 'digirisk' ),
		);

		return $list_tab;
	}
}

new Listing_Risk_Filter();
