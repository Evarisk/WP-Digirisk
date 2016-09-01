<?php
/**
* Service d'urgence
*
* @author Jimmy Latour <jimmy.latour@gmail.com>
* @version 0.1
* @copyright 2015-2016 Eoxia
* @package society
* @subpackage templates
*/

if ( !defined( 'ABSPATH' ) ) exit; ?>

<ul class="wp-digi-form">
  <li><h2><?php _e( 'Emergency service', 'digirisk' ); ?></h2></li>
  <li>
    <label>
      <?php _e( 'Samu', 'digirisk' ); ?>
      <input name="emergency_service[samu]" type="text" value="<?php echo $legal_display->emergency_service['samu']; ?>" />
    </label>
  </li>
  <li>
    <label>
      <?php _e( 'Police/Gendarmerie', 'digirisk' ); ?>
      <input name="emergency_service[police]" type="text" value="<?php echo $legal_display->emergency_service['police']; ?>" />
    </label>
  </li>
  <li>
    <label>
      <?php _e( 'Pompiers', 'digirisk' ); ?>
      <input name="emergency_service[pompier]" type="text" value="<?php echo $legal_display->emergency_service['pompier']; ?>" />
    </label>
  </li>
  <li>
    <label>
      <?php _e( 'Emergency', 'digirisk' ); ?>
      <input name="emergency_service[emergency]" type="text" value="<?php echo $legal_display->emergency_service['emergency']; ?>" />
    </label>
  </li>
  <li>
    <label>
      <?php _e( 'Rights defender', 'digirisk' ); ?>
      <input name="emergency_service[right_defender]" type="text" value="<?php $legal_display->emergency_service['right_defender']; ?>" />
    </label>
  </li>
  <li>
    <label>
      <?php _e( 'Poison control center', 'digirisk' ); ?>
      <input name="emergency_service[poison_control_center]" type="text" value="<?php $legal_display->emergency_service['poison_control_center']; ?>"  />
    </label>
  </li>
</ul>
