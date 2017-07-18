<?php
/**
 * Les filtres relatifs aux utilisateurs
 *
 * @author Jimmy Latour <jimmy@evarisk.com>
 * @since 0.1
 * @version 6.2.10.0
 * @copyright 2015-2017 Evarisk
 * @package recommendation
 * @subpackage filter
 */

namespace digi;

if ( ! defined( 'ABSPATH' ) ) { exit; }

/**
 * Les filtres relatifs aux utilisateurs
 */
class Recommendation_Filter {

	/**
	 * Le constructeur ajoute le filtre digi_tab
	 *
	 * @since 0.1
	 * @version 6.2.4.0
	 */
	public function __construct() {
		add_filter( 'digi_tab', array( $this, 'callback_tab' ), 4, 2 );
	}

	/**
	 * Ajoutes l'onglet "Recommendations" dans les unités de travail.
	 *
	 * @param  array   $list_tab  La liste des onglets.
	 * @param  integer $id        L'ID de la société.
	 * @return array              La liste des onglets et ceux ajoutés par cette méthode.
	 *
	 * @since 0.1
	 * @version 6.2.10.0
	 */
	public function callback_tab( $list_tab, $id ) {
		$list_tab['digi-workunit']['recommendation'] = array(
			'type' => 'text',
			'text' => __( 'Signalisations', 'digirisk' ),
			'title' => __( 'Les signalisations de', 'digirisk' ),
		);

		$list_tab['digi-group']['recommendation'] = array(
			'type' => 'text',
			'text' => __( 'Signalisations', 'digirisk' ),
			'title' => __( 'Les signalisations de', 'digirisk' ),
		);

		return $list_tab;
	}
}

new Recommendation_Filter();
