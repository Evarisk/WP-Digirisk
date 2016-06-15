<?php if ( !defined( 'ABSPATH' ) ) exit;

class wpdigi_group_legal_display_ctr {
  public function display( $element ) {
    require( wpdigi_utils::get_template_part( WPDIGI_STES_DIR, WPDIGI_STES_TEMPLATES_MAIN_DIR, 'group/legal_display', 'display' ) );
  }
}

global $wpdigi_group_legal_display_ctr;
$wpdigi_group_legal_display_ctr = new wpdigi_group_legal_display_ctr();
