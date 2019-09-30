<?php
/**
 * Gestion des méthodes d'évaluations.
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
	protected $type = 'digi-method';

	/**
	 * Nom du champs (meta) de stockage des données liées
	 *
	 * @var string
	 */
	protected $meta_key = '_wpdigi_method';

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

	/**
	 * Récupères la force, la cotation et l'équivalence selon les variables et la méthode d'évaluation.
	 *
	 * @since 6.5.0
	 * @version 6.5.0
	 *
	 * @param integer $evaluation_method_id        ID de la méthode d'évaluation.
	 * @param array   $evaluation_method_variables (Voir au dessus).
	 *
	 * @return mixedarray                          (Voir au dessus). Ou false si:
	 *                                                                  -Méthode d'évaluation n'existe pas.
	 *                                                                  -Une des variables pour la formule est introuvable.
	 */
	public function get_details( $evaluation_method_id, $evaluation_method_variables ) {
		$details = array(
			'scale'       => 0,
			'cotation'    => 0,
			'equivalence' => 0,
			'variables'   => array(),
		);

		$evaluation_method = $this->get( array( 'id' => $evaluation_method_id ), true );

		if ( 0 === $evaluation_method->data['id'] ) {
			return false;
		}

		$evaluation_method_variables_id = array_keys( $evaluation_method_variables );

		// Vires les opérateurs arithmétiques.
		$formula = array_filter( $evaluation_method->data['formula'], 'is_int' );

		$formula = array_unique( $formula );

		// Le tableau 'formula' contient des entrées de type 'int' et 'string', ex: 0 => 1, 1 => '*', 2 => 5, 3 => '*', 4 => 10.
		if ( ! empty( $formula ) ) {
			foreach ( $formula as $key => $variable_id ) {
				$variable_id = (int) $variable_id;

				// Est-ce que la valeur est un nombre supérieure à 0.
				if ( ! empty( $variable_id ) ) {
					if ( ! in_array( $variable_id, $evaluation_method_variables_id, true ) ) {
						return false;
					} else {
						$details[ $variable_id ] = (int) $evaluation_method_variables[ $variable_id ];

						if ( 0 === $key ) {
							$details['cotation'] = $evaluation_method_variables[ $variable_id ];
						} else {
							$details['cotation'] *= $evaluation_method_variables[ $variable_id ];
						}
					}
				}
			}
		}

		$details['cotation']    = (int) $details['cotation'];
		$details['equivalence'] = (int) $evaluation_method->data['matrix'][ $details['cotation'] ];
		$details['scale']       = (int) Scale_Util::get_scale( $details['equivalence'] );
		$details['variables']   = $evaluation_method_variables;

		return $details;
	}

}

Evaluation_Method_Class::g();
