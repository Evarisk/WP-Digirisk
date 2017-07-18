<?php
/**
 * Ajoutes l'onglet Configuration aux unités de travail
 *
 * @since 6.2.2.0
 * @version 6.2.10.0
 *
 * @package Evarisk\Plugin
 */

if ( ! defined( 'ABSPATH' ) ) { exit; }

/**
 * Ajoutes l'onglet Configuration aux unités de travail
 */
class Workunit_Filter {

	/**
	 * Le constructeur
	 *
	 * @since 6.2.2.0
	 * @version 6.2.2.0
	 */
	public function __construct() {
		add_filter( 'digi_tab', array( $this, 'callback_digi_tab' ), 5, 2 );
	}

	/**
	 * Ajoutes les onglets "Configuration" et "Supprimer" aux unités de travail
	 *
	 * @param  array   $tab_list La liste des filtres.
	 * @param  integer $id L'ID de la société.
	 *
	 * @return array
	 *
	 * @since 6.2.2.0
	 * @version 6.2.10.0
	 */
	function callback_digi_tab( $tab_list, $id ) {
		$tab_list['digi-workunit']['informations'] = array(
			'type' => 'text',
			'text' => __( 'Informations', 'digirisk' ),
			'title' => __( 'Informations de', 'digirisk' ),
		);

		$tab_list['digi-workunit']['more'] = array(
			'type' => 'toggle',
			'text' => '<i class="action fa fa-ellipsis-v toggle"></i>',
			'items' => array(
				'advanced-options' => array(
					'type' => 'text',
					'text' => __( 'Options avancées', 'digirisk' ),
					'title' => __( 'Les options avancées de', 'digirisk' ),
					'nonce' => 'load_content',
					'attributes' => 'data-id=' . $id . '',
				),
				'delete' => array(
					'type' => 'text',
					'text' => __( 'Supprimer', 'digirisk' ),
					'parent_class' => 'action-delete no-tab',
					'action' => 'delete_society',
					'attributes' => 'data-loader=digirisk-wrap data-id=' . $id . '',
					'nonce' => 'delete_society',
				),
			),
		);

		return $tab_list;
	}
}

new Workunit_Filter();
