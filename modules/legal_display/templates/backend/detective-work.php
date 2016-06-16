<?php
/**
* Inspecteur du travail
*
* @author Jimmy Latour <jimmy.latour@gmail.com>
* @version 0.1
* @copyright 2015-2016 Eoxia
* @package society
* @subpackage templates
*/

if ( !defined( 'ABSPATH' ) ) exit; ?>

<h2><?php _e( 'Detective work', 'wpdigi-i18n' ); ?></h2>

<ul>
  <li>
    <label>
      <?php _e( 'Last name and first name', 'wpdigi-i18n' ); ?>
      <input required name="detective_work[full_name]" type="text" />
    </label>
  </li>
  <li>
    <label>
      <?php _e( 'Address', 'wpdigi-i18n' ); ?>
      <input required name="detective_work[address][address]" type="text" />
    </label>
  </li>
  <li>
    <label>
      <?php _e( 'Postcode', 'wpdigi-i18n' ); ?>
      <input required name="detective_work[address][postcode]" type="text" />
    </label>
  </li>
  <li>
    <label>
      <?php _e( 'City', 'wpdigi-i18n' ); ?>
      <input required name="detective_work[address][town]" type="text" />
    </label>
  </li>
  <li>
    <label>
      <?php _e( 'Phone', 'wpdigi-i18n' ); ?>
      <input required pattern="^0[0-9]([-. ]?\d{2}){4}[-. ]?$" name="detective_work[contact][phone]" type="text" />
    </label>
  </li>
  <li>
    <?php do_shortcode( '[di_opening_time name="detective_work"]' ); ?>
  </li>
</ul>
