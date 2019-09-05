<?php
/**
 * Gestion des filtres relatifs aux types de travaux
 *
 * @author Evarisk <dev@evarisk.com>
 * @since 7.3.3
 * @version 7.3.3
 * @copyright 2019 Evarisk
 * @package DigiRisk
 */

namespace digi;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Ajoutes l'onglet Configuration aux unités de travail
 */
class Worktype_Filter extends Identifier_Filter {

	/**
	 * Le constructeur
	 *
	 * @since 6.2.2
	 */
	public function __construct() {
		parent::__construct();

		// add_filter( 'digi_tab', array( $this, 'callback_digi_tab_informations' ), 5, 2 );
		// add_filter( 'digi_tab', array( $this, 'callback_digi_tab_more' ), 7, 2 );
	}

}

new Worktype_Filter();
