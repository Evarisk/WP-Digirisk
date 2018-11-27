<?php
/**
 * Classe gérant les risques
 *
 * @author Evarisk <dev@evarisk.com>
 * @since 6.0.0
 * @version 7.0.0
 * @copyright 2015-2018 Evarisk
 * @package DigiRisk
 */

namespace digi;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Classe gérant les risques
 */
class Risk_Class extends \eoxia\Post_Class {

	/**
	 * Le nom du modèle
	 *
	 * @var string
	 */
	protected $model_name = '\digi\Risk_Model';

	/**
	 * Le post type
	 *
	 * @var string
	 */
	protected $type = 'digi-risk';

	/**
	 * La clé principale du modèle
	 *
	 * @var string
	 */
	protected $meta_key = '_wpdigi_risk';

	/**
	 * La route pour accéder à l'objet dans la rest API
	 *
	 * @var string
	 */
	protected $base = 'risk';

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
	 * La limite des risques a afficher par page
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
	 * Le nom de la taxonomy.
	 *
	 * @since   7.0.0
	 * @version 7.0.0
	 */
	protected $attached_taxonomy_type = 'digi-recommendation-category';

	/**
	 * Charges la liste des risques même ceux des enfants. Et appelle le template pour les afficher.
	 * Récupères le schéma d'un risque pour l'entrée d'ajout de risque dans le tableau.
	 *
	 * @param  integer $society_id L'ID de la société.
	 * @return void
	 *
	 * @since 6.0.0
	 */
	public function display( $society_id ) {
		global $eo_search;

		$society = Society_Class::g()->show_by_type( $society_id );

		$risk_schema = $this->get( array( 'schema' => true ), true );
		$risks       = $this->get( array(
			'post_parent' => $society_id,
			'orderby'     => 'meta_value_num',
			'meta_key'    => '_wpdigi_equivalence',
		) );

		$args_to_society_id = array(
			'label' => 'Déplacer le risque vers le GP ou l\'UT:',
			'type'  => 'post',
			'name'  => 'to_society_id',
			'args' => array(
				'model_name' => array(
					'\digi\Group_Class',
					'\digi\Workunit_Class',
				),
				'meta_query' => array(
					'relation' => 'OR',
					array(
						'key' => '_wpdigi_unique_identifier',
						'compare' => 'LIKE',
					),
					array(
						'key' => '_wpdigi_unique_key',
						'compare' => 'LIKE',
					),
				)
			),
			'icon' => 'fa-search'
		);

		$eo_search->register_search( 'to_society_id', $args_to_society_id );

		\eoxia\View_Util::exec( 'digirisk', 'risk', 'main', array(
			'society'     => $society,
			'society_id'  => $society_id,
			'risks'       => $risks,
			'risk_schema' => $risk_schema,
			'eo_search'   => $eo_search,
		) );
	}

	/**
	 * Sauvegardes un risque dans la base de donnée.
	 *
	 * @since 6.5.0
	 *
	 * @param  [type] $data                 [description]
	 * @param  [type] $risk_category_id     [description]
	 * @param  [type] $method_evaluation_id [description]
	 * @return [type]                       [description]
	 */
	public function save( $data, $risk_category_id, $method_evaluation_id ) {
		$data['id']        = (int) $data['id'];
		$data['parent_id'] = (int) $data['parent_id'];

		if ( ! isset( $data['status'] ) ) {
			$data['status'] = 'inherit';
		}

		$data['taxonomy'] = array(
			'digi-category-risk' => array( $risk_category_id ),
			'digi-method'        => array( $method_evaluation_id ),
		);

		$risk_category = Risk_Category_Class::g()->get( array( 'id' => $risk_category_id ), true );

		$data['title'] = $risk_category->data['name'];

		return $this->update( $data );
	}
}

Risk_Class::g();
