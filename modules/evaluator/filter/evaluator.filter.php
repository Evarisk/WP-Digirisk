<?php
/**
 * Gestion des filtres relatifs aux évaluateurs
 *
 * @author Jimmy Latour <jimmy@evarisk.com>
 * @since 0.1
 * @version 6.2.5.0
 * @copyright 2015-2017 Evarisk
 * @package evaluator
 * @subpackage filter
 */

namespace digi;

if ( ! defined( 'ABSPATH' ) ) { exit; }

/**
 * Gestion des filtres relatifs aux évaluateurs
 */
class Evaluator_Filter {

	/**
	 * Utilises le filtre digi_tab
	 *
	 * @since 0.1
	 * @version 6.2.5.0
	 */
	public function __construct() {
		add_filter( 'digi_tab', array( $this, 'callback_tab' ), 2, 2 );
	}

	/**
	 * Ajoutes l'onglet évaluateur dans les groupements et les unités de travail
	 *
	 * @param  array   $list_tab Les onglets déjà présents.
	 * @param  integer $id       L'ID de la société.
	 * @return array             Les onglets déjà présents et ceux ajoutés par cette méthode.
	 *
	 * @since 1.0
	 * @version 6.2.5.0
	 */
	public function callback_tab( $list_tab, $id ) {
		$list_tab['digi-group']['evaluator'] = array(
			'type' => 'text',
			'text' => __( 'Évaluateurs', 'digirisk' ),
			'title' => __( 'Les évaluateurs de', 'digirisk' ),
		);

		$list_tab['digi-workunit']['evaluator'] = array(
			'type' => 'text',
			'text' => __( 'Évaluateurs', 'digirisk' ),
			'title' => __( 'Les évaluateurs de', 'digirisk' ),
		);

		return $list_tab;
	}
}

new Evaluator_Filter();
