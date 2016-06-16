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

<h2><?php _e( 'Derogations schedules', 'wpdigi-i18n' ); ?></h2>

<ul>
  <li>
    <label>
      <?php _e( 'Permanent', 'wpdigi-i18n' ); ?>
      <input name="derogation_schedule[permanent]" type="text" />
    </label>
  </li>
  <li>
    <label>
      <?php _e( 'Occasional', 'wpdigi-i18n' ); ?>
      <input name="derogation_schedule[occasional]" type="text" />
    </label>
  </li>
</ul>
