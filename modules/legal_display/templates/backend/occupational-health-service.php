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


<ul class="wp-digi-form">
  <li><h2><?php _e( 'Occupational health service', 'wpdigi-i18n' ); ?></h2></li>

  <li>
    <label>
      <?php _e( 'Full name of compagny doctor', 'wpdigi-i18n' ); ?>
      <input name="occupational_health_service[full_name]" type="text" value="<?php echo $data['occupational_health_service']->option['full_name']; ?>" />
    </label>
  </li>
  <li>
    <label>
      <?php _e( 'Address', 'wpdigi-i18n' ); ?>
      <input name="occupational_health_service[address][address]" type="text" value="<?php echo $data['occupational_health_service']->address->option['address']; ?>" />
    </label>
  </li>
  <li>
    <label>
      <?php _e( 'Postcode', 'wpdigi-i18n' ); ?>
      <input name="occupational_health_service[address][postcode]" type="text" value="<?php echo $data['occupational_health_service']->address->option['postcode']; ?>" />
    </label>
  </li>
  <li>
    <label>
      <?php _e( 'City', 'wpdigi-i18n' ); ?>
      <input name="occupational_health_service[address][town]" type="text" value="<?php echo $data['occupational_health_service']->address->option['town']; ?>" />
    </label>
  </li>
  <li>
    <label>
      <?php _e( 'Phone', 'wpdigi-i18n' ); ?>
      <input name="occupational_health_service[contact][phone]" type="text" value="<?php echo $data['occupational_health_service']->option['contact']['phone'][0]; ?>" />
    </label>
  </li>
  <li>
    <label>
      <?php _e( 'Horaires', 'wpdigi-i18n' ); ?>
      <input name="occupational_health_service[opening_time]" type="text" value="<?php echo $data['occupational_health_service']->option['opening_hour']; ?>" />
    </label>
  </li>
</ul>
