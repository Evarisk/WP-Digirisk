<?php if ( !defined( 'ABSPATH' ) ) exit;

class third_class_01 extends post_ctr_01 {
  protected $model_name   = 'third_mdl_01';
	protected $post_type    = 'third-display';
	protected $meta_key    	= 'third_display';

	/**	Défini la route par défaut permettant d'accèder aux sociétés depuis WP Rest API  / Define the default route for accessing to risk from WP Rest API	*/
	protected $base = 'digirisk/third';
	protected $version = '0.1';

	public $element_prefix = 'T';

  public function __construct() {
    parent::__construct();
    include_once( THIRD_PATH . '/model/third.model.01.php' );
  }

  public function save_data( $data ) {
    // @todo : Sécurité
    if ( empty( $data ) || empty( $data['full_name' ] ) || empty( $data['contact']['phone'] ) || empty( $data['contact']['address_id'] ) ) {
      return false;
    }

    return $this->create( $data );
  }
}

global $third_class;
$third_class = new third_class_01();
