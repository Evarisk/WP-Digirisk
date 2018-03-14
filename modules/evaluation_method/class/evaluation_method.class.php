<?php
/**
 * Gestion des méthodes d'évaluations.
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
 * Gestion des méthodes d'évaluations
 */
class Evaluation_Method_Class extends \eoxia\Term_Class {

	/**
	 * Nom du modèle à utiliser
	 *
	 * @var string
	 */
	protected $model_name = '\digi\Evaluation_Method_Model';

	/**
	 * Type de l'élément dans WordPress
	 *
	 * @var string
	 */
	protected $taxonomy = 'digi-method';

	/**
	 * Nom du champs (meta) de stockage des données liées
	 *
	 * @var string
	 */
	protected $meta_key = '_wpdigi_method';

	/**
	 * La fonction appelée automatiquement avant la création de l'objet dans la base de donnée
	 *
	 * @var array
	 */
	protected $before_post_function = array();

	/**
	 * La fonction appelée automatiquement après la récupération de l'objet dans la base de donnée
	 *
	 * @var array
	 */
	protected $after_get_function = array( '\digi\get_identifier' );

	/**
	 * Le préfixe de l'objet dans DigiRisk
	 *
	 * @var string
	 */
	public $element_prefix = 'ME';

	/**
	 * La version pour la rest api.
	 *
	 * @var string
	 */
	protected $version = '0.1';

	/**
	 * La route pour la REST API.
	 *
	 * @var string
	 */
	protected $base = 'evaluation_method';

	/**
	 * La liste des quotations principaux.
	 *
	 * @var Array
	 */
	public $list_scale = array(
		1 => 0,
		2 => 48,
		3 => 51,
		4 => 80,
	);

	/**
	 * Créer une méthode d'évaluation
	 *
	 * @since 6.0.0
	 * @version 6.5.0
	 *
	 * @param array $data Les données pour créer la méthode d'évaluation.
	 *
	 * @return object L'objet créé
	 */
	public function create_evaluation_method( $data ) {
		$evaluation_method = $this->create( $data );

		if ( is_wp_error( $evaluation_method ) && ! empty( $evaluation_method->errors )
			&& ! empty( $evaluation_method->errors['term_exists'] ) ) {
			$evaluation_method = $this->show( $evaluation_method->error_data['term_exists'] );
		}

		return $evaluation_method;
	}

}

Evaluation_Method_Class::g();
