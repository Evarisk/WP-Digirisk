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


<ul class="wp-digi-form">
  <li><h2><?php _e( 'Safety rules', 'digirisk' ); ?></h2></li>

  <li>
    <label>
      <?php _e( 'Responsible for preventing', 'digirisk' ); ?>
      <input name="safety_rule[responsible_for_preventing]" type="text" value="<?php echo $legal_display->safety_rule['responsible_for_preventing']; ?>" />
    </label>
  </li>
  <li>
    <label>
      <?php _e( 'Phone', 'digirisk' ); ?>
      <input name="safety_rule[phone]" type="text" value="<?php echo $legal_display->safety_rule['phone']; ?>" />
    </label>
  </li>
  <li>
    <label>
      <?php _e( 'Location of detailed instructions', 'digirisk' ); ?>
      <input name="safety_rule[location_of_detailed_instruction]" type="text" value="<?php echo $legal_display->safety_rule['location_of_detailed_instruction']; ?>" />
    </label>
  </li>
</ul>
