<?php
/**
 * Classe gérant les filtres des fiches de poste.
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
 * Sheet Workunit Filter class.
 */
class Sheet_Workunit_Filter extends Identifier_Filter {

	/**
	 * Ajoutes le filtres
	 *
	 * @since 6.2.4
	 */
	public function __construct() {
		parent::__construct();

		add_filter( 'digi_tab', array( $this, 'callback_digi_tab' ), 6, 2 );

		add_filter( 'digi_sheet_workunit_document_data', array( $this, 'callback_digi_document_data' ), 10, 2 );
		add_filter( 'digi_sheet_workunit_document_data', array( Document_Filter::g(), 'fill_header' ), 10, 2 );
		add_filter( 'digi_sheet_workunit_document_data', array( Document_Filter::g(), 'fill_risks' ), 20, 2 );
		add_filter( 'digi_sheet_workunit_document_data', array( Document_Filter::g(), 'fill_evaluators' ), 30, 2 );
		add_filter( 'digi_sheet_workunit_document_data', array( Document_Filter::g(), 'fill_recommendations' ), 40, 2 );
	}

	/**
	 * Ajoutes une entrée dans le tableau $list_tab
	 *
	 * @param  array   $list_tab  La liste des filtres.
	 * @param  integer $id        L'ID de la société.
	 * @return array              La liste des filtres + le filtre ajouté par cette méthode.
	 *
	 * @since 6.2.4
	 */
	public function callback_digi_tab( $list_tab, $id ) {
		$list_tab['digi-workunit']['fiche-de-poste'] = array(
			'type'  => 'text',
			'text'  => __( 'Fiche ', 'digirisk' ) . Workunit_Class::g()->element_prefix,
			'title' => __( 'Les fiches de poste', 'digirisk' ),
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
		$address = Society_Class::g()->get_address( $society );

		$data = array(
			'reference'   => $society->data['unique_identifier'],
			'nom'         => $society->data['title'],
			'description' => $society->data['content'],
			'adresse'     => $address->data['address'],
			'telephone'   => ! empty( $society->data['contact']['phone'] ) ? end( $society->data['contact']['phone'] ) : '',
			'codePostal'  => $address->data['postcode'],
			'ville'       => $address->data['town'],
		);

		return $data;
	}
}

new Sheet_Workunit_Filter();
