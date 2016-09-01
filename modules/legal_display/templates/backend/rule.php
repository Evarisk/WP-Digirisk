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
  <li><h2><?php _e( 'Rules', 'digirisk' ); ?></h2></li>
  <li>
    <label>
      <?php _e( 'location', 'digirisk' ); ?>
      <input name="rules[location]" type="text" value="<?php echo $legal_display->rules['location']; ?>" />
    </label>
  </li>
</ul>
