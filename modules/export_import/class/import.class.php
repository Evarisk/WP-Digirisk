<?php if ( !defined( 'ABSPATH' ) ) exit;
/**
* Fichier de gestion des actions pour le tableau de bord de Digirisk / File for managing Digirisk dashboard
*
* @author Alexandre Techer <dev@evarisk.com>
* @since 6.1.5.5
* @copyright 2015-2016 Evarisk
* @package Digirisk\dashboard
* @subpackage class
*/

/**
* Classe de gestion des actions pour les exports et imports des données de Digirisk / Class for managing export and import for Digirisk datas
*
* @author Alexandre Techer <dev@evarisk.com>
* @since 6.1.5.5
* @copyright 2015-2016 Evarisk
* @package Digirisk\dashboard
* @subpackage class
*/
class import_class extends singleton_util {

	/**
	 * Constructeur de la classe. Doit être présent même si vide pour coller à la définition "abstract" des parents / Class constructor. Must be present even if empty for matchin with "abstract" definition of ancestors
	 */
	function construct() {}

	public function create( $data ) {
		if ( !empty( $data ) ) {
			$this->create_groupment( $data );
		}
	}

	public function create_groupment( $data ) {
	  foreach ( $data as $groupment_json ) {
			$groupment = group_class::g()->update( $groupment_json );

			if ( !empty( $groupment_json['list_workunit'] ) ) {
			  foreach ( $groupment_json['list_workunit'] as $workunit_json ) {
					$this->create_workunit( $groupment, $workunit_json );
			  }
			}
	  }
	}

	public function create_workunit( $groupment, $workunit_json ) {
		$workunit_json['parent_id'] = $groupment->id;
		$workunit = workunit_class::g()->update( $workunit_json );

		if ( !empty( $workunit_json['list_risk'] ) ) {
		  foreach ( $workunit_json['list_risk'] as $risk_json ) {
				$this->create_risk( $workunit, $risk_json );
		  }
		}
	}

	public function create_risk( $society, $risk_json ) {
		$risk_json['parent_id'] = $society->id;
		$risk = risk_class::g()->update( $risk_json );
	}
}
