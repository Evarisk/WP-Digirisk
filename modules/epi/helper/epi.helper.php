<?php namespace digi;
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

		$result = '';

		if ( $interval->format( '%R' ) === '+' ) {
			$result = '<span class=\'time-ok\'><i class=\'fa fa-calendar-o\' aria-hidden=\'true\'></i> ';
			$result .= $interval->format( '%a jours' );
			$result .= '</span>';
		}
		else {
			$result = '<span class=\'time-past\'><i class=\'fa fa-calendar-times-o\' aria-hidden=\'true\'></i> ';
			$result .= $interval->format( '%a jours' );
			$result .= '</span>';
		}


		$data->compiled_remaining_time = $result;
	}

	return $data;
}
