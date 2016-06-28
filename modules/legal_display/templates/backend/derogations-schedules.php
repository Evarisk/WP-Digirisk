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
  <li><h2><?php _e( 'Derogations schedules', 'wpdigi-i18n' ); ?></h2></li>

  <li>
    <label>
      <?php _e( 'Permanent', 'wpdigi-i18n' ); ?>
      <input name="derogation_schedule[permanent]" type="text" value="<?php echo $data['legal_display']->option['derogation_schedule']['permanent']; ?>" />
    </label>
  </li>
  <li>
    <label>
      <?php _e( 'Occasional', 'wpdigi-i18n' ); ?>
      <input name="derogation_schedule[occasional]" type="text" value="<?php echo $data['legal_display']->option['derogation_schedule']['occasional']; ?>" />
    </label>
  </li>
</ul>
