<?php namespace digi;
/**
* @TODO : A Détailler
*
* @author Jimmy Latour <jimmy@evarisk.com>
* @version 0.1
* @copyright 2015-2016 Eoxia
* @package establishment
* @subpackage filter
*/
if ( !defined( 'ABSPATH' ) ) exit;

class workunit_shortcode {
	/**
	* Le constructeur
	*/
  public function __construct() {
		add_shortcode( 'wpdigi-workunit-list', array( &$this, 'shortcode_workunit_list' ) );
    add_shortcode( 'digi-sheet-workunit', array( $this, 'callback_digi_sheet_workunit' ) );
  }

	/**
	 * Affiche la liste des groupements existant sous forme de liste déroulante si il en existe plusieurs / Display a dropdown with all groups if there are several existing
	 *
	 * @param array $args Les paramètres passés au travers du shortcode / Parameters list passed thrgough shortcode
	 *
	 * @return string Le code html permettant d'afficher la liste déroulante contenant les groupements existant / The HTML code allowing to display existing groups
	 */
	public function shortcode_workunit_list( $args ) {
		$output = '';

		/**	Get existing workunit for display	*/
		$list = workunit_class::g()->get_workunit_of_group( $args[ 'group_id' ] );

		/**	Define a nonce for display sheet using ajax	*/
		$workunit_display_nonce = wp_create_nonce( 'wpdigi_workunit_sheet_display' );

		/**	Affichage de la liste des unités de travail pour le groupement actuellement sélectionné / Display the work unit list for current selected group	*/
		$path = wpdigi_utils::get_template_part( WPDIGI_STES_DIR, WPDIGI_STES_TEMPLATES_MAIN_DIR, 'workunit', 'list' );

		if ( $path ) {
			ob_start();
			require_once( wpdigi_utils::get_template_part( WPDIGI_STES_DIR, WPDIGI_STES_TEMPLATES_MAIN_DIR, 'workunit', 'list' ) );
			$output = ob_get_contents();
			ob_end_clean();
		}

		return  $output;
	}

  /**
	* Affiches le contenu d'un établissement
	*
  * @param array $param
  */
  public function callback_digi_sheet_workunit( $param ) {
		$element_id = (int)$_POST['element_id'];
    $element = society_class::g()->show_by_type( $element_id );
		view_util::exec( 'workunit', 'sheet-generation-form', array( 'element' => $element ) );
    document_class::g()->display_document_list( $element );
  }
}

new workunit_shortcode();
