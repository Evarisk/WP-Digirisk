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

class society_shortcode {
  public function __construct() {
    add_shortcode( 'digi_dashboard', array( $this, 'callback_digi_dashboard' ) );
  }

  /** Affiches le contenu d'un établissement
  * @TODO : Avoir le groupment par défaut
  */
  public function callback_digi_dashboard( $param ) {
		$id = $param['id'];
    $element = society_class::get()->show_by_type( $id );
		$tab_to_display = !empty( $param['tab_to_display'] ) ? $param['tab_to_display'] : 'digi-risk';
    require( SOCIETY_VIEW_DIR . '/content.view.php' );
  }
}

new society_shortcode();
