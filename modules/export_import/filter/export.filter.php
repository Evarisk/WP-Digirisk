<?php namespace digi;

if ( ! defined( 'ABSPATH' ) ) { exit; }
/**
 * Fichier de gestion des filtres pour l'export des données de Digirisk / File managing filters for digirisk datas export
 *
 * @author Alexandre Techer <dev@evarisk.com>
 * @version 6.1.5.5
 * @copyright 2015-2016 Evarisk
 * @package export_import
 * @subpackage filter
 */

/**
 * Classe de gestion des filtres pour l'export des données de Digirisk / Class for managing filters for digirisk datas export
 *
 * @author Alexandre Techer <dev@evarisk.com>
 * @version 6.1.5.5
 * @copyright 2015-2016 Evarisk
 * @package export_import
 * @subpackage filter
 */
class export_filter {

	/**
	 * Constructeur pour l'instanciation des filtres pour les exports / Constructor for export's filters instanciation
	 */
	public function __construct() {
		// add_filter( 'digi_tab', array( $this, 'callback_digi_tab' ), 15 );
	}

	/**
	 * Fonction de rappel pour l'affichage de l'onglet d'export dans un élément / Callback function for tab allowing to export display
	 *
	 * @param  array $list_tab La liste des onglets déjà existant à laquelle il va falloir ajouter les nouveaux onglets / Current tab list where to add new tabs
	 *
	 * @return array La liste des onglets avec les nouveaux onglets / The new tab list with new tabs adding
	 */
	function callback_digi_tab( $list_tab ) {
		$list_tab['digi-group']['export'] = array(
			'type' => 'text',
 			'text' => __( 'Export', 'digirisk' ),
 		);

		$list_tab['digi-workunit']['export'] = array(
			'type' => 'text',
 			'text' => __( 'Export', 'digirisk' ),
 		);

		return $list_tab;
	}

}

/** Instanciation des filtres pour les exports / Instanciate export's filters */
new export_filter();
