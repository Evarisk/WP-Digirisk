<?php if ( !defined( 'ABSPATH' ) ) exit;

class address_class extends comment_class {

	protected $model_name   = 'address_model';

	protected $comment_type  = 'digi-address';

	protected $meta_key    	= '_wpdigi_address';

	protected $base = 'address';
	protected $version = '0.1';

	/**
	 * Instanciation de l'objet addresse / Address instanciation
	 */
	protected function construct() {}

	/**
	* Créer une addresse
	*
	* @param array $data (test: [postcode => 34130, address => 10 avenue yyy, town => Montpellier]) Les données a sauvegarder dans l'addresse
	*
	* @return object The address_model object
	*/
	public function save( $data ) {
		return $this->update( $data );
	}
}
