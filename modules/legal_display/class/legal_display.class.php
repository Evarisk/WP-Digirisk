<?php if ( !defined( 'ABSPATH' ) ) exit;

class legal_display_class extends post_class {
  protected $model_name = 'legal_display_model';
	protected $post_type  = 'digi-legal-display';
	protected $meta_key   = '_wpdigi_legal_display';
	protected $base 			= 'digirisk/legal_display';
	protected $version 		= '0.1';
	protected $before_post_function = array( 'construct_identifier' );
	protected $after_get_function = array( 'get_identifier' );

	public $element_prefix = 'LD';

	/**
	* Le constructeur
	*/
  protected function construct() {}

	/**
	* Récupères les données de l'affichage légal en base de donnée et affiches le template du formulaire
	*
	* @param object $element L'objet groupement
	*/
  public function display( $element ) {
		$legal_display = $this->get( array( 'post_parent' => $element->id ) );

		if ( empty( $legal_display ) ) {
			$legal_display = $this->get( array( 'id' => 0 ) );
		}

		$legal_display = $legal_display[0];

    require( wpdigi_utils::get_template_part( LEGAL_DISPLAY_DIR, LEGAL_DISPLAY_TEMPLATES_MAIN_DIR, 'backend', 'display' ) );
  }

  /**
  * Charges toutes les données du dernier affichage légal
	*
	* @param int $element_id L'ID du groupement
	*
	* @return array Les données chargées
  */
  public function load_data( $element_id ) {
		// $l = $this->get( array( 'post_parent' => $element_id ) );
		// echo "<pre>"; print_r($l); echo "</pre>";
		// echo $l[0];
		// exit(0);
		//
		//
    // $data = array( 'legal_display' => array(), 'detective_work' => array(), 'occupational_health_service' => array() );
		//
    // $list_legal_display = $this->get( array( 'post_parent' => $element_id ) );
		//
		// $legal_display = !empty( $list_legal_display ) ? max($list_legal_display) : $this->get( array( 'id' => 0 ) );
		//
		// $detective_work_id = !empty( $legal_display->option['detective_work_id'] ) ? $legal_display->option['detective_work_id'] : 0;
    // $detective_work = third_class::g()->get( array( 'id' => $detective_work_id ) );
		//
		// $occupational_health_service_id = !empty( $legal_display->option['occupational_health_service_id'] ) ? $legal_display->option['occupational_health_service_id'] : 0;
    // $occupational_health_service = third_class::g()->get( array( 'id' => $occupational_health_service_id ) );
		//
    // $data['legal_display'] = $legal_display[0];
		//
    // $data['detective_work'] = $detective_work[0];
		// $detective_work_address_id = !empty( $detective_work->option['contact']['address_id'] ) ? $detective_work->option['contact']['address_id'] : 0;
		// $data['detective_work']->address = address_class::g()->get( array( 'id' => $detective_work_address_id ) );
		//
    // $data['occupational_health_service'] = $occupational_health_service[0];
		// $occupational_health_service_address_id = !empty( $occupational_health_service->option['contact']['address_id'] ) ? $occupational_health_service->option['contact']['address_id'] : 0;
    // $data['occupational_health_service']->address = address_class::g()->get( array( 'id' => $occupational_health_service_address_id ) );
    // return $data;
  }

	/**
	* Sauvegardes les données de l'affichage légal en base de donnée
	*
	* @param array $data Les données à sauvegarder
	*
	* @return object L'objet sauvé: affichage légal
	*/
  public function save_data( $data ) {
    // @todo : securité

    return $this->create( $data );
  }
}

legal_display_class::g();
