<?php
/**
 * Gestion des filtres relatifs aux groupements
 *
 * @author Jimmy Latour <jimmy@evarisk.com>
 * @since 6.2.10
 * @version 6.3.0
 * @copyright 2015-2017 Evarisk
 * @package DigiRisk
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Gestion des filtres relatifs aux groupements
 */
class Group_Filter {

	/**
	 * Utilises le filtre digi_tab
	 *
	 * @since 6.2.10
	 * @version 6.2.10
	 */
	public function __construct() {
		add_filter( 'digi_tab', array( $this, 'callback_digi_tab' ), 4, 2 );
	}

	/**
	 * Ajoutes l'onglet configuration et suppression dans les groupements.
	 *
	 * @param  array   $tab_list Les onglets déjà présents.
	 * @param  integer $id       L'ID de la société.
	 * @return array             Les onglets déjà présents et ceux ajoutés par cette méthode.
	 *
	 * @since 6.2.10
	 * @version 6.3.0
	 */
	function callback_digi_tab( $tab_list, $id ) {
		$tab_list['digi-group']['informations'] = array(
			'type' => 'text',
			'text' => __( 'Informations', 'digirisk' ),
			'title' => __( 'Informations', 'digirisk' ),
		);

		$tab_list['digi-group']['more'] = array(
			'type' => 'toggle',
			'text' => '<i class="action fa fa-ellipsis-v toggle"></i>',
			'items' => array(
				'delete' => array(
					'type' => 'text',
					'text' => __( 'Supprimer', 'digirisk' ),
					'parent_class' => 'action-delete no-tab',
					'action' => 'delete_society',
					'attributes' => 'data-loader=digirisk-wrap data-id=' . $id . ' data-message-delete=' . __( 'Confirmer', 'digirisk' ),
					'nonce' => 'delete_society',
				),
			),
		);

		return $tab_list;
	}
}

new Group_Filter();
