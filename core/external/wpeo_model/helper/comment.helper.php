<?php
namespace digi;
if ( !defined( 'ABSPATH' ) ) exit;

function construct_current_date( $data ) {
  $data->date = current_time( 'd/m/Y' );

  return $data;
}
