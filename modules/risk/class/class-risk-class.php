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
	 *
	 * @var string
	 */
	protected $attached_taxonomy_type = 'digi-recommendation-category';

	/**
	 * Charges la liste des risques même ceux des enfants. Et appelle le template pour les afficher.
	 * Récupères le schéma d'un risque pour l'entrée d'ajout de risque dans le tableau.
	 *
	 * @param  integer $society_id L'ID de la société.
	 *
	 * @since 6.0.0
	 */
	public function display( $society_id ) {
		$society = Society_Class::g()->show_by_type( $society_id );

		$risk_schema = $this->get( array( 'schema' => true ), true );
		$risks       = $this->get( array(
			'post_parent' => $society_id,
			'orderby'     => 'meta_value_num',
			'meta_key'    => '_wpdigi_equivalence',
		) );

		$societies = Society_Class::g()->get( array(
			'post_type'      => array( 'digi-group', 'digi-workunit' ),
			'posts_per_page' => -1,
			'post_status'    => array( 'publish', 'inherit' ),
		) );

		\eoxia\View_Util::exec( 'digirisk', 'risk', 'main', array(
			'society'     => $society,
			'society_id'  => $society_id,
			'risks'       => $risks,
			'risk_schema' => $risk_schema,
			'societies'   => $societies
		) );
	}

	/**
	 * Sauvegardes un risque dans la base de donnée.
	 *
	 * @since 6.5.0
	 *
	 * @param  array $data                  Les données à sauvegarder.
	 * @param  int   $risk_category_id      L'ID de la catégorie de risque.
	 * @param  int   $method_evaluation_id  L'ID de la méthode d'évaluation.
	 * @return Risk_Class                   Les données du risque enregistré.
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
