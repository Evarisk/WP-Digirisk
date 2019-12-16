<?php
/**
 * Affiches la liste des causeries
 *
 * @author    Evarisk <dev@evarisk.com>
 * @since     6.6.0
 * @version   6.6.0
 * @copyright 2018 Evarisk.
 * @package   DigiRisk
 */

namespace digi;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
} ?>

<div class="wrap digirisk-wrap permis-feu-wrap wpeo-wrap">

	<div class="step" style="margin-top: 20px; margin-bottom: 40px;">
		<div class="step-list">
			<a href="<?php echo Permis_Feu_Class::g()->get_link( $permis_feu, 1 ); ?>" class="step	<?php echo ( in_array( $permis_feu->data['step'], array( 1, 2, 3, 4 ) ) ) ? 'active' : ''; ?>"
				style="text-decoration: none;">
				<span class="title"><?php esc_html_e( 'Maitre oeuvre', 'digirisk' ); ?></span></a>
			<a href="<?php echo Permis_Feu_Class::g()->get_link( $permis_feu, 2 ); ?>" class="step <?php echo ( in_array( $permis_feu->data['step'], array( 2, 3, 4 ) ) ) ? 'active' : ''; ?>"
				data-width="37" style="text-decoration: none;">
				<span class="title"><?php esc_html_e( 'Permis de Feu', 'digirisk' ); ?></span></a>
			<a href="<?php echo Permis_Feu_Class::g()->get_link( $permis_feu, 3 ); ?>" class="step <?php echo ( in_array( $permis_feu->data['step'], array( 3, 4 ) ) ) ? 'active' : ''; ?>"
				data-width="62" style="text-decoration: none;">
				<span class="title"><?php esc_html_e( 'Information de la société', 'digirisk' ); ?></span></a>
			<a href="<?php echo Permis_Feu_Class::g()->get_link( $permis_feu, 4 ); ?>" class="step <?php echo ( 4 === $permis_feu->data['step'] ) ? 'active' : ''; ?>"
				data-width="100" style="text-decoration: none;">
				<span class="title" style="max-width : none !important;"><?php esc_html_e( 'Intervenant Exterieur', 'digirisk' ); ?></span></a>
		</div>

		<div class="bar">
			<div class="background"></div>
			<div class="loader" data-width="<?php echo esc_attr( 37,5 * ( $permis_feu->data['step'] - 1 ) ); ?>" style="width:
			<?php if( $permis_feu->data['step'] == 4 ): echo '100%';
			elseif( $permis_feu->data['step'] == 3 ): echo '62%';
			elseif( $permis_feu->data['step'] == 2 ): echo '37%';
			else: echo '0%' ; endif; ?>	">
			</div>
		</div>
	</div>

	<div class="ajax-content digi-permis-feu-parent step-<?php echo esc_attr( $permis_feu->data['step'] ); ?>">
		<input type="hidden" name="permis_feu_id" value="<?php echo esc_attr( $permis_feu->data['id'] ); ?>" />

		<?php Permis_Feu_Page_Class::g()->display_step_nbr( $permis_feu ); ?>

		<!-- Next button -->
		<div class="wpeo-button wpeo-tooltip-event button-blue action-input permis-feu-start
			<?php echo Permis_Feu_Class::g()->step_is_valid( $permis_feu->data['step'], $permis_feu ) ? '' : 'button-disable'; ?>"
		     data-parent="ajax-content"
		     data-action="next_step_permis_feu"
		     data-nonce="<?php echo esc_attr( wp_create_nonce( 'next_step_permis_feu' ) ); ?>"
		     data-id="<?php echo esc_attr( $permis_feu->data['id'] ); ?>"
		     aria-label="<?php esc_html_e( 'Suivant', 'digirisk' ); ?>"
		     style="float:right">
			<span><i class="fas fa-2x fa-long-arrow-alt-right"></i></span>
		</div>

	</div>
</div>
