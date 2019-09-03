<?php
/**
 * Gestion des données des méthodes d'évaluation des risque par défaut.
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
 * Gestion des données des méthodes d'évaluation des risque par défaut.
 */
class Evaluation_Method_Default_Data_Class extends \eoxia\Singleton_Util {

	/**
	 * Le constructeur
	 *
	 * @since 6.0.0
	 * @version 6.0.0
	 *
	 * @return void
	 */
	protected function construct() {}

	/**
	 * Créer les méthodes d'évaluation par défaut
	 *
	 * @since 6.0.0
	 * @version 6.5.0
	 *
	 * @param array $exclude Les données à exclure.
	 *
	 * @return bool          True si tout s'est bien passé sinon false.
	 */
	public function create( $exclude = array() ) {
		$request = file_get_contents( \eoxia\Config_Util::$init['digirisk']->evaluation_method->path . 'asset/json/default.json' );

		if ( ! $request ) {
			return false;
		}

		$data = json_decode( $request );

		if ( ! empty( $data ) ) {
			foreach ( $data as $json_evaluation_method ) {
				if ( ! in_array( $json_evaluation_method->slug, $exclude, true ) ) {
					$this->create_evaluation_method( $json_evaluation_method );
				}
			}
		}

		return true;
	}

	/**
	 * Créer la méthode d'évaluation.
	 *
	 * @since 6.0.0
	 * @version 7.0.0
	 *
	 * @param  Object $json_evaluation_method Les données de la méthode d'évaluation.
	 *
	 * @return void
	 */
	private function create_evaluation_method( $json_evaluation_method ) {
		$evaluation_method = Evaluation_Method_Class::g()->create( array(
			'name'       => $json_evaluation_method->name,
			'slug'       => $json_evaluation_method->slug,
			'is_default' => $json_evaluation_method->option->is_default,
			'matrix'     => (array) $json_evaluation_method->option->matrix,
		) );

		if ( ! is_wp_error( $evaluation_method ) ) {
			foreach ( $json_evaluation_method->option->variable as $json_evaluation_method_variable ) {
				$this->create_evaluation_method_variable( $evaluation_method, $json_evaluation_method, $json_evaluation_method_variable );
			}
		}
	}

	/**
	 * Créer les variables de la méthode d'évaluation
	 *
	 * @since 6.0.0
	 * @version 7.0.0
	 *
	 * @param  Evaluation_Method_Model $evaluation_method               Le modèle de la méthode d'évaluation.
	 * @param  Object                  $json_evaluation_method          Les données de la méthode d'évaluation.
	 * @param  Object                  $json_evaluation_method_variable Les données des variables de la méthode d'évaluation.
	 *
	 * @return void
	 */
	private function create_evaluation_method_variable( $evaluation_method, $json_evaluation_method, $json_evaluation_method_variable ) {
		$evaluation_method_variable = Evaluation_Method_Variable_Class::g()->create( array(
			'name'         => $json_evaluation_method_variable->name,
			'description'  => $json_evaluation_method_variable->description,
			'display_type' => $json_evaluation_method_variable->option->display_type,
			'range'        => $json_evaluation_method_variable->option->range,
			'survey'       => (array) $json_evaluation_method_variable->option->survey,
		) );

		if ( ! is_wp_error( $evaluation_method_variable ) ) {
			if ( 'evarisk' === $json_evaluation_method->slug ) {
				$evaluation_method->data['formula'][] = $evaluation_method_variable->data['id'];
				$evaluation_method->data['formula'][] = '*';
			} else {
				if ( ! empty( $evaluation_method_variable->data['id'] ) ) {
					$evaluation_method->data['formula'][] = $evaluation_method_variable->data['id'];
				}
			}

			Evaluation_Method_Class::g()->update( $evaluation_method->data );
		}
	}
}
