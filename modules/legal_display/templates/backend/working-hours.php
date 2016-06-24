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
    <span><?php _e( 'Période', 'wpdigi-i18n' ); ?></span>
    <span><?php _e( 'Monday', 'wpdigi-i18n' ); ?></span>
    <span><?php _e( 'Thursday', 'wpdigi-i18n' ); ?></span>
    <span><?php _e( 'Wedenesday', 'wpdigi-i18n' ); ?></span>
    <span><?php _e( 'Thursday', 'wpdigi-i18n' ); ?></span>
    <span><?php _e( 'Friday', 'wpdigi-i18n' ); ?></span>
    <span><?php _e( 'Saturday', 'wpdigi-i18n' ); ?></span> 
    <span><?php _e( 'Friday', 'wpdigi-i18n' ); ?></span>
  </li>

  <li class="wp-digi-list-item">
    <span><?php _e( 'Morning', 'wpdigi-i18n' ); ?></span>
    <span><input type="text" /></span>
    <span><input type="text" /></span>
    <span><input type="text" /></span>
    <span><input type="text" /></span>
    <span><input type="text" /></span>
    <span><input type="text" /></span>
    <span><input type="text" /></span>
  </li>

  <li class="wp-digi-list-item">
    <span><?php _e( 'Afternoon', 'wpdigi-i18n' ); ?></span>
    <span><input type="text" /></span>
    <span><input type="text" /></span>
    <span><input type="text" /></span>
    <span><input type="text" /></span>
    <span><input type="text" /></span>
    <span><input type="text" /></span>
    <span><input type="text" /></span>
  </li>

</ul>