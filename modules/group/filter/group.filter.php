<?php
/**
 * Gestion des filtres relatifs aux groupements
 *
 * @author Evarisk <dev@evarisk.com>
 * @since 6.2.10
 * @version 7.0.0
 * @copyright 2015-2018 Evarisk
 * @package DigiRisk
 */

namespace digi;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Gestion des filtres relatifs aux groupements
 */
class Group_Filter extends Identifier_Filter {

	/**
	 * Utilises le filtre digi_tab
	 *
	 * @since 6.2.10
	 * @version 7.0.0
	 */
	public function __construct() {
		parent::__construct();

		add_filter( 'digi_tab', array( $this, 'callback_digi_tab_informations' ), 5, 2 );
		add_filter( 'digi_tab', array( $this, 'callback_digi_tab_more' ), 8, 2 );
	}

	/**
	 * Ajoutes l'onglet "Informations" dans les groupements.
	 *
	 * @param  array   $tab_list Les onglets déjà présents.
	 * @param  integer $id       L'ID de la société.
	 * @return array             Les onglets déjà présents et ceux ajoutés par cette méthode.
	 *
	 * @since 6.2.10
	 * @version 6.4.4
	 */
	public function callback_digi_tab_informations( $tab_list, $id ) {
		$tab_list['digi-group']['informations'] = array(
			'type'  => 'text',
			'text'  => __( 'Informations', 'digirisk' ),
			'title' => __( 'Informations', 'digirisk' ),
		);

		return $tab_list;
	}

	/**
	 * Ajoutes l'onglet "Informations" dans les groupements.
	 *
	 * @param  array   $tab_list Les onglets déjà présents.
	 * @param  integer $id       L'ID de la société.
	 * @return array             Les onglets déjà présents et ceux ajoutés par cette méthode.
	 *
	 * @since 6.4.4
	 * @version 6.4.4
	 */
	public function callback_digi_tab_more( $tab_list, $id ) {
		$tab_list['digi-group']['more'] = array(
			'type'  => 'toggle',
			'text'  => '<i class="action far fa-ellipsis-v toggle"></i>',
			'items' => array(
				'delete' => array(
					'type'         => 'text',
					'text'         => __( 'Supprimer', 'digirisk' ),
					'parent_class' => 'action-delete no-tab',
					'action'       => 'delete_society',
					'attributes'   => 'data-loader=digirisk-wrap data-id=' . $id . ' data-message-delete=' . __( 'Confirmer', 'digirisk' ),
					'nonce'        => 'delete_society',
				),
			),
		);

		return $tab_list;
	}

}

new Group_Filter();
