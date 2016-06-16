<?php if ( !defined( 'ABSPATH' ) ) exit;

class opening_time_shortcode_01 {

  public function __construct() {
    add_shortcode( 'di_opening_time', array( $this, 'callback_di_opening_time' ) );
  }

  public function callback_di_opening_time( $params ) {
    $name = $params['name'];

    $list_day = array(
      "Mo" => __( 'Monday', 'wpdigi-i18n' ),
      "Tu" => __( 'Tuesday', 'wpdigi-i18n' ),
      "We" => __( 'Wednesday', 'wpdigi-i18n' ),
      "Th" => __( 'Thrusday', 'wpdigi-i18n' ),
      "Fr" => __( 'Friday', 'wpdigi-i18n' ),
      "Sa" => __( 'Saturday', 'wpdigi-i18n' ),
      "Su" => __( 'Sunday', 'wpdigi-i18n' ),
    );
    require( wpdigi_utils::get_template_part( OPENING_TIME_DIR, OPENING_TIME_TEMPLATES_MAIN_DIR, '', 'opening_time.view' ) );
  }
}

global $opening_time_shortcode;
$opening_time_shortcode = new opening_time_shortcode_01();
