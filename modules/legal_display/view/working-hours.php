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

<h2><?php _e( 'Working hours', 'digirisk' ); ?></h2>


<ul class="wp-digi-table">

  <li class="wp-digi-table-header">
    <span></span>
    <span><?php _e( 'Monday', 'digirisk' ); ?></span>
    <span><?php _e( 'Tuesday', 'digirisk' ); ?></span>
    <span><?php _e( 'Wednesday', 'digirisk' ); ?></span>
    <span><?php _e( 'Thursday', 'digirisk' ); ?></span>
    <span><?php _e( 'Friday', 'digirisk' ); ?></span>
    <span><?php _e( 'Saturday', 'digirisk' ); ?></span>
    <span><?php _e( 'Sunday', 'digirisk' ); ?></span>
  </li>

  <li class="wp-digi-list-item">
    <span><?php _e( 'Morning', 'digirisk' ); ?></span>
    <span><input type="text" name="working_hour[monday_morning]" value="<?php echo $legal_display->working_hour['monday_morning']; ?>" /></span>
    <span><input type="text" name="working_hour[tuesday_morning]" value="<?php echo $legal_display->working_hour['tuesday_morning']; ?>" /></span>
    <span><input type="text" name="working_hour[wednesday_morning]" value="<?php echo $legal_display->working_hour['wednesday_morning']; ?>" /></span>
    <span><input type="text" name="working_hour[thursday_morning]" value="<?php echo $legal_display->working_hour['thursday_morning']; ?>" /></span>
    <span><input type="text" name="working_hour[friday_morning]" value="<?php echo $legal_display->working_hour['friday_morning']; ?>" /></span>
    <span><input type="text" name="working_hour[saturday_morning]" value="<?php echo $legal_display->working_hour['saturday_morning']; ?>" /></span>
    <span><input type="text" name="working_hour[sunday_morning]" value="<?php echo $legal_display->working_hour['sunday_morning']; ?>" /></span>
  </li>

  <li class="wp-digi-list-item">
    <span><?php _e( 'Afternoon', 'digirisk' ); ?></span>
    <span><input type="text" name="working_hour[monday_afternoon]" value="<?php echo $legal_display->working_hour['monday_afternoon']; ?>" /></span>
    <span><input type="text" name="working_hour[tuesday_afternoon]" value="<?php echo $legal_display->working_hour['tuesday_afternoon']; ?>" /></span>
    <span><input type="text" name="working_hour[wednesday_afternoon]" value="<?php echo $legal_display->working_hour['wednesday_afternoon']; ?>" /></span>
    <span><input type="text" name="working_hour[thursday_afternoon]" value="<?php echo $legal_display->working_hour['thursday_afternoon']; ?>" /></span>
    <span><input type="text" name="working_hour[friday_afternoon]" value="<?php echo $legal_display->working_hour['friday_afternoon']; ?>" /></span>
    <span><input type="text" name="working_hour[saturday_afternoon]" value="<?php echo $legal_display->working_hour['saturday_afternoon']; ?>" /></span>
    <span><input type="text" name="working_hour[sunday_afternoon]" value="<?php echo $legal_display->working_hour['sunday_afternoon']; ?>" /></span>
  </li>

</ul>
