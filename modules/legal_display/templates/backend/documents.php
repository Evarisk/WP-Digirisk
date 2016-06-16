<?php
/**
* Documents
*
* @author Jimmy Latour <jimmy.latour@gmail.com>
* @version 0.1
* @copyright 2015-2016 Eoxia
* @package society
* @subpackage templates
*/

if ( !defined( 'ABSPATH' ) ) exit; ?>

<h2><?php _e( 'Documents', 'wpdigi-i18n' ); ?></h2>

<ul>
  <li>
    <label>
      <?php _e( 'Title of the applicable collective agreement', 'wpdigi-i18n' ); ?>
      <input required name="document[title_of_the_applicable_collective_agreement]" type="text" />
    </label>
  </li>
  <li>
    <label>
      <?php _e( 'Location and access terms of the agreement', 'wpdigi-i18n' ); ?>
      <input required name="document[location_and_access_terms_of_the_agreement]" type="text" />
    </label>
  </li>
  <li>
    <label>
      <?php _e( 'The rules of procedure display location', 'wpdigi-i18n' ); ?>
      <input required name="document[the_rule_of_procedure_display_location]" type="text" />
    </label>
  </li>
  <li>
    <label>
      <?php _e( 'How access to DUER', 'wpdigi-i18n' ); ?>
      <input required name="document[how_access_to_duer]" type="text" />
    </label>
  </li>
</ul>
