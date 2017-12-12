<?php
/**
 * Les filtres relatives aux fiches de groupement
 *
 * @author Jimmy Latour <jimmy@evarisk.com>
 * @since 6.2.4
 * @version 6.3.0
 * @copyright 2015-2017 Evarisk
 * @package DigiRisk
 */

namespace digi;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Ajoutes le filtre pour ajouter le bouton dans le contenu des onglets
 */
class Sheet_Groupment_Filter {

	/**
	 * Ajoutes le filtres
	 *
	 * @since 6.2.4
	 * @version 6.2.4
	 */
	public function __construct() {
		add_filter( 'digi_tab', array( $this, 'callback_digi_tab' ), 6, 2 );
	}

	/**
	 * Ajoutes une entrée dans le tableau $list_tab
	 *
	 * @param  array   $list_tab  La liste des filtres.
	 * @param  integer $id        L'ID de la société.
	 * @return array              La liste des filtres + le filtre ajouté par cette méthode.
	 *
	 * @since 6.2.4
	 * @version 6.4.4
	 */
	public function callback_digi_tab( $list_tab, $id ) {
		$list_tab['digi-group']['fiche-de-groupement'] = array(
			'type'  => 'text',
			'text'  => __( 'Fiche ', 'digirisk' ) . Group_Class::g()->element_prefix,
			'title' => __( 'Les fiches de groupement', 'digirisk' ),
		);

		return $list_tab;
	}
}

new Sheet_Groupment_Filter();
