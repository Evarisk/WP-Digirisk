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
class Permis_Feu_Start_Filter {

	/**
	 * Ajoutes le filtres
	 *
	 * @since 6.2.4
	 */
	public function __construct() {
		add_action( 'digi_permis_feu_search_prevention', array( $this, 'change_search_result' ), 10, 1 );
	}

	public function change_search_result( $args ) {
		ob_start();
		\eoxia\View_Util::exec( 'digirisk', 'permis_feu', 'start/change-search-result', array(
			'results' => $args['users'],
			'term'    => $args['term'],
		) );

		wp_send_json_success( array(
			'view' => ob_get_clean(),
		) );
	}
}

new Permis_Feu_Start_Filter();
