<?php
/**
 * Ce template affiche le formulaire pour configurer les informations d'une société.
 *
 * @author    Evarisk <dev@evarisk.com>
 * @copyright (c) 2006-2018 Evarisk <dev@evarisk.com>.
 *
 * @license   AGPLv3 <https://spdx.org/licenses/AGPL-3.0-or-later.html>
 *
 * @package   DigiRisk\Templates
 *
 * @since     6.2.1
 */

namespace digi;

defined( 'ABSPATH' ) || exit;

global $eo_search; ?>

<form class="wpeo-form">
	<input type="hidden" name="action" value="save_configuration" />
	<input type="hidden" name="society[id]" value="<?php echo esc_attr( $element->data['id'] ); ?>" />
	<input type="hidden" name="address[post_id]" value="<?php echo esc_attr( $element->data['id'] ); ?>" />
	<input type="hidden" name="society[type]" value="<?php echo esc_attr( $element->data['type'] ); ?>" />
	<?php wp_nonce_field( 'save_configuration' ); ?>

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

		<?php $eo_search->display( 'society_information_owner' ); ?>

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

		<div class="form-element">
			<span class="form-label"><?php esc_html_e( 'Téléphone', 'digirisk' ); ?></span>
			<label class="form-field-container">
				<input name="society[contact][phone]" class="form-field" type="text" value="<?php echo esc_attr( ! empty( $element->data['contact']['phone'] ) ? end( $element->data['contact']['phone'] ) : '' ); ?>" />
			</label>
		</div>

		<div class="form-element">
			<span class="form-label"><?php esc_html_e( 'Email', 'digirisk' ); ?></span>
			<label class="form-field-container">
				<input name="society[contact][email]" class="form-field" type="text" value="<?php echo esc_attr( $element->data['contact']['email'] ); ?>" />
			</label>
		</div>

		<div class="form-element gridw-2">
			<span class="form-label"><?php esc_html_e( 'Description', 'digirisk' ); ?></span>
			<label class="form-field-container">
				<textarea name="society[content]" class="form-field" rows="6"><?php echo $element->data['content']; ?></textarea>
			</label>
		</div>

		<div class="gridw-2">
			<button class="wpeo-button button-main action-input alignright" data-parent="wpeo-form"><?php esc_html_e( 'Enregistrer les modifications', 'digirisk' ); ?></button>
		</div>
	</div>

</form>
