<?php
/**
 * Gestion des filtres relatifs aux causerie de sécurité.
 *
 * @author Jimmy Latour <jimmy@evarisk.com>
 * @since 6.5.0
 * @version 6.5.0
 * @copyright 2015-2017 Evarisk
 * @package DigiRisk
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Gestion des filtres relatifs aux causerie de sécurité.
 */
class Causerie_Filter {

	/**
	 * Utilises le filtre digi_tab
	 *
	 * @since 6.5.0
	 * @version 6.5.0
	 */
	public function __construct() {
		add_filter( 'digi_tab', array( $this, 'callback_tab' ), 3, 2 );
	}

	/**
	 * Ajoutes l'onglet accident dans les groupements et les unités de travail
	 *
	 * @since 6.5.0
	 * @version 6.5.0
	 *
	 * @param  array   $list_tab Les onglets déjà présents.
	 * @param  integer $id       L'ID de la société.
	 * @return array             Les onglets déjà présents et ceux ajoutés par cette méthode.
	 */
	public function callback_tab( $list_tab, $id ) {
		$list_tab['digi-group']['causerie'] = array(
			'type' => 'text',
			'text' => __( 'Causerie sécurité', 'digirisk' ),
			'title' => __( 'Les causeries sécurité', 'digirisk' ),
		);

		return $list_tab;
	}
}

new Causerie_Filter();
