<?php
/**
 * Formulaire pour générer une diffusion d'information.
 *
 * @author    Evarisk <dev@evarisk.com>
 * @since     6.2.10
 * @version   6.5.0
 * @copyright 2018 Evarisk.
 * @package   DigiRisk
 */

namespace digi;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
} ?>

<form class="form-generate">
	<input type="hidden" name="action" value="generate_diffusion_information" />
	<?php wp_nonce_field( 'generate_diffusion_information' ); ?>
	<input type="hidden" name="parent_id" value="<?php echo esc_attr( $element_id ); ?>" />

	<div class="grid-layout padding w2">
		<ul class="form">
			<li><h2><?php esc_html_e( 'Délégués du personnel', 'digirisk' ); ?></h2></li>
			<li class="form-element <?php echo ! empty( $diffusion_information->data['document_meta']['delegues_du_personnels_date']['raw'] ) ? 'active' : ''; ?>">
				<div class="group-date form-element <?php echo esc_attr( ! empty( $element->date ) ? 'active' : '' ); ?>">
					<input type="text" class="mysql-date" style="width: 0px; padding: 0px; border: none;" name="delegues_du_personnels_date" value="<?php echo esc_attr( $diffusion_information->data['document_meta']['delegues_du_personnels_date']['raw'] ); ?>" />
					<input type="text" class="date" placeholder="04/01/2017" value="<?php echo esc_html( $diffusion_information->data['document_meta']['delegues_du_personnels_date']['rendered']['date'] ); ?>" />
					<label><?php esc_html_e( 'Date d\'élection', 'digirisk' ); ?></label>
					<span class="bar"></span>
				</div>
			</li>

			<li class="form-element <?php echo ! empty( $diffusion_information->data['document_meta']['delegues_du_personnels_titulaires'] ) ? 'active' : ''; ?>">
				<textarea name="delegues_du_personnels_titulaires"><?php echo esc_attr( $diffusion_information->data['document_meta']['delegues_du_personnels_titulaires'] ); ?></textarea>
				<label><?php esc_html_e( 'Titulaires', 'digirisk' ); ?></label>
				<span class="bar"></span>
			</li>

			<li class="form-element <?php echo ! empty( $diffusion_information->data['document_meta']['delegues_du_personnels_suppleants'] ) ? 'active' : ''; ?>">
				<textarea name="delegues_du_personnels_suppleants"><?php echo esc_attr( $diffusion_information->data['document_meta']['delegues_du_personnels_suppleants'] ); ?></textarea>
				<label><?php esc_html_e( 'Suppléants', 'digirisk' ); ?></label>
				<span class="bar"></span>
			</li>
		</ul>

		<ul class="form">
			<li><h2><?php esc_html_e( 'Membres du comité d\'entreprise', 'digirisk' ); ?></h2></li>
			<li class="form-element <?php echo ! empty( $diffusion_information->data['document_meta']['membres_du_comite_entreprise_date']['raw'] ) ? 'active' : ''; ?>">
				<div class="group-date form-element <?php echo esc_attr( ! empty( $diffusion_information->data['document_meta']['membres_du_comite_entreprise_date']['raw'] ) ? 'active' : '' ); ?>">
					<input type="text" class="mysql-date" style="width: 0px; padding: 0px; border: none;" name="membres_du_comite_entreprise_date" value="<?php echo esc_attr( $diffusion_information->data['document_meta']['membres_du_comite_entreprise_date']['raw'] ); ?>" />
					<input type="text" class="date" placeholder="04/01/2017" value="<?php echo esc_html( $diffusion_information->data['document_meta']['membres_du_comite_entreprise_date']['rendered']['date'] ); ?>" />
					<label><?php esc_html_e( 'Date d\'élection', 'digirisk' ); ?></label>
					<span class="bar"></span>
				</div>
			</li>

			<li class="form-element <?php echo ! empty( $diffusion_information->data['document_meta']['membres_du_comite_entreprise_titulaires'] ) ? 'active' : ''; ?>">
				<textarea name="membres_du_comite_entreprise_titulaires"><?php echo esc_attr( $diffusion_information->data['document_meta']['membres_du_comite_entreprise_titulaires'] ); ?></textarea>
				<label><?php esc_html_e( 'Titulaires', 'digirisk' ); ?></label>
				<span class="bar"></span>
			</li>

			<li class="form-element <?php echo ! empty( $diffusion_information->data['document_meta']['membres_du_comite_entreprise_suppleants'] ) ? 'active' : ''; ?>">
				<textarea name="membres_du_comite_entreprise_suppleants"><?php echo esc_attr( $diffusion_information->data['document_meta']['membres_du_comite_entreprise_suppleants'] ); ?></textarea>
				<label><?php esc_html_e( 'Suppléants', 'digirisk' ); ?></label>
				<span class="bar"></span>
			</li>
		</ul>
	</div>

	<button class="button blue action-input float right" data-parent="form-generate"><i class="icon far fa-sync-alt"></i><span><?php esc_html_e( 'Générer les diffusions d\'informations A3 et A4', 'digirisk' ); ?></span></button>
</form>
