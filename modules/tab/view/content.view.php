<?php
/**
* Call the shortcode by her identity
*
* @author Jimmy Latour <jimmy.latour@gmail.com>
* @version 0.1
* @copyright 2015-2016 Eoxia
* @package establishment
* @subpackage view
*/
if ( !defined( 'ABSPATH' ) ) exit; ?>

<div class="wp-digi-content wp-digi-bloc-loader">
  <?php echo do_shortcode( '[' . $tab_to_display . ' post_id="' . $element->id . '" ]' ); ?>
</div>
