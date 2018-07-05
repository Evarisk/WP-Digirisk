<?php
/**
 * Les filtres relatives aux fiches de groupement
 *
 * @author Jimmy Latour <jimmy@evarisk.com>
 * @since 6.2.4
 * @version 6.3.0
 * @copyright 2015-2017 Evarisk
 * @package DigiRisk
 */

namespace digi;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Ajoutes le filtre pour ajouter le bouton dans le contenu des onglets
 */
class Sheet_Groupment_Filter extends Identifier_Filter {

	/**
	 * Ajoutes le filtres
	 *
	 * @since 6.2.4
	 * @version 6.2.4
	 */
	public function __construct() {
		parent::__construct();

		add_filter( 'digi_tab', array( $this, 'callback_digi_tab' ), 6, 2 );

		add_filter( 'digi_sheet_groupment_document_data', array( $this, 'callback_digi_document_data' ), 10, 2 );
	}

	/**
	 * Ajoutes une entrée dans le tableau $list_tab
	 *
	 * @param  array   $list_tab  La liste des filtres.
	 * @param  integer $id        L'ID de la société.
	 * @return array              La liste des filtres + le filtre ajouté par cette méthode.
	 *
	 * @since 6.2.4
	 * @version 6.4.4
	 */
	public function callback_digi_tab( $list_tab, $id ) {
		$list_tab['digi-group']['fiche-de-groupement'] = array(
			'type'  => 'text',
			'text'  => __( 'Fiche ', 'digirisk' ) . Group_Class::g()->element_prefix,
			'title' => __( 'Les fiches de groupement', 'digirisk' ),
		);

		return $list_tab;
	}

	/**
	 * Ajoutes toutes les données nécessaire pour le registre des AT bénins.
	 *
	 * @since 7.0.0
	 *
	 * @param  array         $data    Les données pour le registre des AT bénins.
	 * @param  Society_Model $society Les données de la société.
	 *
	 * @return array                  Les données pour le registre des AT bénins modifié.
	 */
	public function callback_digi_document_data( $data, $society ) {
		$society_infos = Society_Class::g()->get_address( $society );

		$data = array(
			'reference'   => $society->data['unique_identifier'],
			'nom'         => $society->data['title'],
			'description' => $society->data['content'],
			'adresse'     => $society_infos['adresse'],
			'telephone'   => ! empty( $society->data['contact']['phone'] ) ? end( $society->data['contact']['phone'] ) : '',
			'codePostal'  => $society_infos['codePostal'],
			'ville'       => $society_infos['ville'],
		);

		return $data;
	}
}

new Sheet_Groupment_Filter();
