<?php
/**
 * Bloc d'édition des données de la société
 *
 * @author Evarisk <dev@evarisk.com>
 * @since 7.3.3
 * @version 7.3.3
 * @copyright 2019 Evarisk
 * @package DigiRisk
 */

namespace digi;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
} ?>


<form class="wpeo-form">
	<input type="hidden" name="action" value="save_society_information" />
	<input type="hidden" name="society[id]" value="<?php echo esc_attr( $element->data['id'] ); ?>" />
	<input type="hidden" name="address[post_id]" value="<?php echo esc_attr( $element->data['id'] ); ?>" />
	<input type="hidden" name="society[type]" value="<?php echo esc_attr( $element->data['type'] ); ?>" />
	<?php wp_nonce_field( 'save_society_information' ); ?>

	<div class="wpeo-gridlayout grid-2 grid-gap-1">
		<div class="form-element">
			<span class="form-label"><?php esc_html_e( 'Nom', 'digirisk' ); ?></span>
			<label class="form-field-container">
				<input name="society[title]" class="form-field" type="text" value="<?php echo esc_attr( $element->data['title'] ); ?>" />
			</label>
		</div>

		<?php if ( Society_Class::g()->get_type() === $element->data['type'] ) : ?>
			<div class="form-element">
				<span class="form-label"><?php esc_html_e( 'SIRET', 'digirisk' ); ?></span>
				<label class="form-field-container">
					<input name="society[siret_id]" class="form-field" type="text" value="<?php echo esc_attr( $element->data['siret_id'] ); ?>" />
				</label>
			</div>

			<div class="form-element">
				<span class="form-label"><?php esc_html_e( 'Nombre d\'employés', 'digirisk' ); ?></span>
				<label class="form-field-container">
					<input name="society[number_of_employees]" class="form-field" type="text" value="<?php echo esc_attr( $element->data['number_of_employees'] ); ?>" />
				</label>
			</div>
		<?php endif; ?>

		<?php
			Society_Configuration_Class::g()->display_form_owner( $element );
		?>

		<div class="form-element group-date">
			<span class="form-label"><?php esc_html_e( 'Date de création', 'digirisk' ); ?></span>
			<label class="form-field-container">
				<input type="hidden" class="mysql-date" name="society[date]" value="<?php echo esc_attr( $element->data['date']['raw'] ); ?>" />
				<input class="form-field date" type="text" value="<?php echo esc_attr( $element->data['date']['rendered']['date'] ); ?>" />
			</label>
		</div>
	</div>

	<div class="wpeo-gridlayout grid-2 grid-gap-1">
		<div class="form-element">
			<span class="form-label"><?php esc_html_e( 'Adresse', 'digirisk' ); ?></span>
			<label class="form-field-container">
				<input name="address[address]" class="form-field" type="text" value="<?php echo esc_attr( $address->data['address'] ); ?>" />
			</label>
		</div>


		<div class="form-element">
			<span class="form-label"><?php esc_html_e( 'Complément d\'adresse', 'digirisk' ); ?></span>
			<label class="form-field-container">
				<input name="address[additional_address]" class="form-field" type="text" value="<?php echo esc_attr( $address->data['additional_address'] ); ?>" />
			</label>
		</div>

		<div class="form-element">
			<span class="form-label"><?php esc_html_e( 'Code postal', 'digirisk' ); ?></span>
			<label class="form-field-container">
				<input name="address[postcode]" class="form-field" type="text" value="<?php echo esc_attr( $address->data['postcode'] ); ?>" />
			</label>
		</div>

		<div class="form-element">
			<span class="form-label"><?php esc_html_e( 'Ville', 'digirisk' ); ?></span>
			<label class="form-field-container">
				<input name="address[town]" class="form-field" type="text" value="<?php echo esc_attr( $address->data['town'] ); ?>" />
			</label>
		</div>
	</div>
	<div class="gridw-2" style="margin-top : 10px">
		<button class="wpeo-button button-main action-input alignright" data-parent="wpeo-form"><?php esc_html_e( 'Enregistrer les modifications', 'digirisk' ); ?></button>
	</div>
</form>
