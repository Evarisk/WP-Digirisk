<?php
/**
 * Gestion des filtres relatifs aux méthodes d'évaluations.
 *
 * @author Evarisk <dev@evarisk.com>
 * @since 6.5.0
 * @version 6.5.0
 * @copyright 2015-2018 Evarisk
 * @package DigiRisk
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Gestion des filtres relatifs aux méthodes d'évaluations.
 */
class Evaluation_Method_Filter {

	/**
	 * Utilises le filtre digi_evaluation_method_dropdown_end
	 *
	 * @since 6.5.0
	 * @version 6.5.0
	 */
	public function __construct() {
		add_filter( 'digi_evaluation_method_dropdown_end', array( $this, 'callback_evaluation_method_dropdown_end' ) );
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
}

new Evaluation_Method_Filter();
