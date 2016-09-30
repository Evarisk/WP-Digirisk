<?php namespace digi;

if ( !defined( 'ABSPATH' ) ) exit;

class legal_display_class extends post_class {
  protected $model_name = '\digi\legal_display_model';
	protected $post_type  = 'digi-legal-display';
	protected $meta_key   = '_wpdigi_legal_display';
	protected $base 			= 'digirisk/legal_display';
	protected $version 		= '0.1';
	protected $before_post_function = array( '\digi\construct_identifier' );
	protected $after_get_function = array( '\digi\get_identifier' );

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
		$legal_display = $this->get( array( 'post_parent' => $element->id ), array( '\digi\detective_work', '\digi\occupational_health_service', '\digi\address', ) );

		if ( empty( $legal_display ) ) {
			$legal_display = $this->get( array( 'schema' => true ), array( '\digi\detective_work', '\digi\occupational_health_service', '\digi\address', ) );
		}

		$legal_display = $legal_display[0];

		view_util::exec( 'legal_display', 'display', array( 'element_id' => $element->id, 'legal_display' => $legal_display ) );
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
