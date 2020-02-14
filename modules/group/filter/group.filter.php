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
		add_filter( 'digi_tab', array( $this, 'callback_digi_tab_statistics' ), 8, 2 );
		add_filter( 'digi_tab', array( $this, 'callback_digi_tab_more' ), 9, 2 );
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
			'icon'  => '<i class="fas fa-info-circle"></i>',
		);

		return $tab_list;
	}

	/**
	 * Ajoutes l'onglet "Statistiques" dans les groupements.
	 *
	 * @param  array   $tab_list Les onglets déjà présents.
	 * @param  integer $id       L'ID de la société.
	 * @return array             Les onglets déjà présents et ceux ajoutés par cette méthode.
	 *
	 * @since 7.5.3
	 * @version 7.5.3
	 */
	public function callback_digi_tab_statistics( $tab_list, $id ) {
		$tab_list['digi-group']['statistic'] = array(
			'type'  => 'text',
			'text'  => __( 'Statistiques', 'digirisk' ),
			'title' => __( 'Les statistiques', 'digirisk' ),
			'icon'  => '<i class="fas fa-chart-bar"></i>',
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
			'text'  => '<i class="action fas fa-ellipsis-v toggle"></i>',
			'items' => array(
				'delete' => array(
					'type'         => 'text',
					'text'         => __( 'Supprimer', 'digirisk' ),
					'parent_class' => 'action-delete no-tab',
					'action'       => 'delete_society',
					'attributes'   => 'data-loader=digirisk-wrap data-id=' . $id . ' data-message-delete="' . __( 'Êtes-vous sûr(e) de vouloir supprimer ce groupement ?', 'digirisk' ) . '"',
					'nonce'        => 'delete_society',
				),
			),
		);

		return $tab_list;
	}

}

new Group_Filter();
