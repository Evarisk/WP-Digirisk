<?php
/**
* @TODO : A Détailler
*
* @author Jimmy Latour <jimmy.latour@gmail.com>
* @version 0.1
* @copyright 2015-2016 Eoxia
* @package document
* @subpackage filter
*/

if ( !defined( 'ABSPATH' ) ) exit;

class document_filter {
	public function __construct() {
		add_filter( 'wpdigi_society_tree_footer', array( $this, 'filter_display_group_sheet_print_button' ), 10, 2 );
	}

	/**
	 * Accrochage au filtre permettant d'ajouter des éléments d'affichages dans la partie gauche de l'écran sous la liste des unités de travail / Hook filter allowing to extend left part of screen below workunit list
	 *
	 * @param int $group_id l'identifiant du groupement pour lequel il faut afficher la page de génération du document unique / The group identifier we have to display the DUER print interface
	 * @param string $display_mode Le mode d'affichage de l'interface / The main display mode of digirisk interface
	 */
	public function filter_display_group_sheet_print_button( $group_id, $display_mode ) {
		require( wpdigi_utils::get_template_part( WPDIGI_DOC_DIR, WPDIGI_DOC_TEMPLATES_MAIN_DIR, $display_mode, "print", "button" ) );
	}
}

new document_filter();
