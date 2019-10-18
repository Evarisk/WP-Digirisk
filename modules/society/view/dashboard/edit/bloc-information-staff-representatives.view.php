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
	<input type="hidden" name="action" value="save_staff_representatives" />
	<input type="hidden" name="society[id]" value="<?php echo esc_attr( $element->data['id'] ); ?>" />
	<input type="hidden" name="address[post_id]" value="<?php echo esc_attr( $element->data['id'] ); ?>" />
	<input type="hidden" name="society[type]" value="<?php echo esc_attr( $element->data['type'] ); ?>" />
	<input type="hidden" name="legaldisplay_id" value="<?php echo esc_attr( $legal_display->data['id'] ); ?>" />
	<?php wp_nonce_field( 'save_staff_representatives' ); ?>

	<div class="wpeo-gridlayout grid-1 grid-gap-1">

		<span style="text-align:  center; margin-top : 20px">
			<h2><?php esc_html_e( 'Délégués du personnel', 'digirisk' ); ?></h2>
		</span>
		<div class="form-element">
			<span class="form-label"><?php esc_html_e( 'Date d\'élection', 'digirisk' ); ?></span>
			<label class="group-date form-field-container">
				<input type="hidden" class="mysql-date" name="delegues_du_personnels_date" value="<?php echo esc_attr( $diffusion_information->data['delegues_du_personnels_date']['raw'] ); ?>" />
				<input type="text" class="date form-field" placeholder="04/01/2017" value="<?php echo esc_html( $diffusion_information->data['delegues_du_personnels_date']['rendered']['date'] ); ?>" />
			</label>
		</div>

		<div class="form-element">
			<span class="form-label"><?php esc_html_e( 'Titulaires', 'digirisk' ); ?></span>
			<label class="form-field-container">
				<textarea class="form-field" name="delegues_du_personnels_titulaires"><?php echo esc_attr( $diffusion_information->data['delegues_du_personnels_titulaires'] ); ?></textarea>
			</label>
		</div>

		<div class="form-element">
			<span class="form-label"><?php esc_html_e( 'Suppléants', 'digirisk' ); ?></span>
			<label class="form-field-container">
				<textarea class="form-field" name="delegues_du_personnels_suppleants"><?php echo esc_attr( $diffusion_information->data['delegues_du_personnels_suppleants'] ); ?></textarea>
			</label>
		</div>

		<span style="text-align:  center; margin-top : 20px">
			<h2><?php esc_html_e( 'Comité social et économique (CSE)', 'digirisk' ); ?></h2>
		</span>

		<div class="form-element">
			<span class="form-label"><?php esc_html_e( 'Date d\'élection', 'digirisk' ); ?></span>
			<label class="group-date form-field-container">
				<input type="hidden" class="mysql-date" name="membres_du_comite_entreprise_date" value="<?php echo esc_attr( $diffusion_information->data['membres_du_comite_entreprise_date']['raw'] ); ?>" />
				<input type="text" class="date form-field" placeholder="04/01/2017" value="<?php echo esc_html( $diffusion_information->data['membres_du_comite_entreprise_date']['rendered']['date'] ); ?>" />
				</label>
			</label>
		</div>
		<div class="form-element">
			<span class="form-label"><?php esc_html_e( 'Titulaires', 'digirisk' ); ?></span>
			<label class="form-field-container">
				<textarea class="form-field" name="membres_du_comite_entreprise_titulaires"><?php echo esc_attr( $diffusion_information->data['membres_du_comite_entreprise_titulaires'] ); ?></textarea>
			</label>
		</div>
		<div class="form-element">
			<span class="form-label"><?php esc_html_e( 'Suppléants', 'digirisk' ); ?></span>
			<label class="form-field-container">
				<textarea class="form-field" name="membres_du_comite_entreprise_suppleants"><?php echo esc_attr( $diffusion_information->data['membres_du_comite_entreprise_suppleants'] ); ?></textarea>
			</label>
		</div>


	</div>
	<div class="gridw-2" style="margin-top : 10px">
		<button class="wpeo-button button-main action-input alignright" data-parent="wpeo-form"><?php esc_html_e( 'Enregistrer les modifications', 'digirisk' ); ?></button>
	</div>
</form>
