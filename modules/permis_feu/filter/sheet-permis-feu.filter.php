<?php
/**
 * Classe gérant les filtres des fiches de groupement.
 *
 * @author    Evarisk <dev@evarisk.com>
 * @copyright (c) 2006-2018 Evarisk <dev@evarisk.com>.
 *
 * @license   AGPLv3 <https://spdx.org/licenses/AGPL-3.0-or-later.html>
 *
 * @package   DigiRisk\Classes
 *
 * @since     6.2.4
 */

namespace digi;

defined( 'ABSPATH' ) || exit;

/**
 * Sheet Groupement Filter class.
 */
class Sheet_Permis_Feu_Filter extends Identifier_Filter {

	/**
	 * Ajoutes le filtres
	 *
	 * @since 6.2.4
	 */
	public function __construct() {
		parent::__construct();

		// add_filter( 'eo_model_sheet-prevention_before_post', array( $this, 'before_save_doc' ), 10, 2 );
		// add_filter( 'digi_sheet-prevention_document_data', array( $this, 'callback_digi_document_data' ), 9, 2 );
	}

}

new Sheet_Permis_Feu_Filter();
