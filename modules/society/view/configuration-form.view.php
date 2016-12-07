<?php
/**
 * Le formulaire pour configurer un groupement
 *
 * @author Jimmy Latour <jimmy@evarisk.com>
 * @version 6.2.1.0
 * @copyright 2015-2016 Eoxia
 * @package group
 * @subpackage view
 */

namespace digi;


if ( ! defined( 'ABSPATH' ) ) { exit; } ?>

<form method="POST" class="wp-digi-form wp-digi-form-save-configuration" action="<?php echo esc_attr( admin_url( 'admin-ajax.php' ) ); ?>">
	<input type="hidden" name="action" value="save_groupment_configuration" />
	<input type="hidden" name="groupment[id]" value="<?php echo esc_attr( $element->id ); ?>" />
	<input type="hidden" name="address[post_id]" value="<?php echo esc_attr( $element->id ); ?>" />
	<?php wp_nonce_field( 'save_groupment_configuration' ); ?>

	<ul class="gridwrapper2">
		<li class="form-element"><label><?php esc_html_e( 'Nom', 'digirisk' ); ?><input type="text" name="groupment[title]" value="<?php echo esc_attr( $element->title ); ?>" /></label></li>
		<li class="form-element"><label><?php esc_html_e( 'Address', 'digirisk' ); ?> <input type="text" name="address[address]" value="<?php echo esc_attr( $address->address ); ?>" /></label></li>
		<li class="form-element">
			<label><?php esc_html_e( 'Owner', 'digirisk' ); ?>
				<input type="text"
							data-field="groupment[user_info][owner_id]"
							data-type="user"
							placeholder="<?php esc_html_e( 'Write name to search...', 'digirisk' ); ?>"
							class="digi-search"
							value="<?php echo esc_attr( $owner_user->login ); ?>" /></label>
				<input type="hidden" name="groupment[user_info][owner_id]" value="<?php echo esc_attr( $owner_user->id ); ?>" />
		</li>
		<li class="form-element"><label><?php esc_html_e( 'Additional address', 'digirisk' ); ?> <input type="text" name="address[additional_address]" value="<?php echo esc_attr( $address->additional_address ); ?>" /></label></li>
		<li class="form-element"><label><?php esc_html_e( 'Created date', 'digirisk' ); ?> <input type="text" class="eva-date" name="groupment[date]" value="<?php echo esc_attr( ! empty( $element->date ) ? $element->date : date( 'd/m/Y' ) ); ?>" /></label></li>
		<li class="form-element"><label><?php esc_html_e( 'Postcode', 'digirisk' ); ?> <input type="text" name="address[postcode]" value="<?php echo esc_attr( $address->postcode ); ?>" /></label></li>
		<li class="form-element"><label><?php esc_html_e( 'Town', 'digirisk' ); ?> <input type="text" name="address[town]" value="<?php echo esc_attr( $address->town ); ?>" /></label></li>
		<li class="form-element"><label><?php esc_html_e( 'Phone', 'digirisk' ); ?> <input type="text" name="groupment[contact][phone][]" value="<?php echo esc_attr( max( $element->contact['phone'] ) ); ?>" /></label></li>
	</ul>

	<div class="form-element block"><label><?php esc_html_e( 'Description', 'digirisk' ); ?><textarea name="groupment[content]"><?php echo esc_html( $element->content ); ?></textarea></label></div>

	<button class="float right wp-digi-bton-fourth submit-form"><?php esc_html_e( 'Save Changes', 'digirisk' ); ?></button>
</form>
