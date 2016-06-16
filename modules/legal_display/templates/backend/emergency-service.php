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

<h2><?php _e( 'Emergency service', 'wpdigi-i18n' ); ?></h2>

<ul>
  <li>
    <label>
      <?php _e( 'Emergency', 'wpdigi-i18n' ); ?>
      <input name="emergency_service[emergency]" type="text" />
    </label>
  </li>
  <li>
    <label>
      <?php _e( 'Rights defender', 'wpdigi-i18n' ); ?>
      <input name="emergency_service[right_defender]" type="text" />
    </label>
  </li>
  <li>
    <label>
      <?php _e( 'Poison control center', 'wpdigi-i18n' ); ?>
      <input name="emergency_service[poison_control_center]" type="text" />
    </label>
  </li>
</ul>
