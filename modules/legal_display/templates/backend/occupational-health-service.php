<?php
/**
* Service de santé au travail
*
* @author Jimmy Latour <jimmy.latour@gmail.com>
* @version 0.1
* @copyright 2015-2016 Eoxia
* @package society
* @subpackage templates
*/

if ( !defined( 'ABSPATH' ) ) exit; ?>

<h2><?php _e( 'Occupational health service', 'wpdigi-i18n' ); ?></h2>

<ul>
  <li>
    <label>
      <?php _e( 'Full name of compagny doctor', 'wpdigi-i18n' ); ?>
      <input name="occupational_health_service[full_name]" type="text" />
    </label>
  </li>
  <li>
    <label>
      <?php _e( 'Address', 'wpdigi-i18n' ); ?>
      <input name="occupational_health_service[address][address]" type="text" />
    </label>
  </li>
  <li>
    <label>
      <?php _e( 'Postcode', 'wpdigi-i18n' ); ?>
      <input name="occupational_health_service[address][postcode]" type="text" />
    </label>
  </li>
  <li>
    <label>
      <?php _e( 'City', 'wpdigi-i18n' ); ?>
      <input name="occupational_health_service[address][town]" type="text" />
    </label>
  </li>
  <li>
    <label>
      <?php _e( 'Phone', 'wpdigi-i18n' ); ?>
      <input name="occupational_health_service[phone]" type="text" />
    </label>
  </li>
  <li>
    <?php do_shortcode( '[di_opening_time name="occupational_health_service"]' ); ?>
  </li>
</ul>
