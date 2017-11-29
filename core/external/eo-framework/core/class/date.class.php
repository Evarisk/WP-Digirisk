<?php
/**
 * Méthodes utilitaires pour les dates.
 *
 * @author Jimmy Latour <dev@eoxia.com>
 * @since 0.1.0
 * @version 1.0.0
 * @copyright 2015-2017 Eoxia
 * @package WPEO_Util
 */

namespace eoxia;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! class_exists( '\eoxia\Date_Util' ) ) {

	/**
	 * Méthodes utilitaires pour les dates.
	 */
	class Date_Util extends \eoxia\Singleton_Util {
		/**
		 * Le constructeur obligatoirement pour utiliser la classe \eoxia\Singleton_Util
		 *
		 * @since 0.1.0
		 * @version 1.0.0
		 *
		 * @return void
		 */
		protected function construct() {}

		/**
		 * Renvoie la date au format SQL
		 *
		 * @since 0.1.0
		 * @version 1.0.0
		 *
		 * @param  string $date La date à formater.
		 * @return string      	La date formatée au format SQL
		 *
		 * @todo: Est-ce utile ?
		 */
		public function formatte_date( $date ) {
			if ( strlen( $date ) === 10 ) {
				$date .= ' 00:00:00';
			}

			$date = str_replace( '/', '-', $date );
			$date = date( 'Y-m-d h:i:s', strtotime( $date ) );
			return $date;
		}

		/**
		 * Renvoie la date au format du WordPress de l'utilisateur.
		 *
		 * @since 0.1.0
		 * @version 1.0.0
		 *
		 * @param  string $date La date à formater.
		 * @return string      	La date formatée au format SQL
		 *
		 * @todo: Est-ce utile ?
		 */
		public function mysqldate2wordpress( $date, $with_time = true ) {
			$format = get_option( 'date_format' );
			if ( $with_time ) {
				$format .= ' ' . get_option( 'time_format' );
			}

			return mysql2date( $format, $date );
		}

		/**
		 * Convertis les minutes en un format spécial sur 7h = 1 jour.
		 *
		 * @since 1.0.0
		 * @version 1.0.0
		 *
		 * @param  integer $min               Le nombre de minute.
		 * @param  boolean $display_full_min  Si oui, affiches $min entre paranthèse.
		 *
		 * @return string                     La date formatée.
		 */
		public function convert_to_custom_hours( $min, $display_full_min = true ) {
			$minut_for_one_day = \eoxia\Config_Util::$init['eo-framework']->hour_equal_one_day * 60;
			$day = intval( $min / $minut_for_one_day );

			$sub_min = $min - ( $day * $minut_for_one_day );
			$hour = intval( $sub_min / 60 );
			$clone_min = intval( $sub_min - ( $hour * 60 ) );

			$display = $day . 'j ' . $hour . 'h ' . $clone_min . 'min';

			if ( $display_full_min ) {
				$display .= ' (' . $min . 'min)';
			}

			return $display;
		}
	}
} // End if().
