<?php if ( !defined( 'ABSPATH' ) ) exit;

class legal_display_ctr extends post_ctr_01 {
  protected $model_name   = 'legal_display_mdl_01';
	protected $post_type    = 'digi-legal-display';
	protected $meta_key    	= '_wpdigi_legal_display';

	/**	Défini la route par défaut permettant d'accèder aux sociétés depuis WP Rest API  / Define the default route for accessing to risk from WP Rest API	*/
	protected $base = 'digirisk/legal_display';
	protected $version = '0.1';

	public $element_prefix = 'LD';

  public function __construct() {
    parent::__construct();
    include_once( LEGAL_DISPLAY_PATH . '/model/legal_display.model.01.php' );

    add_action( 'admin_enqueue_scripts', array( &$this, 'admin_assets' ) );

    /**	Ajoute les onglets pour les unités de travail / Add tabs for workunit	*/
		add_filter( 'wpdigi_group_sheet_tab', array( $this, 'filter_add_sheet_tab_to_element' ), 6, 2 );
		/**	Ajoute le contenu pour les onglets des unités de travail / Add the content for workunit tabs	*/
		add_filter( 'wpdigi_group_sheet_content', array( $this, 'filter_display_generate_document_unique_in_element' ), 10, 3 );
  }

  /**
	 * Déclaration des scripts et styles / Enqueue scripts and styles
	 *
	 * @uses wp_register_style
	 * @uses wp_enqueue_style
	 * @uses wp_enqueue_script
	 */
	public function admin_assets() {
		wp_enqueue_script( 'legal-display.backend.js', LEGAL_DISPLAY_URL . 'asset/js/legal_display.backend.js', array( 'jquery', 'jquery-form' ), LEGAL_DISPLAY_VERSION, false );

	}

  public function display( $element ) {
    require( wpdigi_utils::get_template_part( LEGAL_DISPLAY_DIR, LEGAL_DISPLAY_TEMPLATES_MAIN_DIR, 'backend', 'display' ) );
  }

  function filter_add_sheet_tab_to_element( $tab_list, $current_element ) {
    /** Définition de l'onglet permettant l'affichage des utilisateurs pour le type d'élément actuel / Define the tab allowing to display evaluators' tab for current element type	*/
    $tab_list = array_merge( $tab_list, array(
      'legal-display' => array(
      'text' => __( 'Legal display', 'wpdigi-i18n' ),
      'count' => 0,
      )
    ) );

    return $tab_list;
  }

  function filter_display_generate_document_unique_in_element( $output, $element, $tab_to_display ) {
    if( 'legal-display' == $tab_to_display ) {
      ob_start();
      $this->display( $element );
      $output .= ob_get_clean();
    }

    return $output;
  }

  public function save_data( $data ) {
    // @todo : securité

    return $this->create( $data );
  }
}

global $legal_display_ctr;
$legal_display_ctr = new legal_display_ctr();
