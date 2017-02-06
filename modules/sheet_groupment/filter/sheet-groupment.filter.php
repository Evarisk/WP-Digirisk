<?php
/**
 * Les filtres relatives aux fiches de groupement
 *
 * @author Jimmy Latour <jimmy@evarisk.com>
 * @since 1.0
 * @version 6.2.4.0
 * @copyright 2015-2017 Evarisk
 * @package sheet_groupment
 * @subpackage filter
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
	 *
	 * @since 1.0
	 * @version 6.2.4.0
	 */
	public function __construct() {
		add_filter( 'digi_tab', array( $this, 'callback_digi_tab' ), 5, 2 );
	}

	/**
	 * Ajoutes une entrée dans le tableau $list_tab
	 *
	 * @param  array   $list_tab  La liste des filtres.
	 * @param  integer $id        L'ID de la société.
	 * @return array              La liste des filtres + le filtre ajouté par cette méthode.
	 *
	 * @since 1.0
	 * @version 6.2.5.0
	 */
	public function callback_digi_tab( $list_tab, $id ) {
		$list_tab['digi-group']['fiche-de-groupement'] = array(
			'type' => 'text',
			'text' => __( 'Fiche ', 'digirisk' ) . Group_Class::g()->element_prefix,
			'title' => __( 'Les fiches de groupement de', 'digirisk' ),
			'parent_class' => 'gp button red uppercase',
		);

		return $list_tab;
	}
}

new Sheet_Groupment_Filter();
