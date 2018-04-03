<?php
/**
 * Gestion des filtres relatifs aux méthodes d'évaluations.
 *
 * @author Evarisk <dev@evarisk.com>
 * @since 6.5.0
 * @version 7.0.0
 * @copyright 2015-2018 Evarisk
 * @package DigiRisk
 */

namespace digi;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Gestion des filtres relatifs aux méthodes d'évaluations.
 */
class Evaluation_Method_Filter extends Identifier_Filter {

	/**
	 * Utilises le filtre digi_evaluation_method_dropdown_end
	 *
	 * @since 6.5.0
	 * @version 7.0.0
	 */
	public function __construct() {
		parent::__construct();

		add_filter( 'digi_evaluation_method_dropdown_end', array( $this, 'callback_evaluation_method_dropdown_end' ) );

		$current_type = Evaluation_Method_Class::g()->get_type();
		add_filter( "eo_model_{$current_type}_after_get", array( $this, 'get_full_method_evaluation' ), 10, 2 );
	}

	/**
	 * Ajoutes les méthodes d'évaluations nécéssitant une modal.
	 *
	 * @since 6.5.0
	 * @version 6.5.0
	 */
	public function callback_evaluation_method_dropdown_end() {
		ob_start();
		\eoxia\View_Util::exec( 'digirisk', 'evaluation_method', 'dropdown/button-modal-methods' );
		return ob_get_clean();
	}

	/**
	 * Récupères les variables des méthodes d'évaluations
	 *
	 * @since 6.5.0
	 * @version 6.5.0
	 *
	 * @param  Evaluation_Method_Model $object Les données de la méthode d'évaluation.
	 * @param  array                   $args   Les données de la requête.
	 * @return Evaluation_Method_Model         Les données de la méthode d'évaluation avec ses variables.
	 */
	public function get_full_method_evaluation( $object, $args ) {
		if ( ! empty( $object->data['formula'] ) ) {
			$object->data['variables'] = Evaluation_Method_Variable_Class::g()->get( array(
				'include' => $object->data['formula'],
			) );
		}

		return $object;
	}

}

new Evaluation_Method_Filter();
