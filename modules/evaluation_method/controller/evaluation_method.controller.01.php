<?php if ( !defined( 'ABSPATH' ) ) exit;
/**
 * Fichier contenant les utilitaires pour la gestion des méthodes d'évaluation / File with all utilities for managing evaluation method
 *
 * @author Evarisk development team <dev@evarisk.com>
 * @version 6.0
 */

/**
 * Classe contenant les utilitaires pour la gestion des méthodes d'évaluation / Class with all utilities for managing evaluation method
 *
 * @author Evarisk development team <dev@evarisk.com>
 * @version 6.0
 */
class wpdigi_evaluation_method_controller_01 extends term_ctr_01 {

	/**
	 * Nom du modèle à utiliser / Model name to use
	 * @var string
	 */
	protected $model_name   = 'wpdigi_evaluation_method_mdl_01';
	/**
	 * Type de l'élément dans wordpress / Wordpress element type
	 * @var string
	 */
	protected $taxonomy    	= 'digi-method';
	/**
	 * Nom du champs (meta) de stockage des données liées / Name of field (meta) for linked datas storage
	 * @var string
	 */
	protected $meta_key    	= '_wpdigi_method';

	/**	Défini la route par défaut permettant d'accèder à l'élément depuis WP Rest API  / Define the default route for accessing to element from WP Rest API	*/
	protected $base = 'digirisk/evaluation-method';
	protected $version = '0.1';

	protected $scale = array(
		'min' => 0,
		'max'	=> 100,
	);


	protected $treshold_level_on_scale = array(
		'0' 	=> 1,
		'48'	=> 2,
		'51'	=> 3,
		'80'	=> 4,
	);

	protected $operators = array(
		'+',
		'-',
		'*',
		'/',
	);

	function __construct() {
		add_action( 'wp_digi_activation_hook', array( $this, 'activation' ), 11 );

		/**	Instanciation du controlleur parent / Instanciate the parent controller */
		parent::__construct();

		/**	Inclusion du modèle / Include model	*/
		include_once( WPDIGI_EVALMETHOD_PATH . 'model/evaluation_method.model.01.php' );

		/**	Define taxonomy for evaluation method */
		add_action( 'init', array( $this, 'evaluation_method_type' ), 0 );
		add_action( 'wp_ajax_get_value_threshold', array( $this, 'ajax_get_value_threshold' ) );

		$this->set_method_level();
	}

	function evaluation_method_type() {
		global $wpdigi_risk_ctr;

		$labels = array(
			'name'              => __( 'Evaluation methods', 'digirisk' ),
			'singular_name'     => __( 'Evaluation method', 'digirisk' ),
			'search_items'      => __( 'Search evaluation methods', 'digirisk' ),
			'all_items'         => __( 'All evaluation methods', 'digirisk' ),
			'parent_item'       => __( 'Parent evaluation method', 'digirisk' ),
			'parent_item_colon' => __( 'Parent evaluation method:', 'digirisk' ),
			'edit_item'         => __( 'Edit evaluation method', 'digirisk' ),
			'update_item'       => __( 'Update evaluation method', 'digirisk' ),
			'add_new_item'      => __( 'Add New evaluation method', 'digirisk' ),
			'new_item_name'     => __( 'New evaluation method Name' , 'digirisk'),
			'menu_name'         => __( 'Evaluation method', 'digirisk' ),
		);

		$args = array(
			'hierarchical'      => true,
			'labels'            => $labels,
			'show_ui'           => true,
			'show_admin_column' => true,
			'query_var'         => true,
			'rewrite'           => array( 'slug' => 'evaluation-method' ),
		);

		register_taxonomy( $this->taxonomy, array( $wpdigi_risk_ctr->get_post_type() ), $args );
	}

	/**
	 * Récupération des niveaux correspondant aux scores obtenus lors de l'évaluation / Get the treshold level corresponding to score obtained during evaluation
	 * @param string $wanted_value Permet de choisir le retour pour les niveaux: ordonnés par niveau ou par score / Allows to choose the wanted return for scale treshold: ordered by level or by score
	 *
	 * @return array The protected var containing the method treshold
	 */
	function get_method_treshold( $wanted_value = 'level' ) {
		$treshold = $this->treshold_level_on_scale;

		if ( 'score' == $wanted_value ) {
			$treshold = array_flip( $this->treshold_level_on_scale );
		}

		return $treshold;
	}

	public function get_value_treshold( $level ) {
		if (  true !== is_int( ( int )$level ) )
			return false;

		if( empty( $this->treshold_level_on_scale ) )
			return false;

		foreach( $this->treshold_level_on_scale as $key => $value ) {
			if( $level - $key >= 0 ) {
				$list_ecart[$value] = $level - $key;
			}
		}

		$key = 0;

 		$value = min( $list_ecart );
 		$value = array_search( $value, $list_ecart );
 		return $value;
	}




	/**
	 * SETTER - Définition des niveaux de risques / Define the risk level
	 *
	 * PRODEST:
	 *
	 * @return array Les différents niveaux avec leur définitions communes / The different risk level with their common definition
	 */
	function set_method_level() {
		$this->risk_level = array(
			'1' => array(
					'color'						=> 'white',
					'risk_character'	=> __( 'low risk', 'digirisk' ),
			),
			'2' => array(
					'color'						=> 'orange',
					'risk_character'	=> __( 'risk to plan', 'digirisk' ),
			),
			'3' => array(
					'color'						=> 'red',
					'risk_character'	=> __( 'riskt to treat', 'digirisk' ),
			),
			'4' => array(
					'color'						=> 'black',
					'risk_character'	=> __( 'unacceptable risk', 'digirisk' ),
			),
		);
	}

	public function ajax_get_value_threshold() {
		// Risk evaluation level
		$risk_evaluation_level = 1;
		foreach ( $_POST['list_variable'] as $value ) {
			$risk_evaluation_level *= (int) $value;
		}

		if ( $risk_evaluation_level == 0 ) {
			$risk_evaluation_level = 1;
		}

		global $wpdigi_evaluation_method_controller;
		global $wpdigi_evaluation_method_variable_controller;
		$term_evarisk = get_term_by( 'slug', 'evarisk', $wpdigi_evaluation_method_controller->get_taxonomy() );

		if ( !empty( $term_evarisk ) ) {
			$evarisk_evaluation_method = $wpdigi_evaluation_method_controller->show( $term_evarisk->term_id );

			$equivalence = (int) $evarisk_evaluation_method->option['matrix'][$risk_evaluation_level];
			$scale = $wpdigi_evaluation_method_controller->get_value_treshold( $equivalence );
		}

		wp_send_json_success( array( 'scale' => $scale, 'equivalence' => $equivalence ) );
	}

	/**
	 * Création de la méthode Evarisk simplifié lors de l'activation de l'extension / Create Evarisk easy method when plugin is activated
	 */
	function activation() {
		$this->evaluation_method_type();
		if ( !term_exists( 'evarisk-simple', $this->get_taxonomy() ) ) {
			$next_method_id = ( wpdigi_utils::get_last_unique_key( 'term', $this->get_taxonomy() ) + 1 );
			global $wpdigi_evaluation_method_variable_controller;
			$term_method_variable = get_term_by( 'slug', 'evarisk', $wpdigi_evaluation_method_variable_controller->get_taxonomy() );
			$wp_evaluation_method_definition = array(
					'id' => null,
					'type' => $this->get_taxonomy(),
					'term_taxonomy_id' => null,
					'name' => __( 'Evarisk simplified', 'digirisk' ),
					'slug' => 'evarisk-simple',
					'description' => null,
					'option' => array(
							'unique_key' => $next_method_id,
							'unique_identifier' => ELEMENT_IDENTIFIER_ME . $next_method_id,
							'is_default' => true,
							'formula' => $term_method_variable->term_id,
							'matrix' => array(
								1 => 0,
								2 => 48,
								3 => 51,
								4 => 100,
							),
							'thumbnail_id' => null,
							'associated_document_id' => null,
					),
			);
			$wp_evaluation_method = $this->create( $wp_evaluation_method_definition );
		}
	}

	public function create_default_data() {
		global $wpdigi_evaluation_method_variable_controller;

		$file_content = file_get_contents( WPDIGI_EVALMETHOD_PATH . 'asset/json/default.json' );
		$data = json_decode( $file_content );

		if ( !empty( $data ) ) {
			foreach ( $data as $json_evaluation_method ) {

				$unique_key = wpdigi_utils::get_last_unique_key( 'term', $this->get_taxonomy() );
				$unique_key++;
				$unique_identifier = ELEMENT_IDENTIFIER_ME . '' . $unique_key;
				$evaluation_method = $this->create( array(
						'name' => $json_evaluation_method->name,
						'option' => array(
							'unique_key' => $unique_key,
							'unique_identifier' => $unique_identifier,
							'is_default'		=> $json_evaluation_method->option->is_default,
							'matrix'			=> $json_evaluation_method->option->matrix,
						),
				) );

				if ( is_wp_error( $evaluation_method ) && !empty( $evaluation_method->errors ) && !empty( $evaluation_method->errors['term_exists'] ) ) {
					$evaluation_method = $this->show( $evaluation_method->error_data['term_exists'] );
				}

				foreach( $json_evaluation_method->option->variable as $json_evaluation_method_variable ) {
					$unique_key = wpdigi_utils::get_last_unique_key( 'term', $wpdigi_evaluation_method_variable_controller->get_taxonomy() );
					$unique_key++;
					$unique_identifier = ELEMENT_IDENTIFIER_ME . '' . $unique_key;

					// On tente de crée les variables de la méthode d'évaluation
					$evaluation_method_variable = $wpdigi_evaluation_method_variable_controller->create( array(
							'name' => $json_evaluation_method_variable->name,
							'description' => $json_evaluation_method_variable->description,
							'option' => array(
								'unique_key' => $unique_key,
								'unique_identifier' => $unique_identifier,
								'display_type' => $json_evaluation_method_variable->option->display_type,
								'range' => $json_evaluation_method_variable->option->range,
								'survey' => $json_evaluation_method_variable->option->survey,
							),
					) );

					// Si elle existe déjà
					if ( !is_wp_error( $evaluation_method_variable ) ) {
						if ( $json_evaluation_method->name == 'Evarisk' ) {
							$evaluation_method->option['formula'][] = $evaluation_method_variable->id;
							$evaluation_method->option['formula'][] = "*";
						}
						else {
							if ( !empty( $evaluation_method_variable->id ) )
								$evaluation_method->option['formula'][] = $evaluation_method_variable->id;
						}

						$evaluation_method = $this->update( $evaluation_method );
					}
				}
			}
		}
	}

}

global $wpdigi_evaluation_method_controller;
$wpdigi_evaluation_method_controller = new wpdigi_evaluation_method_controller_01();
