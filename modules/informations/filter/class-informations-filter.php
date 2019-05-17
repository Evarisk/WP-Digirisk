<?php
/**
 * Les filtres pour les sociétés
 *
 * @author Evarisk <dev@evarisk.com>
 * @since 6.2.2
 * @version 7.0.0
 * @copyright 2015-2018 Evarisk
 * @package DigiRisk
 */

namespace digi;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Les filtres pour les sociétés
 */
class Informations_Filter {

	/**
	 * Le constructeur
	 *
	 * @since 6.2.2
	 * @version 7.0.0
	 */
	public function __construct() {
		add_filter( 'digi_tab', array( $this, 'callback_tab' ), 1, 2 );
	}

	/**
	 * Ajoutes l'onglet "Informations" à la société.
	 *
	 * @since 6.3.0
	 * @version 7.0.0
	 *
	 * @param  array   $tab_list La liste des filtres.
	 * @param  integer $id L'ID de la société.
	 * @return array
	 */
	public function callback_tab( $tab_list, $id ) {
		$tab_list['digi-society']['informations'] = array(
			'type'  => 'text',
			'text'  => __( 'Informations', 'digirisk' ),
			'title' => __( 'Informations', 'digirisk' ),
		);

		return $tab_list;
	}
}

new Informations_Filter();
