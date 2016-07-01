<?php if ( !defined( 'ABSPATH' ) ) exit;

class legal_display_class extends post_class {
  protected $model_name   = 'legal_display_mdl_01';
	protected $post_type    = 'digi-legal-display';
	protected $meta_key    	= '_wpdigi_legal_display';

	/**	Défini la route par défaut permettant d'accèder aux sociétés depuis WP Rest API  / Define the default route for accessing to risk from WP Rest API	*/
	protected $base = 'digirisk/legal_display';
	protected $version = '0.1';

	public $element_prefix = 'LD';

  protected function construct() {
    include_once( LEGAL_DISPLAY_PATH . '/model/legal_display.model.01.php' );
  }

  public function display( $element ) {
		$data = $this->load_data( $element->id );
    require( wpdigi_utils::get_template_part( LEGAL_DISPLAY_DIR, LEGAL_DISPLAY_TEMPLATES_MAIN_DIR, 'backend', 'display' ) );
  }

  /**
  * Charges toutes les données du dernier affichage légal
  */
  public function load_data( $element_id ) {
    if ( $element_id === 0 ) {
      return array();
    }

    $data = array( 'legal_display' => array(), 'detective_work' => array(), 'occupational_health_service' => array() );
    $list_legal_display = $this->index( array( 'post_parent' => $element_id ) );

		if ( ( empty( $list_legal_display ) && empty( $legal_display[0] ) ) )
			return array();

		$legal_display = max($list_legal_display);

    $detective_work = third_class::get()->show( $legal_display->option['detective_work_id'] );
    $occupational_health_service = third_class::get()->show( $legal_display->option['occupational_health_service_id'] );

    if ( ( empty( $detective_work ) ) && empty( $occupational_health_service ) )
      return array();

    $data['legal_display'] = $legal_display;
    $data['detective_work'] = $detective_work;
		$data['detective_work']->address = address_class::get()->show( $detective_work->option['contact']['address_id'] );
    $data['occupational_health_service'] = $occupational_health_service;
    $data['occupational_health_service']->address = address_class::get()->show( $occupational_health_service->option['contact']['address_id'] );

    return $data;
  }

  public function save_data( $data ) {
    // @todo : securité

    return $this->create( $data );
  }
}

legal_display_class::get();
