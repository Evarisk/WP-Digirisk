<?php
/**
 * Le formulaire pour configurer un groupement
 *
 * @author Jimmy Latour <jimmy@evarisk.com>
 * @since 6.2.1.0
 * @version 6.2.4.0
 * @copyright 2015-2017 Evarisk
 * @package society
 * @subpackage view
 */

namespace digi;


if ( ! defined( 'ABSPATH' ) ) { exit; } ?>

<form method="POST" class="form" action="<?php echo esc_attr( admin_url( 'admin-ajax.php' ) ); ?>">
	<input type="hidden" name="action" value="save_groupment_configuration" />
	<input type="hidden" name="groupment[id]" value="<?php echo esc_attr( $element->id ); ?>" />
	<input type="hidden" name="address[post_id]" value="<?php echo esc_attr( $element->id ); ?>" />
	<?php wp_nonce_field( 'save_groupment_configuration' ); ?>

	<ul class="grid-layout w2">
		<li class="form-element <?php echo esc_attr( ! empty( $element->title ) ? 'active' : '' ); ?>">
			<input name="groupment[title]" type="text" value="<?php echo esc_attr( $element->title ); ?>" />
			<label><?php esc_html_e( 'Nom', 'digirisk' ); ?></label>
			<span class="bar"></span>
		</li>

		<li class="form-element <?php echo esc_attr( ! empty( $address->address ) ? 'active' : '' ); ?>">
			<input name="address[address]" type="text" value="<?php echo esc_attr( $address->address ); ?>" />
			<label><?php esc_html_e( 'Adresse', 'digirisk' ); ?></label>
			<span class="bar"></span>
		</li>

		<li class="form-element <?php echo esc_attr( ! empty( $owner_user->id ) ? 'active' : '' ); ?>">
			<input type="text"
						data-field="groupment[user_info][owner_id]"
						data-type="user"
						placeholder=""
						class="digi-search"
						value="<?php echo ! empty( $owner_user->id ) ? esc_attr( User_Digi_Class::g()->element_prefix . $owner_user->id . ' - ' . $owner_user->displayname ) : ''; ?>" />
			<label><?php esc_html_e( 'Responsable', 'digirisk' ); ?></label>
			<span class="bar"></span>
			<input type="hidden" name="groupment[user_info][owner_id]" />
		</li>

		<li class="form-element <?php echo esc_attr( ! empty( $address->additional_address ) ? 'active' : '' ); ?>">
			<input type="text" name="address[additional_address]" value="<?php echo esc_attr( $address->additional_address ); ?>" />
			<label><?php esc_html_e( 'Additional address', 'digirisk' ); ?></label>
			<span class="bar"></span>
		</li>

		<li class="form-element <?php echo esc_attr( ! empty( $element->date ) ? 'active' : '' ); ?>">
			<input type="text" class="date" name="groupment[date]" value="<?php echo esc_attr( ! empty( $element->date ) ? $element->date : date( 'd/m/Y' ) ); ?>" />
			<label><?php esc_html_e( 'Created date', 'digirisk' ); ?></label>
			<span class="bar"></span>
		</li>

		<li class="form-element <?php echo esc_attr( ! empty( $address->postcode ) ? 'active' : '' ); ?>">
			<input type="text" name="address[postcode]" value="<?php echo esc_attr( $address->postcode ); ?>" />
			<label><?php esc_html_e( 'Postcode', 'digirisk' ); ?></label>
			<span class="bar"></span>
		</li>

		<li class="form-element <?php echo esc_attr( ! empty( $address->town ) ? 'active' : '' ); ?>">
			<input type="text" name="address[town]" value="<?php echo esc_attr( $address->town ); ?>" />
			<label><?php esc_html_e( 'Town', 'digirisk' ); ?></label>
			<span class="bar"></span>
		</li>

		<li class="form-element <?php echo esc_attr( ! empty( $element->contact['phone'][0] ) ? 'active' : '' ); ?>">
			<input type="text" name="groupment[contact][phone][]" value="<?php echo esc_attr( ! empty( $element->contact['phone'] ) ? max( $element->contact['phone'] ) : '' ); ?>" />
			<label><?php esc_html_e( 'Phone', 'digirisk' ); ?></label>
			<span class="bar"></span>
		</li>

	</ul>

	<ul>
		<li class="form-element <?php echo esc_attr( ! empty( $element->content ) ? 'active' : '' ); ?>">
			<textarea name="groupment[content]"><?php echo esc_html( $element->content ); ?></textarea>
			<label><?php esc_html_e( 'Description', 'digirisk' ); ?></label>
			<span class="bar"></span>
		</li>
	</ul>

	<button class="float right button green action-input" data-form="form"><?php esc_html_e( 'Modifier', 'digirisk' ); ?></button>
</form>
