<?php
/**
 * Gestion des tableaux
 *
 * @package Evarisk\Plugin
 */

namespace digi;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Gestion des tableaux
 *
 * @author Jimmy Latour <jimmy.eoxia@gmail.com>
 * @version 1.1.0.0
 */
class Array_util extends Singleton_util {
	/**
	 * Le constructeur obligatoirement pour utiliser la classe Singleton_util
	 *
	 * @return void nothing
	 */
	protected function construct() {}

	/**
	 * Compte le nombre de valeur dans un tableau avec récursivité en vérifiant que $match_element soit dans la valeur
	 *
	 * @param  array   $array         Les données à compter.
	 * @param  boolean $start         ?.
	 * @param  array   $match_element Les données à vérifier.
	 * @return int                 		Le nombre d'entrée
	 */
	public function count_recursive( $array, $start = true, $match_element = array() ) {
		$count = 0;

		if ( $start ) {
			$count = count( $array );
		}

		if ( ! empty( $array ) ) {
			foreach ( $array as $id => $_array ) {
				if ( is_array( $_array ) ) {
					if ( is_string( $id ) && ! empty( $match_element ) && in_array( $id, $match_element, true ) ) {
						$count += count( $_array );
					}

					$count += $this->count_recursive( $_array, false, $match_element );
				}
			}
		}

		return $count;
	}
}
