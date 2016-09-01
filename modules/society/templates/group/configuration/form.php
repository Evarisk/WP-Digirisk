<?php
/**
* Le formulaire pour configurer un groupement
*
* @author Jimmy Latour <jimmy.latour@gmail.com>
* @version 0.1
* @copyright 2015-2016 Eoxia
* @package society
* @subpackage templates
*/

if ( !defined( 'ABSPATH' ) ) exit; ?>

<form method="POST" class="wp-digi-form wp-digi-form-save-configuration" action="<?php echo admin_url( 'admin-ajax.php' ); ?>">
  <input type="hidden" name="action" value="save_groupment_configuration" />
  <input type="hidden" name="groupment[id]" value="<?php echo $element->id; ?>" />
  <input type="hidden" name="address[post_id]" value="<?php echo $element->id; ?>" />
  <?php wp_nonce_field( 'save_groupment_configuration' ); ?>

  <ul class="gridwrapper2">
    <li class="form-element"><label><?php _e( 'Society name', 'digirisk' ); ?><input type="text" name="groupment[title]" value="<?php echo $element->title; ?>" /></label></li>
    <li class="form-element"><label><?php _e( 'Address', 'digirisk' ); ?> <input type="text" name="address[address]" value="<?php echo $element->address[0]->address; ?>" /></label></li>
    <li class="form-element">
      <label><?php _e( 'Owner', 'digirisk' ); ?> <input type="text" data-target="owner_id" placeholder="<?php _e( 'Write name to search...', 'digirisk' ); ?>" data-filter="" class="wpdigi-auto-complete-user" data-element-id="<?php echo $element->id; ?>" value="<?php echo !empty( $user ) ? $user->login : ''; ?>" /></label>
      <input type="hidden" name="groupment[user_info][owner_id]" />
    </li>
    <li class="form-element"><label><?php _e( 'Additional address', 'digirisk' ); ?> <input type="text" name="address[additional_address]" value="<?php echo $element->address[0]->additional_address; ?>" /></label></li>
    <li class="form-element"><label><?php _e( 'Created date', 'digirisk' ); ?> <input type="text" class="wpdigi_date" name="groupment[date]" value="<?php echo !empty( $element->date ) ? $element->date : date( 'd/m/Y' ); ?>" /></label></li>
    <li class="form-element"><label><?php _e( 'Postcode', 'digirisk' ); ?> <input type="text" name="address[postcode]" value="<?php echo $element->address[0]->postcode; ?>" /></label></li>
    <li class="form-element"><label><?php _e( 'SIREN', 'digirisk' ); ?> <input type="text" name="groupment[identity][siren]" value="<?php echo $element->identity['siren']; ?>" /></label></li>
    <li class="form-element"><label><?php _e( 'Town', 'digirisk' ); ?> <input type="text" name="address[town]" value="<?php echo $element->address[0]->town; ?>" /></label></li>
    <li class="form-element"><label><?php _e( 'SIRET', 'digirisk' ); ?> <input type="text" name="groupment[identity][siret]" value="<?php echo $element->identity['siret']; ?>" /></label></li>
    <li class="form-element"><label><?php _e( 'Phone', 'digirisk' ); ?> <input type="text" name="groupment[contact][phone][]" value="<?php echo max( $element->contact['phone'] ); ?>" /></label></li>
  </ul>

  <div class="form-element block"><label><?php _e( 'Description', 'digirisk' ); ?><textarea name="groupment[content]"><?php echo $element->content; ?></textarea></label></div>

  <button class="float right wp-digi-bton-fourth"><?php _e( 'Save Changes', 'digirisk' ); ?></button>
</form>
