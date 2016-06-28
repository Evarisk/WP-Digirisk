<?php
/**
* Documents
*
* @author Jimmy Latour <jimmy.latour@gmail.com>
* @version 0.1
* @copyright 2015-2016 Eoxia
* @package legal_display
* @subpackage templates
*/

if ( !defined( 'ABSPATH' ) ) exit; ?>


<ul class="wp-digi-form">
  <li><h2><?php _e( 'Rules', 'wpdigi-i18n' ); ?></h2></li>
  <li>
    <label>
      <?php _e( 'location', 'wpdigi-i18n' ); ?>
      <input name="rules[location]" type="text" value="<?php echo $data['legal_display']->option['rules']['location']; ?>" />
    </label>
  </li>
</ul>
