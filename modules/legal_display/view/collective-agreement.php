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
  <li><h2><?php _e( 'Collective agreement', 'digirisk' ); ?></h2></li>
  <li>
    <label>
      <?php _e( 'Title of the applicable collective agreement', 'digirisk' ); ?>
      <input name="collective_agreement[title_of_the_applicable_collective_agreement]" type="text" value="<?php echo $legal_display->collective_agreement['title_of_the_applicable_collective_agreement']; ?>" />
    </label>
  </li>
  <li>
    <label>
      <?php _e( 'Location and access terms of the agreement', 'digirisk' ); ?>
      <input name="collective_agreement[location_and_access_terms_of_the_agreement]" type="text" value="<?php echo $legal_display->collective_agreement['location_and_access_terms_of_the_agreement']; ?>" />
    </label>
  </li>
</ul>
