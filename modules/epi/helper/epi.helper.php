<?php
/**
* @TODO : A Détailler
*
* @author Jimmy Latour <jimmy.latour@gmail.com>
* @version 0.1
* @copyright 2015-2016 Eoxia
* @package epi
* @subpackage helper
*/

if ( !defined( 'ABSPATH' ) ) exit;

function update_remaining_time( $data ) {
	if ( !empty( $data->frequency_control ) && !empty( $data->control_date ) ) {
		$control_date = DateTime::createFromFormat( 'd/m/Y', $data->control_date );
		$control_date->modify( '+' . $data->frequency_control . ' day' );

		$date_now = DateTime::createFromFormat( 'd/m/Y', current_time( 'd/m/Y' ) );
		$interval = $date_now->diff( $control_date );

		// $result = '';
		//
		// if ( $interval->format( '%R' ) === '+' ) {
		// 	$result = 'A controller dans ';
		// }
		// else {
		// 	$result = 'Non controlé depuis ';
		// }

		// $result .= $interval->format( '%R%a jours' );

		$data->compiled_remaining_time = $interval->format( '%R%a jours' );
	}

	return $data;
}
