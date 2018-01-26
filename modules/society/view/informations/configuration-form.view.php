<?php
/**
 * Le formulaire pour configurer un établissement.
 *
 * @author Jimmy Latour <jimmy@evarisk.com>
 * @since 6.2.1
 * @version 6.5.0
 * @copyright 2015-2018 Evarisk
 * @package DigiRisk
 */

namespace digi;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
} ?>

<h1>
	<?php
	esc_html_e( 'Configuration ', 'digirisk' );
	if ( Society_Class::g()->get_type() !== $element->type ) :
		echo esc_html( $element->unique_identifier . ' - ' );
	endif;
	echo esc_html( $element->title );
	?>
</h1>

<form method="POST" class="form society-informations" action="<?php echo esc_attr( admin_url( 'admin-ajax.php' ) ); ?>">
	<input type="hidden" name="action" value="save_configuration" />
	<input type="hidden" name="society[id]" value="<?php echo esc_attr( $element->id ); ?>" />
	<input type="hidden" name="address[post_id]" value="<?php echo esc_attr( $element->id ); ?>" />
	<?php wp_nonce_field( 'save_configuration' ); ?>

	<ul class="grid-layout padding w2">
		<li>
			<div class="form-element <?php echo esc_attr( ! empty( $element->title ) ? 'active' : '' ); ?>">
				<input name="society[title]" type="text" value="<?php echo esc_attr( $element->title ); ?>" />
				<label><?php esc_html_e( 'Nom', 'digirisk' ); ?></label>
				<span class="bar"></span>
			</div>
		</li>

		<?php if ( Society_Class::g()->get_type() === $element->type ) : ?>
			<li>
				<div class="form-element <?php echo esc_attr( ! empty( $element->siret_id ) ? 'active' : '' ); ?>">
					<input name="society[siret_id]" type="text" value="<?php echo esc_attr( $element->siret_id ); ?>" />
					<label><?php esc_html_e( 'SIRET', 'digirisk' ); ?></label>
					<span class="bar"></span>
				</div>
			</li>

			<li>
				<div class="form-element <?php echo esc_attr( isset( $element->number_of_employees ) ? 'active' : '' ); ?>">
					<input name="society[number_of_employees]" type="text" value="<?php echo isset( $element->number_of_employees ) ? esc_attr( $element->number_of_employees ) : ''; ?>" />
					<label><?php esc_html_e( 'Nombre d\'employée', 'digirisk' ); ?></label>
					<span class="bar"></span>
				</div>
			</li>
		<?php endif; ?>
	</ul>

	<ul class="grid-layout padding w2">
		<li>
			<div class="form-element <?php echo esc_attr( ! empty( $address->address ) ? 'active' : '' ); ?>">
				<input name="address[address]" type="text" value="<?php echo esc_attr( $address->address ); ?>" />
				<label><?php esc_html_e( 'Adresse', 'digirisk' ); ?></label>
				<span class="bar"></span>
			</div>
		</li>

		<li>
			<div class="form-element <?php echo esc_attr( ! empty( $element->owner_id ) ? 'active' : '' ); ?>">
				<input type="text"
							data-field="society[owner_id]"
							data-type="user"
							placeholder=""
							class="digi-search"
							value="<?php echo ! empty( $element->owner_id ) ? esc_attr( User_Digi_Class::g()->element_prefix . $element->owner_id . ' - ' . $element->owner->displayname . ' (' . $element->owner->email . ')' ) : ''; ?>" />
				<label><?php esc_html_e( 'Responsable', 'digirisk' ); ?></label>
				<span class="bar"></span>
				<input type="hidden" name="society[owner_id]" value="<?php echo esc_attr( $element->owner_id ); ?>" />
			</div>
		</li>

		<li>
			<div class="form-element <?php echo esc_attr( ! empty( $address->additional_address ) ? 'active' : '' ); ?>">
				<input type="text" name="address[additional_address]" value="<?php echo esc_attr( $address->additional_address ); ?>" />
				<label><?php esc_html_e( 'Complément d\'adresse', 'digirisk' ); ?></label>
				<span class="bar"></span>
			</div>
		</li>

		<li>
			<div class="group-date form-element <?php echo esc_attr( ! empty( $element->date['raw'] ) ? 'active' : '' ); ?>">
				<input type="text" class="mysql-date" style="width: 0px; padding: 0px; border: none;" name="society[date]" value="<?php echo esc_attr( $element->date['raw'] ); ?>" />
				<input type="text" class="date" placeholder="04/01/2017" value="<?php echo esc_html( $element->date['rendered']['date'] ); ?>" />
				<label><?php esc_html_e( 'Date de création', 'digirisk' ); ?></label>
				<span class="bar"></span>
			</div>
		</li>

		<li>
			<div class="form-element <?php echo esc_attr( ! empty( $address->postcode ) ? 'active' : '' ); ?>">
				<input type="text" name="address[postcode]" value="<?php echo esc_attr( $address->postcode ); ?>" />
				<label><?php esc_html_e( 'Code postal', 'digirisk' ); ?></label>
				<span class="bar"></span>
			</div>
		</li>

		<li>
			<div class="form-element <?php echo esc_attr( ! empty( $address->town ) ? 'active' : '' ); ?>">
				<input type="text" name="address[town]" value="<?php echo esc_attr( $address->town ); ?>" />
				<label><?php esc_html_e( 'Ville', 'digirisk' ); ?></label>
				<span class="bar"></span>
			</div>
		</li>

		<li>
			<div class="form-element <?php echo esc_attr( ! empty( $element->contact['phone'][0] ) ? 'active' : '' ); ?>">
				<input type="text" name="society[contact][phone]" value="<?php echo esc_attr( ! empty( $element->contact['phone'] ) ? end( $element->contact['phone'] ) : '' ); ?>" />
				<label><?php esc_html_e( 'Téléphone', 'digirisk' ); ?></label>
				<span class="bar"></span>
			</div>
		</li>

		<li>
			<div class="form-element <?php echo esc_attr( ! empty( $element->contact['email'] ) ? 'active' : '' ); ?>">
				<input type="text" name="society[contact][email]" value="<?php echo esc_attr( $element->contact['email'] ); ?>" />
				<label><?php esc_html_e( 'Email', 'digirisk' ); ?></label>
				<span class="bar"></span>
			</div>
		</li>

	</ul>

	<ul>
		<li class="form-element <?php echo esc_attr( ! empty( $element->content ) ? 'active' : '' ); ?>">
			<textarea name="society[content]"><?php echo esc_html( $element->content ); ?></textarea>
			<label><?php esc_html_e( 'Description', 'digirisk' ); ?></label>
			<span class="bar"></span>
		</li>
	</ul>

	<button class="float right button green disable action-input" data-parent="form"><?php esc_html_e( 'Modifier', 'digirisk' ); ?></button>
</form>
