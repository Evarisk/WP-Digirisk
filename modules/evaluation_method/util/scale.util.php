<?php
/**
 * Tout ce qui est en relation avec les JSON
 *
 * @author Jimmy Latour <jimmy.eoxia@gmail.com>
 * @since 6.2.9
 */

namespace digi;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class Scale_Util {

	/**
	 * Récupères le niveau d'évaluation par rapport à son level
	 *
	 * @since 6.2.9
	 * @version 6.5.0
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
		$list_scale                   = $method_evaluation_simplified->matrix;
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
