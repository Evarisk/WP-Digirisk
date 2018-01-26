<?php
/**
 * Les actions relatives aux méthodes d'évaluations.
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
 * Les actions relatives aux méthodes d'évaluations.
 */
class Evaluation_Method_Action {

	/**
	 * Le constructeur
	 *
	 * @since 6.0.0
	 * @version 6.5.0
	 */
	public function __construct() {
		add_action( 'wp_ajax_get_scale', array( $this, 'ajax_get_scale' ) );
	}

	/**
	 * Appelle la méthode get_scale pour avoir le niveau de l'évaluation
	 *
	 * @since 6.0.0
	 * @version 6.4.4
	 *
	 * array $_POST['list_variable'] La liste des valeurs de la méthode d'évaluation
	 * @param array $_POST Les données envoyées par le formulaire
	 */
	public function ajax_get_scale() {
		check_ajax_referer( 'get_scale' );
		$list_variable = ! empty( $_POST['list_variable'] ) ? (array) $_POST['list_variable'] : array();
		$level         = 1;

		if ( ! empty( $list_variable ) ) {
			foreach ( $list_variable as $element ) {
				$level *= (int) $element;
			}
		}

		$method_evaluation_digirisk_complex = get_term_by( 'slug', 'evarisk', Evaluation_Method_Class::g()->get_type() );
		$evaluation_method                  = Evaluation_Method_Class::g()->get( array( 'id' => $method_evaluation_digirisk_complex->term_id ), true );
		$equivalence                        = (int) $evaluation_method->matrix[ $level ];
		$scale                              = Scale_Util::get_scale( $equivalence );

		wp_send_json_success( array(
			'equivalence'      => $equivalence,
			'scale'            => $scale,
			'callback_success' => 'gettedScale',
		) );
	}
}

new Evaluation_Method_Action();
