<?php
/**
 * Classe gérant les risques
 *
 * @author Evarisk <dev@evarisk.com>
 * @since 6.0.0
 * @version 6.5.0
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
	protected $post_type = 'digi-risk';

	/**
	 * La clé principale du modèle
	 *
	 * @var string
	 */
	protected $meta_key = '_wpdigi_risk';

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
	 * Charges la liste des risques même ceux des enfants. Et appelle le template pour les afficher.
	 * Récupères le schéma d'un risque pour l'entrée d'ajout de risque dans le tableau.
	 *
	 * @param  integer $society_id L'ID de la société.
	 * @return void
	 *
	 * @since 6.0.0
	 * @version 6.5.0
	 *
	 * @todo 24/01/2018: Doit charger les risques des enfants
	 */
	public function display( $society_id ) {
		$society = Society_Class::g()->show_by_type( $society_id );

		$risk_schema = self::get( array( 'id' => 0 ), true );
		$risks       = self::get( array( 'post_parent' => $society_id ) );

		if ( count( $risks ) > 1 ) {
			usort( $risks, function( $a, $b ) {
				if ( ! isset( $a->current_equivalence ) ) {
					return 0;
				}

				if ( $a->current_equivalence === $b->current_equivalence ) {
					return 0;
				}

				return ( $a->current_equivalence > $b->current_equivalence ) ? -1 : 1;
			} );
		}

		\eoxia\View_Util::exec( 'digirisk', 'risk', 'main', array(
			'society'     => $society,
			'society_id'  => $society_id,
			'risks'       => $risks,
			'risk_schema' => $risk_schema,
		) );
	}

	/**
	 * Sauvegardes un risque dans la base de donnée.
	 *
	 * @since 6.5.0
	 * @version 6.5.0
	 *
	 * @param  [type] $data                 [description]
	 * @param  [type] $risk_category_id     [description]
	 * @param  [type] $method_evaluation_id [description]
	 * @return [type]                       [description]
	 */
	public function save( $data, $risk_category_id, $method_evaluation_id ) {
		$data['id']        = (int) $data['id'];
		$data['title']     = sanitize_text_field( $data['title'] );
		$data['parent_id'] = (int) $data['parent_id'];

		if ( ! isset( $data['status'] ) ) {
			$data['status'] = 'inherit';
		}

		$data['$push']['taxonomy'] = array(
			'digi-category-risk' => $risk_category_id,
			'digi-method'        => $method_evaluation_id,
		);

		return $this->update( $data );
	}
}

Risk_Class::g();
