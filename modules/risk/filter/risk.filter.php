<?php
/**
 * Les filtres relatifs aux risques
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
 * Les filtres relatifs aux risques
 */
class Risk_Filter {

	/**
	 * Le constructeur
	 */
	public function __construct() {
		add_filter( 'digi_tab', array( $this, 'callback_tab' ), 1, 2 );
	}

	/**
	 * Ajoutes l'onglet risque aux groupements et aux unités de travail
	 *
	 * @param  array   $list_tab La liste des filtres.
	 * @param  integer $id L'ID de la société.
	 *
	 * @return array
	 *
	 * @since 6.2.2
	 * @version 6.3.0
	 */
	public function callback_tab( $list_tab, $id ) {
		$list_tab['digi-group']['risk'] = array(
			'type' => 'text',
			'text' => __( 'Risques', 'digirisk' ),
			'title' => __( 'Les risques', 'digirisk' ),
		);

		$list_tab['digi-workunit']['risk'] = array(
			'type' => 'text',
			'text' => __( 'Risques', 'digirisk' ),
			'title' => __( 'Les risques', 'digirisk' ),
		);

		return $list_tab;
	}
}

new Risk_Filter();
