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

class tab_filter {
  public function __construct() {
    add_filter( 'wpdigi_establishment_tab_content', array( $this, 'callback_tab_content' ), 10, 3 );
  }

  /**
  * Appelles le contenu d'un établissement
  *
  * @author Jimmy Latour <jimmy.latour@gmail.com>
  *
  * @since 6.0.0.0
  *
  * @param string $tab_to_display Le nom de l'onglet pour le contenu à afficher.
  */
  public function callback_tab_content( $content, $element, $tab_to_display ) {
    require( TAB_VIEW_DIR . 'content.view.php' );
  }
}

new tab_filter();
