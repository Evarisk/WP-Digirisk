<?php
/**
 * Gestion des variables des méthodes d'évaluations.
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
 * Gestion des variables des méthodes d'évaluations.
 */
class Evaluation_Method_Variable_Class extends \eoxia\Term_Class {

	/**
	 * Nom du modèle à utiliser
	 *
	 * @var string
	 */
	protected $model_name = '\digi\Evaluation_Method_Variable_Model';

	/**
	 * Type de l'élément dans WordPress
	 *
	 * @var string
	 */
	protected $type = 'digi-method-variable';

	/**
	 * Nom du champs (meta) de stockage des données liées
	 *
	 * @var string
	 */
	protected $meta_key = '_wpdigi_methodvariable';

	/**
	 * La route pour la REST API.
	 *
	 * @var string
	 */
	protected $base = 'evaluation_method_variable';

	/**
	 * La version pour la rest api.
	 *
	 * @var string
	 */
	protected $version = '0.1';

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
	protected $after_get_function = array();

	/**
	 * Récupères les valeurs des variables selon une formule
	 *
	 * @since 6.0.0
	 * @version 6.5.0
	 *
	 * @param  Array $formula La formule.
	 *
	 * @return Array          Les variables d'évaluation selon la formule.
	 */
	public function get_evaluation_method_variable( $formula ) {
		$list_evaluation_method_variable = array();

		if ( ! empty( $formula ) ) {
			foreach ( $formula as $key => $id ) {
				if ( (int) ( $key % 2 ) === 0 ) {
					$list_evaluation_method_variable[] = self::g()->get( array( 'id' => $id ), true );
				}
			}
		}

		return $list_evaluation_method_variable;
	}

}

Evaluation_Method_Variable_Class::g();
