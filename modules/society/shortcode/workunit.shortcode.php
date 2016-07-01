<?php
/**
* @TODO : A Détailler
*
* @author Jimmy Latour <jimmy.latour@gmail.com>
* @version 0.1
* @copyright 2015-2016 Eoxia
* @package establishment
* @subpackage filter
*/
if ( !defined( 'ABSPATH' ) ) exit;

class workunit_shortcode {
  public function __construct() {
    add_shortcode( 'digi-sheet-workunit', array( $this, 'callback_digi_sheet_workunit' ) );
  }

  /** Affiches le contenu d'un établissement
  * @TODO : Avoir le groupment par défaut
  */
  public function callback_digi_sheet_workunit( $param ) {
		$element_id = (int)$_POST['element_id'];
    $element = society_class::get()->show_by_type( $element_id );
    $display_mode = "simple";
    require_once( wpdigi_utils::get_template_part( WPDIGI_DOC_DIR, WPDIGI_DOC_TEMPLATES_MAIN_DIR, 'simple', "sheet", "generation-form" ) );
    document_class::get()->display_document_list( $element );
  }
}

new workunit_shortcode();
