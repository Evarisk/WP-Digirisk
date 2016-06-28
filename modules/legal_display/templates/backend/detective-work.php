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

<ul class="wp-digi-form">
  <li><h2><?php _e( 'Detective work', 'wpdigi-i18n' ); ?></h2></li>
  <li>
    <label>
      <?php _e( 'Last name and first name', 'wpdigi-i18n' ); ?>
      <input name="detective_work[full_name]" type="text" value="<?php echo $data['detective_work']->option['full_name']; ?>" />
    </label>
  </li>
  <li>
    <label>
      <?php _e( 'Address', 'wpdigi-i18n' ); ?>
      <input name="detective_work[address][address]" type="text" value="<?php echo $data['detective_work']->address->option['address']; ?>" />
    </label>
  </li>
  <li>
    <label>
      <?php _e( 'Postcode', 'wpdigi-i18n' ); ?>
      <input name="detective_work[address][postcode]" type="text" value="<?php echo $data['detective_work']->address->option['postcode']; ?>" />
    </label>
  </li>
  <li>
    <label>
      <?php _e( 'City', 'wpdigi-i18n' ); ?>
      <input name="detective_work[address][town]" type="text" value="<?php echo $data['detective_work']->address->option['town']; ?>" />
    </label>
  </li>
  <li>
    <label>
      <?php _e( 'Phone', 'wpdigi-i18n' ); ?>
      <input name="detective_work[contact][phone]" type="text" value="<?php echo $data['detective_work']->option['contact']['phone'][0]; ?>" />
    </label>
  </li>
  <li>
    <label>
      <?php _e( 'Horaires', 'wpdigi-i18n' ); ?>
      <input name="detective_work[opening_time]" type="text" value="<?php echo $data['detective_work']->option['opening_time']; ?>"/>
    </label>
  </li>
</ul>
