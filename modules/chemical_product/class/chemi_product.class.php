<?php if ( !defined( 'ABSPATH' ) ) exit;

class chemi_product_class extends post_class {

	protected $model_name   = 'chemi_product_model';
	protected $post_type    = 'digi-chemi_product';
	protected $meta_key    	= '_wpdigi_chemical_product';

	/**	Défini la route par défaut permettant d'accèder aux sociétés depuis WP Rest API  / Define the default route for accessing to chemical_product from WP Rest API	*/
	protected $base = 'digirisk/chemical_product';
	protected $version = '0.1';

	protected $before_post_function = array( '\digi\construct_identifier' );
	protected $after_get_function = array( '\digi\get_identifier' );
	public $element_prefix = 'CP';

	protected $limit_chemical_product = -1;

	/**
	 * Le nom pour le resgister post type
	 *
	 * @var string
	 */
	protected $post_type_name = 'Produits chimique';

	/**
	 * Instanciation principale de l'extension / Plugin instanciation
	 */
	protected function construct() {
		parent::construct();
	}

	/**
	* Affiche la fenêtre principale
	*
	* @param int $society_id L'ID de la societé
	*/
	public function display( $society_id ) {
		$chemical_product = $this->get( array( 'schema' => true ) );
		$chemical_product = $chemical_product[0];
		require( CHEMICAL_PRODUCT_VIEW_DIR . 'main.view.php' );
	}

	/**
	 * DISPLAY - Génération de l'affichage des risques à partir d'un shortcode / Generate display for chemical_products through shortcode
	 *
	 * @param int $society_id L'ID de la societé
	 */
	public function display_chemical_product_list( $society_id ) {
		$society = society_class::g()->show_by_type( $society_id );

		if ( $society->id === 0 ) {
			return false;
		}

		$chemical_product_list = chemi_product_class::g()->get( array( 'post_parent' => $society->id ), array( false ) );

		require( CHEMICAL_PRODUCT_VIEW_DIR . 'list.view.php' );
	}
}
