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

<ul class="wp-digi-form">
  <li>
    <h2><?php _e( 'Working hours', 'wpdigi-i18n' ); ?></h2>
  </li>

  <li>
    <?php do_shortcode( '[di_opening_time name="working_hours" checkbox="true"]' ); ?>
  </li>
</ul>
