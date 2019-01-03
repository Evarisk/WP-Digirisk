<?php
/**
 * Classe gérant les filtres des fiches de groupement.
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
 * Sheet Groupement Filter class.
 */
class Sheet_Groupment_Filter extends Identifier_Filter {

	/**
	 * Ajoutes le filtres
	 *
	 * @since 6.2.4
	 */
	public function __construct() {
		parent::__construct();

		add_filter( 'digi_tab', array( $this, 'callback_digi_tab' ), 6, 2 );

		add_filter( 'eo_model_sheet_groupment_before_post', array( $this, 'before_save_doc' ), 10, 2 );
		add_filter( 'digi_sheet_groupment_document_data', array( $this, 'callback_digi_document_data' ), 9, 2 );
		add_filter( 'digi_sheet_groupment_document_data', array( Document_Filter::g(), 'fill_header' ), 10, 2 );
		add_filter( 'digi_sheet_groupment_document_data', array( Document_Filter::g(), 'fill_risks' ), 20, 2 );
		add_filter( 'digi_sheet_groupment_document_data', array( Document_Filter::g(), 'fill_evaluators' ), 30, 2 );
		add_filter( 'digi_sheet_groupment_document_data', array( Document_Filter::g(), 'fill_recommendations' ), 40, 2 );
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
		$list_tab['digi-group']['fiche-de-groupement'] = array(
			'type'  => 'text',
			'text'  => __( 'Fiche ', 'digirisk' ) . Group_Class::g()->element_prefix,
			'title' => __( 'Les fiches de groupement', 'digirisk' ),
		);

		return $list_tab;
	}

	/**
	 * Ajoutes le titre du document ainsi que le GUID et le chemin vers celui-ci.
	 *
	 * Cette méthode est appelée avant l'ajout du document en base de donnée.
	 *
	 * @since 7.0.0
	 *
	 * @param  array $data Les données du document.
	 * @param  array $args Les données de la requête.
	 *
	 * @return mixed
	 */
	public function before_save_doc( $data, $args ) {
		$upload_dir = wp_upload_dir();

		$data['title']  = current_time( 'Ymd' ) . '_';
		$data['title'] .= $data['parent']->data['unique_identifier'] . '_fiche_de_groupement_';
		$data['title'] .= sanitize_title( $data['parent']->data['title'] ) . '_';
		$data['title'] .= 'V' . \eoxia\ODT_Class::g()->get_revision( $data['type'], $data['parent']->data['id'] );
		$data['title']  = str_replace( '-', '_', $data['title'] );

		$data['guid'] = $upload_dir['baseurl'] . '/digirisk/' . $data['parent']->data['type'] . '/' . $data['parent']->data['id'] . '/' . sanitize_title( $data['title'] ) . '.odt';
		$data['path'] = $upload_dir['basedir'] . '/digirisk/' . $data['parent']->data['type'] . '/' . $data['parent']->data['id'] . '/' . sanitize_title( $data['title'] ) . '.odt';
		$data['path'] = str_replace( '\\', '/', $data['path'] );

		$data['_wp_attached_file'] = '/digirisk/' . $data['parent']->data['type'] . '/' . $data['parent']->data['id'] . '/' . sanitize_title( $data['title'] ) . '.odt';

		return $data;
	}

	/**
	 * Ajoutes toutes les données nécessaire pour le registre des AT bénins.
	 *
	 * @since 7.0.0
	 *
	 * @param  array $data Les données pour le registre des AT bénins.
	 * @param  array $args Les données supplémentaires pour la génération du document.
	 *
	 * @return array       Les données pour le registre des AT bénins modifié.
	 */
	public function callback_digi_document_data( $data, $args ) {
		$address = Society_Class::g()->get_address( $args['parent'] );

		$data = array(
			'reference'   => $args['parent']->data['unique_identifier'],
			'nom'         => $args['parent']->data['title'],
			'description' => $args['parent']->data['content'],
			'adresse'     => $address->data['address'],
			'telephone'   => ! empty( $args['parent']->data['contact']['phone'] ) ? end( $args['parent']->data['contact']['phone'] ) : '',
			'codePostal'  => $address->data['postcode'],
			'ville'       => $address->data['town'],
		);

		return $data;
	}
}

new Sheet_Groupment_Filter();
