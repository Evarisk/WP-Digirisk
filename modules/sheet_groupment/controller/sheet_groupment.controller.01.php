<?php if ( !defined( 'ABSPATH' ) ) exit;

class sheet_groupment_controller_01 {
  function __construct() {
    /**	Ajoute les onglets pour les unités de travail / Add tabs for workunit	*/
    add_filter( 'wpdigi_group_sheet_tab', array( $this, 'filter_add_sheet_tab_to_element' ), 10, 2 );
    /**	Ajoute le contenu pour les onglets des unités de travail / Add the content for groupment tabs	*/
    add_filter( 'wpdigi_group_sheet_content', array( $this, 'filter_display_risk_in_element' ), 11, 3 );
  }

  /**
   * Filtrage de la définition des onglets dans les fiches d'un élément / Hook filter allowing to extend tabs into an element sheet
   *
   * @param array $tab_list La liste actuelle des onglets à afficher dans la fiche de l'élément / The current tab list to display into element sheet
   *
   * @return array Le tableau des onglets a afficher dans la fiche de l'élément avec les onglets spécifiques ajoutés / The tab array to display into element sheet with specific tabs added
   */
  function filter_add_sheet_tab_to_element( $tab_list, $current_element ) {
    /** Définition de l'onglet permettant l'affichage des risques pour le type d'élément actuel / Define the tab allowing to display risks' tab for current element type	*/
    $tab_list = array_merge( $tab_list, array(
      'sheet-groupment' => array(
        'text'	=> __( 'Generate sheet', 'digirisk' ),
        'class' => 'wp-digi-sheet-generation-button dashicons-before dashicons-share-alt2',
      ),
    )	);

    return $tab_list;
  }

  /**
   * Filtrage de l'affichage des risques dans la fiche d'un élément (unité de travail/groupement/etc) / Filter risks' display into a element sheet
   *
   * @param string $output Le contenu actuel a afficher, contenu que l'on va agrémenter / The current content to update before return and display
   * @param JSon_Object $element L'élément sur le quel on se trouve et pour lequel on veut afficher les risques / Current element we are on and we want to display risks' for
   * @param string $tab_to_display L'onglet sur lequel on se trouve actuellement défini par le filtre principal ( wpdigi-workunit-default-tab ) puis par l'ajax / Current tab we are on defined par main filter ( wpdigi-workunit-default-tab ) and then by ajax
   *
   * @return string Le contenu a afficher pour l'onglet et l'élément actuel / The content to display for current tab and element we are one
   */
  function filter_display_risk_in_element( $output, $element, $tab_to_display ) {
    if ( 'sheet-groupment' == $tab_to_display ) {
      $group_id = $_POST['group_id'];
      global $wpdigi_group_ctr;
      global $document_controller;

      $element = $wpdigi_group_ctr->show( $group_id );
      ob_start();
      $display_mode = "simple";
      require_once( wpdigi_utils::get_template_part( WPDIGI_DOC_DIR, WPDIGI_DOC_TEMPLATES_MAIN_DIR, 'simple', "sheet", "generation-form" ) );
      $document_controller->display_document_list( $element );
      $output = ob_get_clean();
    }

    return $output;
  }
}

new sheet_groupment_controller_01();
