<?php
/**
* Dérrogatiosn aux horaires
*
* @author Jimmy Latour <jimmy.latour@gmail.com>
* @version 0.1
* @copyright 2015-2016 Eoxia
* @package society
* @subpackage templates
*/

if ( !defined( 'ABSPATH' ) ) exit; ?>


<ul class="wp-digi-form">
  <li><h2><?php _e( 'Derogations schedules', 'digirisk' ); ?></h2></li>

  <li>
    <label>
      <?php _e( 'Permanent', 'digirisk' ); ?>
      <input name="derogation_schedule[permanent]" type="text" value="<?php echo $legal_display->derogation_schedule['permanent']; ?>" />
    </label>
  </li>
  <li>
    <label>
      <?php _e( 'Occasional', 'digirisk' ); ?>
      <input name="derogation_schedule[occasional]" type="text" value="<?php echo $legal_display->derogation_schedule['occasional']; ?>" />
    </label>
  </li>
</ul>
