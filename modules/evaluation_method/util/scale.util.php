<?php
/**
 * Fonctions utiles pour les méthodes d'évaluations.
 *
 * @author Evarisk <dev@evarisk.com>
 * @since 6.2.9
 * @version 7.0.0
 * @copyright 2015-2018 Evarisk
 * @package DigiRisk
 */

namespace digi;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Fonctions utiles pour les méthodes d'évaluations.
 */
class Scale_Util {

	/**
	 * Récupères le niveau d'évaluation par rapport à son level
	 *
	 * @since 6.2.9
	 * @version 7.0.0
	 *
	 * @param int $level Le level de l'évaluation.
	 *
	 * @return $int value
	 */
	public static function get_scale( $level ) {
		if ( true !== is_int( $level ) ) {
			return false;
		}

		$method_evaluation_simplified = Evaluation_Method_Class::g()->get( array( 'slug' => 'evarisk-simplified' ), true );
		$list_scale                   = array( 1 => 0, 2 => 48, 3 => 51, 4 => 80 );
		if ( empty( $list_scale ) ) {
			return false;
		}

		$list_ecart = array();
		$list_key   = array();

		foreach ( $list_scale as $key => $value ) {
			if ( $level - $value >= 0 ) {
				$list_ecart[ $value ] = $level - $value;
				$list_key[ $value ]   = $key;
			}
		}

		$key   = 0;
		$value = min( $list_ecart );
		$value = array_search( $value, $list_ecart );
		return $list_key[ $value ];
	}
}
