<?php namespace digi;
/**
 * Tout ce qui est en relation avec les JSON
 *
 * @author Jimmy Latour <jimmy.eoxia@gmail.com>
 * @version 1.0
 */

if ( !defined( 'ABSPATH' ) ) exit;

class scale_util {
    /**
    * Récupères le niveau d'évaluation par rapport à son level
    *
    * @param int $level Le level de l'évaluation
    *
    * @author Jimmy Latour <jimmy@evarisk.com>
    *
    * @since 6.0.0.0
    *
    * @return $int value
    */
  public static function get_scale( $level ) {
    if (  true !== is_int( ( int )$level ) )
		  return false;

    $list_scale = evaluation_method_class::g()->list_scale;

    if( empty( $list_scale ) )
			return false;

		$list_ecart = array();
		$list_key = array();

    foreach( $list_scale as $key => $value ) {
			if( $level - $value >= 0 ) {
				$list_ecart[$value] = $level - $value;
        $list_key[$value] = $key;
			}
    }

    $key = 0;
    $value = min( $list_ecart );
    $value = array_search( $value, $list_ecart );
    return $list_key[$value];
	}
}
