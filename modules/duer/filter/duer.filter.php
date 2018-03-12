<?php
/**
 * Les filtres relatives au DUER
 *
 * @author Jimmy Latour <jimmy@evarisk.com>
 * @since 6.2.5
 * @version 6.4.4
 * @copyright 2015-2017 Evarisk
 * @package DigiRisk
 */

namespace digi;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Les filtres relatives au DUER
 */
class DUER_Filter {

	/**
	 * Le constructeur ajoute le filtre society_header_end
	 *
	 * @since 6.2.5
	 * @version 6.4.4
	 */
	public function __construct() {
		add_filter( 'digi_tab', array( $this, 'callback_digi_tab' ), 5, 2 );
	}

	/**
	 * Ajoutes une entrée dans le tableau $list_tab pour la société.
	 *
	 * @param  array   $list_tab  La liste des filtres.
	 * @param  integer $id        L'ID de la société.
	 * @return array              La liste des filtres + le filtre ajouté par cette méthode.
	 *
	 * @since 6.4.4
	 * @version 6.4.4
	 */
	public function callback_digi_tab( $list_tab, $id ) {
		$list_tab['digi-society']['list-duer'] = array(
			'type'  => 'text',
			'text'  => __( 'DUER ', 'digirisk' ),
			'title' => __( 'DUER', 'digirisk' ),
		);

		return $list_tab;
	}
}

new DUER_Filter();
