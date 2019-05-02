<?php
/**
 * Gestion des filtres relatifs aux unités de travail.
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
 * Ajoutes l'onglet Configuration aux unités de travail
 */
class Workunit_Filter extends Identifier_Filter {

	/**
	 * Le constructeur
	 *
	 * @since 6.2.2
	 */
	public function __construct() {
		parent::__construct();

		add_filter( 'digi_tab', array( $this, 'callback_digi_tab_informations' ), 5, 2 );
		add_filter( 'digi_tab', array( $this, 'callback_digi_tab_more' ), 7, 2 );
	}

	/**
	 * Ajoutes les onglets "Informations" aux unités de travail
	 *
	 * @param  array   $tab_list La liste des filtres.
	 * @param  integer $id L'ID de la société.
	 *
	 * @return array
	 *
	 * @since 6.2.2
	 */
	public function callback_digi_tab_informations( $tab_list, $id ) {
		$tab_list['digi-workunit']['informations'] = array(
			'type'  => 'text',
			'text'  => __( 'Informations', 'digirisk' ),
			'title' => __( 'Informations ', 'digirisk' ),
		);

		return $tab_list;
	}

	/**
	 * Ajoutes l'onglet "Plus" aux unités de travail
	 *
	 * @param  array   $tab_list La liste des filtres.
	 * @param  integer $id L'ID de la société.
	 *
	 * @return array
	 *
	 * @since 6.4.4
	 */
	public function callback_digi_tab_more( $tab_list, $id ) {
		$tab_list['digi-workunit']['more'] = array(
			'type'  => 'toggle',
			'text'  => '<i class="action fas fa-ellipsis-v toggle"></i>',
			'items' => array(
				'delete' => array(
					'type'         => 'text',
					'text'         => __( 'Supprimer', 'digirisk' ),
					'parent_class' => 'action-delete no-tab',
					'action'       => 'delete_society',
					'attributes'   => 'data-loader=digirisk-wrap data-id=' . $id . ' data-message-delete="' . __( 'Êtes-vous sûr(e) de vouloir supprimer cette unité de travail ?', 'digirisk' ) . '"',
					'nonce'        => 'delete_society',
				),
			),
		);

		return $tab_list;
	}
}

new Workunit_Filter();
