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

<?php /* ?>
<form class="form-generate">
	<?php wp_nonce_field( 'generate_diffusion_information' ); ?>
	<input type="hidden" name="parent_id" value="<?php echo esc_attr( $element_id ); ?>" />

	<div class="wpeo-gridlayout padding grid-2">
		<ul class="wpeo-form">
			<li><h2><?php esc_html_e( 'Délégués du personnel', 'digirisk' ); ?></h2></li>
			<li class="form-element">
				<span class="form-label"><?php esc_html_e( 'Date d\'élection', 'digirisk' ); ?></span>
				<label class="group-date form-field-container">
					<input type="hidden" class="mysql-date" name="delegues_du_personnels_date" value="<?php echo esc_attr( $diffusion_information->data['delegues_du_personnels_date']['raw'] ); ?>" />
					<input type="text" class="date form-field" placeholder="04/01/2017" value="<?php echo esc_html( $diffusion_information->data['delegues_du_personnels_date']['rendered']['date'] ); ?>" />
				</label>
			</li>

			<li class="form-element">
				<span class="form-label"><?php esc_html_e( 'Titulaires', 'digirisk' ); ?></span>
				<label class="form-field-container">
					<textarea class="form-field" name="delegues_du_personnels_titulaires"><?php echo esc_attr( $diffusion_information->data['delegues_du_personnels_titulaires'] ); ?></textarea>
				</label>
			</li>

			<li class="form-element">
				<span class="form-label"><?php esc_html_e( 'Suppléants', 'digirisk' ); ?></span>
				<label class="form-field-container">
					<textarea class="form-field" name="delegues_du_personnels_suppleants"><?php echo esc_attr( $diffusion_information->data['delegues_du_personnels_suppleants'] ); ?></textarea>
				</label>
			</li>
		</ul>

		<ul class="wpeo-form">
			<li><h2><?php esc_html_e( 'Membres du comité d\'entreprise', 'digirisk' ); ?></h2></li>
			<li class="form-element">
				<span class="form-label"><?php esc_html_e( 'Date d\'élection', 'digirisk' ); ?></span>
				<label class="group-date form-field-container">
					<input type="hidden" class="mysql-date" name="membres_du_comite_entreprise_date" value="<?php echo esc_attr( $diffusion_information->data['membres_du_comite_entreprise_date']['raw'] ); ?>" />
					<input type="text" class="date form-field" placeholder="04/01/2017" value="<?php echo esc_html( $diffusion_information->data['membres_du_comite_entreprise_date']['rendered']['date'] ); ?>" />
					</label>
				</label>
			</li>

			<li class="form-element">
				<span class="form-label"><?php esc_html_e( 'Titulaires', 'digirisk' ); ?></span>
				<label class="form-field-container">
					<textarea class="form-field" name="membres_du_comite_entreprise_titulaires"><?php echo esc_attr( $diffusion_information->data['membres_du_comite_entreprise_titulaires'] ); ?></textarea>
				</label>
			</li>

			<li class="form-element">
				<span class="form-label"><?php esc_html_e( 'Suppléants', 'digirisk' ); ?></span>
				<label class="form-field-container">
					<textarea class="form-field" name="membres_du_comite_entreprise_suppleants"><?php echo esc_attr( $diffusion_information->data['membres_du_comite_entreprise_suppleants'] ); ?></textarea>
				</label>
			</li>
		</ul>
	</div>

	<div class="alignright">
		<button data-action="save_diffusion_information" class="wpeo-button button-main button-green action-input" data-parent="form-generate">
			<i class="button-icon fas fa-sync-alt"></i>
			<span><?php esc_html_e( 'Enregister les modifications', 'digirisk' ); ?></span>
		</button>

	</div>
</form>

<?php
*/
?>

<button data-action="generate_diffusion_information" class="wpeo-button button-main action-input" data-parent="form-generate">
	<i class="button-icon fas fa-sync-alt"></i>
	<span><?php esc_html_e( 'Générer les diffusions d\'informations A3 et A4', 'digirisk' ); ?></span>
</button>

<a href="<?php echo esc_attr( admin_url() . 'options-general.php?page=digirisk-setting&tab=digi-configuration' );  ?>">
	<button class="wpeo-button button-main wpeo-tooltip-event" aria-label="<?php esc_html_e( 'Accéder aux réglages des données', 'digirisk' ); ?>">
		<i class="fas fa-cog"></i>
	</button>
</a>
