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
  <input type="hidden" name="groupment_id" value="<?php echo $element->id; ?>" />
  <?php wp_nonce_field( 'save_groupment_configuration' ); ?>

  <ul class="gridwrapper2">
    <li class="form-element"><label><?php _e( 'Society name', 'wpdigi-i18n' ); ?><input type="text" name="groupement[title]" value="<?php echo $element->title; ?>" /></label></li>
    <li class="form-element"><label><?php _e( 'Address', 'wpdigi-i18n' ); ?> <input type="text" name="address[address]" value="<?php echo $address->option['address']; ?>" /></label></li>
    <li class="form-element">
      <label><?php _e( 'Owner', 'wpdigi-i18n' ); ?> <input type="text" data-target="owner_id" placeholder="<?php _e( 'Write name to search...', 'wpdigi-i18n' ); ?>" data-filter="" class="wpdigi-auto-complete-user" data-element-id="<?php echo $element->id; ?>" value="<?php echo !empty( $user ) ? $user->login : ''; ?>" /></label>
      <input type="hidden" name="owner_id" />
    </li>
    <li class="form-element"><label><?php _e( 'Additional address', 'wpdigi-i18n' ); ?> <input type="text" name="address[additional_address]" value="<?php echo $address->option['additional_address']; ?>" /></label></li>
    <li class="form-element"><label><?php _e( 'Created date', 'wpdigi-i18n' ); ?> <input type="text" class="wpdigi_date" name="groupement[date]" value="<?php echo !empty( $element->date ) ? $element->date : date( 'd/m/Y' ); ?>" /></label></li>
    <li class="form-element"><label><?php _e( 'Postcode', 'wpdigi-i18n' ); ?> <input type="text" name="address[postcode]" value="<?php echo $address->option['postcode']; ?>" /></label></li>
    <li class="form-element"><label><?php _e( 'SIREN', 'wpdigi-i18n' ); ?> <input type="text" name="groupement[option][identity][siren]" value="<?php echo $element->option['identity']['siren']; ?>" /></label></li>
    <li class="form-element"><label><?php _e( 'Town', 'wpdigi-i18n' ); ?> <input type="text" name="address[town]" value="<?php echo $address->option['town']; ?>" /></label></li>
    <li class="form-element"><label><?php _e( 'SIRET', 'wpdigi-i18n' ); ?> <input type="text" name="groupement[option][identity][siret]" value="<?php echo $element->option['identity']['siret']; ?>" /></label></li>
    <li class="form-element"><label><?php _e( 'Phone', 'wpdigi-i18n' ); ?> <input type="text" name="groupement[option][contact][phone]" value="<?php echo $phone; ?>" /></label></li>
  </ul>

  <div class="form-element block"><label><?php _e( 'Description', 'wpdigi-i18n' ); ?><textarea name="groupement[content]"><?php echo $element->content; ?></textarea></label></div>

  <button class="float right wp-digi-bton-fourth"><?php _e( 'Save Changes', 'wpdigi-i18n' ); ?></button>
</form>
