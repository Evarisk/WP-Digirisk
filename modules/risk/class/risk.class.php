<?php
/**
 * Les risques
 *
 * @package Evarisk\Plugin
 */

namespace digi;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Les risques
 */
class Risk_Class extends Post_Class {

	/**
	 * Le nom du modèle
	 *
	 * @var string
	 */
	protected $model_name   = '\digi\risk_model';

	/**
	 * Le post type
	 *
	 * @var string
	 */
	protected $post_type    = 'digi-risk';

	/**
	 * La clé principale du modèle
	 *
	 * @var string
	 */
	protected $meta_key    	= '_wpdigi_risk';

	/**
	 * La fonction appelée automatiquement avant la création de l'objet dans la base de donnée
	 *
	 * @var array
	 */
	protected $before_post_function = array( '\digi\construct_identifier' );

	/**
	 * La fonction appelée automatiquement après la récupération de l'objet dans la base de donnée
	 *
	 * @var array
	 */
	protected $after_get_function = array( '\digi\get_identifier', '\digi\get_full_risk' );

	/**
	 * La route pour accéder à l'objet dans la rest API
	 *
	 * @var string
	 */
	protected $base = 'digirisk/risk';

	/**
	 * La version de l'objet
	 *
	 * @var string
	 */
	protected $version = '0.1';

	/**
	 * Le préfixe de l'objet dans DigiRisk
	 *
	 * @var string
	 */
	public $element_prefix = 'R';

	/**
	 * La limite des risques a affiché par page
	 *
	 * @var integer
	 */
	protected $limit_risk = -1;

	/**
	 * Le nom pour le resgister post type
	 *
	 * @var string
	 */
	protected $post_type_name = 'Risques';

	/**
	 * Constructeur
	 *
	 * @return void
	 */
	protected function construct() {
		parent::construct();

		/**	Définition d'un shortcode permettant d'afficher les risques associés à un élément / Define a shortcode allowing to display risk associated to a given element 	*/
		add_shortcode( 'risk', array( $this, 'risk_shortcode' ) );

		/**	Ajoute les onglets pour les unités de travail / Add tabs for workunit	*/
		add_filter( 'wpdigi_workunit_sheet_tab', array( $this, 'filter_add_sheet_tab_to_element' ), 5, 2 );
		/**	Ajoute le contenu pour les onglets des unités de travail / Add the content for workunit tabs	*/
		add_filter( 'wpdigi_workunit_sheet_content', array( $this, 'filter_display_risk_in_element' ), 10, 3 );

		/**	Ajoute les onglets pour les unités de travail / Add tabs for workunit	*/
		add_filter( 'wpdigi_group_sheet_tab', array( $this, 'filter_add_sheet_tab_to_element' ), 5, 2 );
		/**	Ajoute le contenu pour les onglets des unités de travail / Add the content for group tabs	*/
		add_filter( 'wpdigi_group_sheet_content', array( $this, 'filter_display_risk_in_element' ), 10, 3 );
		add_filter( 'json_endpoints', array( $this, 'callback_register_route' ) );
	}

	/**
	 * Charges la liste des risques même ceux des enfants. Et appelle le template pour les afficher.
	 * Récupères le schéma d'un risque pour l'entrée d'ajout de risque dans le tableau.
	 *
	 * @param  integer $society_id L'ID de la société.
	 * @return void
	 */
	public function display( $society_id ) {
		$risk_schema = $this->get( array( 'schema' => true ) );
		$risk_schema = $risk_schema[0];

		$risks = $this->get( array( 'post_parent' => $society_id ) );

		view_util::exec( 'risk', 'list', array( 'society_id' => $society_id, 'risks' => $risks, 'risk_schema' => $risk_schema ) );
	}
}

risk_class::g();
