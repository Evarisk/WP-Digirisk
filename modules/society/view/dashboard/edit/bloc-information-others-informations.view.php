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
	<input type="hidden" name="action" value="save_others_informations" />
	<input type="hidden" name="society[id]" value="<?php echo esc_attr( $element->data['id'] ); ?>" />
	<input type="hidden" name="address[post_id]" value="<?php echo esc_attr( $element->data['id'] ); ?>" />
	<input type="hidden" name="society[type]" value="<?php echo esc_attr( $element->data['type'] ); ?>" />
	<input type="hidden" name="legaldisplay_id" value="<?php echo esc_attr( $legal_display->data['id'] ); ?>" />

	<?php wp_nonce_field( 'save_others_informations' ); ?>

	<div class="wpeo-gridlayout grid-1 grid-gap-1">

		<!-- PARTIE CONVENTION COLLECTIVE - COLLECTIVE AGREEMENT -->

		<span style="text-align:  center; margin-top : 20px">
			<h2><?php esc_html_e( 'Convention(s) collective(s) applicable(s)', 'digirisk' ); ?></h2>
		</span>
		<div class="form-element">
			<span class="form-label"><?php esc_html_e( 'Intitulé', 'digirisk' ); ?></span>
			<label class="form-field-container">
				<input name="collective_agreement[title_of_the_applicable_collective_agreement]" class="form-field" type="text" value="<?php echo esc_attr( $legal_display->data['collective_agreement']['title_of_the_applicable_collective_agreement'] ); ?>" />
			</label>
		</div>
		<div class="form-element">
			<span class="form-label"><?php esc_html_e( 'Lieu et modalités de consultation', 'digirisk' ); ?></span>
			<label class="form-field-container">
				<input name="collective_agreement[location_and_access_terms_of_the_agreement]" class="form-field" type="text" value="<?php echo esc_attr( $legal_display->data['collective_agreement']['location_and_access_terms_of_the_agreement'] ); ?>" />
			</label>
		</div>

		<!-- PARTIE REGLEMENT INTERIEUR - RULES -->

		<span style="text-align:  center; margin-top : 20px">
			<h2><?php esc_html_e( 'Règlement intérieur', 'digirisk' ); ?></h2>
		</span>
		<div class="form-element">
			<span class="form-label"><?php esc_html_e( 'Lieux d\'affichage', 'digirisk' ); ?></span>
			<label class="form-field-container">
				<input name="rules[location]" class="form-field" type="text" value="<?php echo esc_attr( $legal_display->data['rules']['location'] ); ?>" />
			</label>
		</div>

		<!-- PARTIE DUER - DUER -->

		<span style="text-align:  center; margin-top : 20px">
			<h2><?php esc_html_e( 'DUER', 'digirisk' ); ?></h2>
		</span>
		<div class="form-element">
			<span class="form-label"><?php esc_html_e( 'Modalités d\'accès', 'digirisk' ); ?></span>
			<label class="form-field-container">
				<input name="DUER[how_access_to_duer]" class="form-field" type="text" value="<?php echo esc_attr( $legal_display->data['DUER']['how_access_to_duer'] ); ?>" />
			</label>
		</div>

		<!-- PARTIE ACCORD DE PARTICIPATION - PARICIPATION AGREEMENT -->

		<span style="text-align:  center; margin-top : 20px">
			<h2><?php esc_html_e( 'Accord de participation', 'digirisk' ); ?></h2>
		</span>
		<div class="form-element">
			<span class="form-label"><?php esc_html_e( 'Modalités d\'information', 'digirisk' ); ?></span>
			<label class="form-field-container">
				<input name="participation_agreement[information_procedures]" class="form-field" type="text" value="<?php echo esc_attr( $legal_display->data['participation_agreement']['information_procedures'] ); ?>" />
			</label>
		</div>


	</div>
	<div class="gridw-2" style="margin-top : 10px">
		<button class="wpeo-button button-main action-input alignright" data-parent="wpeo-form"><?php esc_html_e( 'Enregistrer les modifications', 'digirisk' ); ?></button>
	</div>
</form>
