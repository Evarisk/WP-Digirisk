<?php if ( !defined( 'ABSPATH' ) ) exit;
/**
 * Classe du controlleur principal pour les adresses dans Digirisk / Controller class for addresses for Digirisk
 *
 * @author Evarisk development team <dev@evarisk.com>
 * @version 6.0
 */
class wpdigi_address_ctr_01 extends comment_ctr_01 {
	/**
	 * Nom du modèle à utiliser / Model name to use
	 * @var string
	 */
	protected $model_name   = 'wpdigi_address_mdl_01';
	/**
	 * Type de l'élément dans wordpress / Wordpress element type
	 * @var string
	 */
	protected $comment_type  = 'digi-address';
	/**
	 * Nom du champs (meta) de stockage des données liées / Name of field (meta) for linked datas storage
	 * @var string
	 */
	protected $meta_key    	= '_wpdigi_address';

	/**	Défini la route par défaut permettant d'accèder à l'élément depuis WP Rest API  / Define the default route for accessing to element from WP Rest API	*/
	protected $base = 'address';
	protected $version = '0.1';

	/**
	 * Instanciation de l'objet addresse / Address instanciation
	 */
	function __construct() {
		parent::__construct();

		/**	Inclusion du modèle pour les adresses / Include addresses' model	*/
		include_once( DIGI_ADDRESS_PATH . 'model/address.model.01.php' );
	}

	public function save_address( $data ) {
		if ( empty( $data ) || empty( $data['postcode'] ) || empty( $data['address'] ) || empty( $data['town'] ) ) {
			return false;
		}

		// Sécurise les données
		$data['postcode'] = sanitize_text_field( $data['postcode'] );
		$data['address'] = sanitize_text_field( $data['address'] );
		$data['town'] = sanitize_text_field( $data['town'] );

		return $this->create( $data );
	}

}

/**
 * Création de l'élément adresse / Address element creation
 */
global $wpdigi_address_ctr;
$wpdigi_address_ctr = new wpdigi_address_ctr_01();
