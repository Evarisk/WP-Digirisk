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
  <li><h2><?php _e( 'DUER', 'digirisk' ); ?></h2></li>
  <li>
    <label>
      <?php _e( 'How access to duer', 'digirisk' ); ?>
      <input name="DUER[how_access_to_duer]" type="text" value="<?php echo $legal_display->DUER['how_access_to_duer']; ?>" />
    </label>
  </li>
</ul>
