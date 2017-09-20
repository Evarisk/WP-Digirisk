<?php
/**
 * Gestion des filtres relatifs aux accidents
 *
 * @author Jimmy Latour <jimmy@evarisk.com>
 * @since 6.0.0
 * @version 6.3.0
 * @copyright 2015-2017 Evarisk
 * @package DigiRisk
 * @subpackage filter
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Gestion des filtres relatifs aux accidents
 */
class Accident_Filter {

	/**
	 * Utilises le filtre digi_tab
	 */
	public function __construct() {
		add_filter( 'digi_tab', array( $this, 'callback_tab' ), 2, 2 );
	}

	/**
	 * Ajoutes l'onglet accident dans les groupements et les unités de travail
	 *
	 * @param  array   $list_tab Les onglets déjà présents.
	 * @param  integer $id       L'ID de la société.
	 * @return array             Les onglets déjà présents et ceux ajoutés par cette méthode.
	 */
	public function callback_tab( $list_tab, $id ) {
		$list_tab['digi-society']['registre-accident'] = array(
			'type' => 'text',
			'text' => __( 'Registre accidents', 'digirisk' ),
			'title' => __( 'Les registres des accidents de travail bénins de ', 'digirisk' ),
		);

		return $list_tab;
	}
}

new Accident_Filter();
