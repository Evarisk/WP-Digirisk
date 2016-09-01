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

class establishment_filter {
  public function __construct() {
		add_filter( 'digi_menu', array( $this, 'callback_digi_menu' ), 10, 2 );

    add_filter( 'wpdigi_establishment_identity', array( $this, 'callback_establishment_identity' ), 10, 2 );
    add_filter( 'wpdigi_establishment_action', array( $this, 'callback_establishment_action' ) );

    add_filter( 'digi_dashboard', array( $this, 'callback_digi_dashboard' ), 10, 2 );
  }

  /**
  * Affiches le menu à gauche de la page
  * Utilises $groupment_selected_id pour choisir le groupement par défaut.
  *
  * @param string $content Le contenu du filtre
  *
  * @author Jimmy Latour <jimmy.latour@gmail.com>
  *
  * @since 6.0.0.0
  */
  public function callback_digi_menu( $content, $groupment_selected_id ) {
    require_once( SOCIETY_VIEW_DIR . 'menu.view.php' );
  }

  /** Affiches l'identité d'un établissement */
  public function callback_establishment_identity( $element, $editable_identity = false ) {
    require( SOCIETY_VIEW_DIR . '/identity.view.php' );
  }

  /** Affiches les actions d'un établissement */
  public function callback_establishment_action( $element ) {
    require( SOCIETY_VIEW_DIR . '/action.view.php' );
  }

  /** Affiches le contenu d'un établissement
  * @TODO : Avoir le groupment par défaut
  */
  public function callback_digi_dashboard( $content, $establishment_selected_id ) {
    $establishment = establishment_class::g()->show_by_type( $establishment_selected_id );
    $object_name_establishment = apply_filters( 'wpdigi_object_name_' . $establishment->type, '' );
    require( SOCIETY_VIEW_DIR . '/content.view.php' );
  }
}

new establishment_filter();
