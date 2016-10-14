<?php
namespace digi;
if ( !defined( 'ABSPATH' ) ) exit;

function construct_current_date( $data ) {
  $data->date = !empty( $data->date ) ? date( 'd/m/Y', strtotime( $data->date ) ) : current_time( 'd/m/Y' );

  return $data;
}
