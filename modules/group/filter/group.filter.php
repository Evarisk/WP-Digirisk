<?php
/**
 * Gestion des filtres relatifs aux groupements
 *
 * @author Jimmy Latour <jimmy@evarisk.com>
 * @since 0.1
 * @version 6.2.3.0
 * @copyright 2015-2017 Evarisk
 * @package group
 * @subpackage filter
 */

if ( ! defined( 'ABSPATH' ) ) { exit; }

/**
 * Gestion des filtres relatifs aux groupements
 */
class Group_Filter {

	/**
	 * Utilises le filtre digi_tab
	 */
	public function __construct() {
		add_filter( 'digi_tab', array( $this, 'callback_digi_tab' ), 10, 2 );
	}

	/**
	 * Ajoutes l'onglet configuration et suppression dans les groupements.
	 *
	 * @param  array   $tab_list Les onglets déjà présents.
	 * @param  integer $id       L'ID de la société.
	 * @return array             Les onglets déjà présents et ceux ajoutés par cette méthode.
	 */
	function callback_digi_tab( $tab_list, $id ) {
		$tab_list['digi-group']['more'] = array(
			'type' => 'toggle',
			'text' => '<i class="action fa fa-ellipsis-v toggle"></i>',
			'configuration' => array(
				'type' => 'text',
				'text' => __( 'Configuration', 'digirisk' ),
			),
			'delete' => array(
				'type' => 'text',
				'text' => __( 'Supprimer', 'digirisk' ),
				'class' => 'action-delete',
				'attributes' => 'data-action=delete_society data-id=' . $id . '',
				'nonce' => wp_create_nonce( 'delete_society' ),
			),
		);

		return $tab_list;
	}
}

new Group_Filter();
