<?php
/**
* Consignes de sécurité
*
* @author Jimmy Latour <jimmy.latour@gmail.com>
* @version 0.1
* @copyright 2015-2016 Eoxia
* @package society
* @subpackage templates
*/

if ( !defined( 'ABSPATH' ) ) exit; ?>

<h2><?php _e( 'Safety rules', 'wpdigi-i18n' ); ?></h2>

<ul>
  <li>
    <label>
      <?php _e( 'Responsible for preventing', 'wpdigi-i18n' ); ?>
      <input name="safety_rule[responsible_for_preventing]" type="text" />
    </label>
  </li>
  <li>
    <label>
      <?php _e( 'Phone', 'wpdigi-i18n' ); ?>
      <input name="safety_rule[phone]" type="text" />
    </label>
  </li>
  <li>
    <label>
      <?php _e( 'Location of detailed instructions', 'wpdigi-i18n' ); ?>
      <input name="safety_rule[location_of_detailed_instruction]" type="text" />
    </label>
  </li>
</ul>
