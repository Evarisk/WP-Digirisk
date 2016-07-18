<?php if ( !defined( 'ABSPATH' ) ) exit;

class address_class extends comment_class {

	protected $model_name   = 'wpdigi_address_mdl_01';

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
	* @param array $data (test: [postcode => 34130, address => 10 rue du clavier, town => Montpellier]) Les données a sauvegarder dans l'addresse
	*
	* @return object The address_model object
	*/
	public function save_data( $data ) {
		if ( !is_array( $data ) ) {
			return false;
		}

		$data['postcode'] = sanitize_text_field( $data['postcode'] );
		$data['address'] = sanitize_text_field( $data['address'] );
		$data['town'] = sanitize_text_field( $data['town'] );

		return $this->create( $data );
	}
}
