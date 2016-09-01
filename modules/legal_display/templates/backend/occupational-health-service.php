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
  <li><h2><?php _e( 'Occupational health service', 'digirisk' ); ?></h2></li>

  <li>
    <label>
      <?php _e( 'Full name of compagny doctor', 'digirisk' ); ?>
      <input name="occupational_health_service[full_name]" type="text" value="<?php echo $legal_display->occupational_health_service[0]->full_name; ?>" />
    </label>
  </li>
  <li>
    <label>
      <?php _e( 'Address', 'digirisk' ); ?>
      <input name="occupational_health_service[address][address]" type="text" value="<?php echo $legal_display->occupational_health_service[0]->address[0]->address; ?>" />
    </label>
  </li>
  <li>
    <label>
      <?php _e( 'Postcode', 'digirisk' ); ?>
      <input name="occupational_health_service[address][postcode]" type="text" value="<?php echo $legal_display->occupational_health_service[0]->address[0]->postcode; ?>" />
    </label>
  </li>
  <li>
    <label>
      <?php _e( 'City', 'digirisk' ); ?>
      <input name="occupational_health_service[address][town]" type="text" value="<?php echo $legal_display->occupational_health_service[0]->address[0]->town; ?>" />
    </label>
  </li>
  <li>
    <label>
      <?php _e( 'Phone', 'digirisk' ); ?>
      <input name="occupational_health_service[contact][phone]" type="text" value="<?php echo $legal_display->occupational_health_service[0]->contact['phone']; ?>" />
    </label>
  </li>
  <li>
    <label>
      <?php _e( 'Horaires', 'digirisk' ); ?>
      <input name="occupational_health_service[opening_time]" type="text" value="<?php echo $legal_display->occupational_health_service[0]->opening_time; ?>" />
    </label>
  </li>
</ul>
