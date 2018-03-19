<?php
/**
 * Classe gérant les commentaires d'un risque.
 *
 * @author Evarisk <dev@evarisk.com>
 * @since 6.1.5
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
class Risk_Evaluation_Comment_Class extends \eoxia\Comment_Class {

	/**
	 * Le nom du modèle
	 *
	 * @var string
	 */
	protected $model_name = '\digi\risk_evaluation_comment_model';

	/**
	 * La clé principale du modèle
	 *
	 * @var string
	 */
	protected $meta_key = '_wpdigi_risk_evaluation_comment';

	/**
	 * Le type
	 *
	 * @var string
	 */
	protected $comment_type = 'digi-riskevalcomment';

	/**
	 * La route pour accéder à l'objet dans la rest API
	 *
	 * @var string
	 */
	protected $base = 'risk-evaluation-comment';

	/**
	 * La version de l'objet
	 *
	 * @var string
	 */
	protected $version = '0.1';
}

Risk_Evaluation_Comment_Class::g();
