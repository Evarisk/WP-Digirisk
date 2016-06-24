<?php
/**
* Horaires de travail
*
* @author Jimmy Latour <jimmy.latour@gmail.com>
* @version 0.1
* @copyright 2015-2016 Eoxia
* @package society
* @subpackage templates
*/

if ( !defined( 'ABSPATH' ) ) exit; ?>

<h2><?php _e( 'Working hours', 'wpdigi-i18n' ); ?></h2>


<ul class="wp-digi-table">

  <li class="wp-digi-table-header">
    <span></span>
    <span><?php _e( 'Monday', 'wpdigi-i18n' ); ?></span>
    <span><?php _e( 'Tuesday', 'wpdigi-i18n' ); ?></span>
    <span><?php _e( 'Wednesday', 'wpdigi-i18n' ); ?></span>
    <span><?php _e( 'Thursday', 'wpdigi-i18n' ); ?></span>
    <span><?php _e( 'Friday', 'wpdigi-i18n' ); ?></span>
    <span><?php _e( 'Saturday', 'wpdigi-i18n' ); ?></span>
    <span><?php _e( 'Sunday', 'wpdigi-i18n' ); ?></span>
  </li>

  <li class="wp-digi-list-item">
    <span><?php _e( 'Morning', 'wpdigi-i18n' ); ?></span>
    <span><input type="text" name="working_hour[monday_morning]" /></span>
    <span><input type="text" name="working_hour[tuesday_morning]" /></span>
    <span><input type="text" name="working_hour[wednesday_morning]" /></span>
    <span><input type="text" name="working_hour[thursday_morning]" /></span>
    <span><input type="text" name="working_hour[friday_morning]" /></span>
    <span><input type="text" name="working_hour[saturday_morning]" /></span>
    <span><input type="text" name="working_hour[sunday_morning]" /></span>
  </li>

  <li class="wp-digi-list-item">
    <span><?php _e( 'Morning', 'wpdigi-i18n' ); ?></span>
    <span><input type="text" name="working_hour[monday_afternoon]" /></span>
    <span><input type="text" name="working_hour[tuesday_afternoon]" /></span>
    <span><input type="text" name="working_hour[wednesday_afternoon]" /></span>
    <span><input type="text" name="working_hour[thursday_afternoon]" /></span>
    <span><input type="text" name="working_hour[friday_afternoon]" /></span>
    <span><input type="text" name="working_hour[saturday_afternoon]" /></span>
    <span><input type="text" name="working_hour[sunday_afternoon]" /></span>
  </li>

</ul>
