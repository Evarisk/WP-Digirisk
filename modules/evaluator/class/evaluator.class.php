<?php
/**
 * Classe gérant les évaluateurs
 *
 * @author    Evarisk <dev@evarisk.com>
 * @since     6.2.3
 * @version   7.0.0
 * @copyright 2018 Evarisk.
 * @package   DigiRisk
 */

namespace digi;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Classe gérant les évaluateurs
 */
class Evaluator_Class extends \eoxia\User_Class {

	/**
	 * Le nom du modèle
	 *
	 * @var string
	 */
	protected $model_name = '\digi\User_Model'; // CHANGER CHEMIN d'accès pour voir

	/**
	 * La clé principale du modèle
	 *
	 * @var string
	 */
	protected $meta_key = '_wpeo_user_info';

	/**
	 * La route pour accéder à l'objet dans la rest API
	 *
	 * @var string
	 */
	protected $base = 'evaluator';

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
	public $element_prefix = 'U';

	/**
	 * Fait le rendu des evaluateurs
	 *
	 * @since 6.0.0
	 *
	 * @param Group_Model $element L'objet parent.
	 * @param integer     $current_page Le numéro de la page pour la pagination.
	 */
	public function render( $element, $current_page = 1 ) {
		global $eo_search;

		$current_page            = ! empty( $_POST['next_page'] ) ? (int) $_POST['next_page'] : 1; // WPCS: input var ok.
		$evaluators = User_Class::g()->get();

		$args_where_evaluator = array(
			'type'         => 'user',
			'name'         => 'user_id',
			'icon' => 'fa-search',
			'class' => 'evaluator',
		);

		$eo_search->register_search( 'evaluator', $args_where_evaluator );
		$args_where_evaluator['fields'] = array( 'ID' );
		$eo_search->register_search( 'item-edit', array(
			'icon'    => 'fa-search',
			'type'    => 'user',
			'name'    => 'evaluator',
			'post_id' => $element->data['id'],
		) );
		\eoxia\View_Util::exec( 'digirisk', 'evaluator', 'main', array(
			'element'                 => $element,
			'evaluators'              => $evaluators,
			'current_page'            => $current_page,
		) );
	}
}
