<?php

namespace digi\transfert;

if ( !defined( 'ABSPATH' ) ) exit;

class TransferData_class extends \singleton_util {

	/**
	 * Déclaration de la correspondance entre les anciens types Evarisk et les nouveaux types dans wordpress / Declare an array for making correspondance between evarisk old types and wordpress new type
	 * @var array Correspondance between Evarisk types and wordpress types for element transfer
	 */
	public $post_type = array(
// 		TABLE_TACHE => 'wpeo-tasks',
// 		TABLE_ACTIVITE => 'comments',

		TABLE_GROUPEMENT => WPDIGI_STES_POSTTYPE_MAIN,
		TABLE_UNITE_TRAVAIL => WPDIGI_STES_POSTTYPE_SUB,
	);

	/**
	 * Déclaration des types principaux à transférer / Declare an array with main element to transfer
	 * @var array
	 */
	public $element_type = array(
// 		TABLE_TACHE,
		TABLE_GROUPEMENT,
	);

	protected function construct() {}

	function get_transfer_progression( $main_element_type, $sub_element_type ) {
		global $wpdb;
		$count = array();

		/**	Get the number of element that will be transfered for the given element type	*/
		$query = $wpdb->prepare( "SELECT
			(
				SELECT COUNT( DISTINCT( id ) )
				FROM {$main_element_type}
				WHERE id != 1
			) AS main_element_nb,
			(
				SELECT COUNT( DISTINCT( id ) )
				FROM {$sub_element_type}
			) AS sub_element_nb,
			(
				SELECT COUNT( DISTINCT( id ) )
				FROM " . TABLE_PHOTO_LIAISON . "
				WHERE tableElement IN ( %s, %s )
			) AS nb_picture,
			(
				SELECT COUNT( DISTINCT( id ) )
				FROM " . TABLE_GED_DOCUMENTS . "
				WHERE table_element IN ( %s, %s )
			) AS nb_document,
			(
				SELECT COUNT( DISTINCT( id ) )
				FROM " . TABLE_FP . "
				WHERE table_element  IN ( %s, %s )
			) AS nb_fiches,
			(
				SELECT COUNT( DISTINCT( id ) )
				FROM " . TABLE_DUER . "
				WHERE element IN ( %s, %s )
			) AS nb_duer", array( $main_element_type, $sub_element_type, $main_element_type, $sub_element_type, $main_element_type, $sub_element_type, $main_element_type, $sub_element_type, ) );

		/**	Get the element number from database	*/
		$nb_element_to_transfert = $wpdb->get_row( $query );

		/**	Get option with already transfered element	*/
		$digirisk_transfert_options = get_option( '_wpdigirisk-dtransfert', array() );

		$count = array(
			'to_transfer' => $nb_element_to_transfert,
			'transfered' => $digirisk_transfert_options,
		);

		return $count;
	}

}

TransferData_class::g();
