<?php namespace digi;

if ( !defined( 'ABSPATH' ) ) exit;

class danger_class extends term_class {

	protected $model_name   = '\digi\danger_model';

	protected $taxonomy    	= 'digi-danger';

	protected $meta_key    	= '_wpdigi_danger';

	protected $base = 'digirisk/danger';
	protected $version = '0.1';

	protected $before_post_function = array( '\digi\construct_identifier' );
	protected $after_get_function = array( '\digi\get_identifier' );
	public $element_prefix = 'D';

	/**
	 * Le constructeur
	 */
	protected function construct() {
		add_filter( 'json_endpoints', array( $this, 'callback_register_route' ) );
	}

	/**
	* Récupères le nom du danger par rapport à son ID
	*
	* @param int $danger_id L'ID du danger
	*
	* @return string Le nom du danger
	*/
	public function get_name_by_id( $danger_id ) {
		if (  true !== is_int( ( int )$danger_id ) )
			return false;

		$term = get_term_field( 'name', $danger_id, $this->taxonomy );

		return $term;
	}

	/**
	* Récupères le term parent selon l'ID du danger enfant
	*
	* @param int $danger_id L'ID du danger enfant
	*
	* @return int
	*/
	public function get_parent_by_id( $danger_id ) {
		if (  true !== is_int( ( int )$danger_id ) )
			return false;

		$term = get_term_field( 'parent', $danger_id, $this->taxonomy );

		return $term;
	}

}

danger_class::g();
