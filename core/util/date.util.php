<?php
/**
 * Gestion des dates
 *
 * @package Evarisk\Plugin
 */

namespace digi;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Gestion des dates
 *
 * @author Jimmy Latour <jimmy.eoxia@gmail.com>
 * @version 1.1.0.0
 */
class Date_util extends Singleton_util {
	/**
	 * Le constructeur obligatoirement pour utiliser la classe Singleton_util
	 *
	 * @return void nothing
	 */
	protected function construct() {}

	/**
	 * Renvoie la date au format SQL
	 *
	 * @param  string $date La date à formater.
	 * @return string      	La date formatée au format SQL
	 */
	public function formatte_date( $date ) {
		if ( strlen( $date ) === 10 ) {
			$date .= ' 00:00:00';
		}

		$date = str_replace( '/', '-', $date );
		$date = date( 'Y-m-d h:i:s', strtotime( $date ) );
		return $date;
	}
}
