<?php
/**
 * Gestion des filtres relatifs aux évaluateurs
 *
 * @author Evarisk <dev@evarisk.com>
 * @since 6.0.0
 * @version 6.3.0
 * @copyright 2015-2017 Evarisk
 * @package DigiRisk
 */

namespace digi;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

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

		add_filter( 'eo_model_user_after_get', array( $this, 'callback_after_get' ), 10, 2 );
	}

	/**
	 * Ajoutes l'onglet évaluateur dans les groupements et les unités de travail
	 *
	 * @param  array   $list_tab Les onglets déjà présents.
	 * @param  integer $id       L'ID de la société.
	 * @return array             Les onglets déjà présents et ceux ajoutés par cette méthode.
	 *
	 * @since 6.0.0
	 * @version 6.3.0
	 */
	public function callback_tab( $list_tab, $id ) {
		$list_tab['digi-group']['evaluator'] = array(
			'type' => 'text',
			'text' => __( 'Évaluateurs', 'digirisk' ),
			'title' => __( 'Les évaluateurs', 'digirisk' ),
		);

		$list_tab['digi-workunit']['evaluator'] = array(
			'type' => 'text',
			'text' => __( 'Évaluateurs', 'digirisk' ),
			'title' => __( 'Les évaluateurs', 'digirisk' ),
		);

		return $list_tab;
	}

	public function callback_after_get( $object, $args ) {
		$object->data['avatar_color'] = '50a1ed';
		return $object;
	}
}

new Evaluator_Filter();
