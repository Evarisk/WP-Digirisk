<?php
/**
 * Classe gérant les évaluations d'un risque
 *
 * @author Evarisk <dev@evarisk.com>
 * @since 6.0.0
 * @copyright 2015-2018 Evarisk
 * @package DigiRisk
 */

namespace digi;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Classe gérant les évaluations d'un risque
 */
class Risk_Evaluation_Class extends \eoxia\Comment_Class {

	/**
	 * Le nom du modèle
	 *
	 * @var string
	 */
	protected $model_name = '\digi\Risk_Evaluation_Model';

	/**
	 * La clé principale du modèle
	 *
	 * @var string
	 */
	protected $meta_key = '_wpdigi_risk_evaluation';

	/**
	 * Le type du commentaire
	 *
	 * @var string
	 */
	protected $type = 'digi-risk-eval';

	/**
	 * La route pour accéder à l'objet dans la rest API
	 *
	 * @var string
	 */
	protected $base = 'risk_evaluation';

	/**
	 * Le préfixe de l'objet dans DigiRisk
	 *
	 * @var string
	 */
	public $element_prefix = 'E';

	/**
	 * Affichages des l'évaluation dans un risque.
	 *
	 * @since 6.0.0
	 *
	 * @param  Risk_Model $risk Les données du risque.
	 */
	public function display( $risk ) {
		\eoxia\View_Util::exec( 'digirisk', 'risk', 'risk-evaluation/main', array(
			'risk' => $risk,
		) );
	}

	/**
	 * Enregistre l'évaluation du risque $risk_id.
	 *
	 * @since 6.5.0
	 * @version 6.5.0
	 *
	 * @param int   $risk_id               L'ID ou doit être affecter l'évaluation du risque.
	 * @param int   $method_evaluation_id  L'ID de la méthode d'évaluation.
	 * @param array $method_variables_data (Voir au dessus).
	 *
	 * @return boolean|Risk_Evaluation_Model Les données de l'évaluation du risque.
	 */
	public function save( $risk_id, $method_evaluation_id, $method_variables_data ) {
		$risk_id = (int) $risk_id;

		if ( empty( $risk_id ) ) {
			return false;
		}

		// Récupères la cotation, l'équivalence et la force du risque.
		$details = Evaluation_Method_Class::g()->get_details( $method_evaluation_id, $method_variables_data );

		$data['post_id']     = $risk_id;
		$data['scale']       = (int) $details['scale'];
		$data['cotation']    = (int) $details['cotation'];
		$data['equivalence'] = (int) $details['equivalence'];
		$data['variables']   = (array) $details['variables'];

		$risk_evaluation = $this->update( $data );

		return $risk_evaluation;
	}
}

Risk_Evaluation_Class::g();
