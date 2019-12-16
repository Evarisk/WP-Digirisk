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

<div class="wrap digirisk-wrap prevention-plan-wrap wpeo-wrap">

	<div class="step" style="margin-top: 20px; margin-bottom: 40px;">
		<div class="step-list">
			<a href="<?php echo Prevention_Class::g()->get_link( $prevention, 1 ); ?>" class="step	<?php echo ( in_array( $prevention->data['step'], array( 1, 2, 3, 4 ) ) ) ? 'active' : ''; ?>"
			   style="text-decoration: none;">
				<span class="title"><?php esc_html_e( 'Maitre oeuvre', 'digirisk' ); ?></span></a>
			<a href="<?php echo Prevention_Class::g()->get_link( $prevention, 2 ); ?>" class="step <?php echo ( in_array( $prevention->data['step'], array( 2, 3, 4 ) ) ) ? 'active' : ''; ?>"
			   data-width="37" style="text-decoration: none;">
				<span class="title"><?php esc_html_e( 'Plan de prévention', 'digirisk' ); ?></span></a>
			<a href="<?php echo Prevention_Class::g()->get_link( $prevention, 3 ); ?>" class="step <?php echo ( in_array( $prevention->data['step'], array( 3, 4 ) ) ) ? 'active' : ''; ?>"
			   data-width="62" style="text-decoration: none;">
				<span class="title"><?php esc_html_e( 'Information de la société', 'digirisk' ); ?></span></a>
			<a href="<?php echo Prevention_Class::g()->get_link( $prevention, 4 ); ?>" class="step <?php echo ( 4 === $prevention->data['step'] ) ? 'active' : ''; ?>"
			   data-width="100" style="text-decoration: none;">
				<span class="title" style="max-width : none !important;"><?php esc_html_e( 'Intervenant Exterieur', 'digirisk' ); ?></span></a>
		</div>

		<div class="bar">
			<div class="background"></div>
			<div class="loader" data-width="<?php echo esc_attr( 37,5 * ( $prevention->data['step'] - 1 ) ); ?>" style="width:
			<?php if( $prevention->data['step'] == 4 ): echo '100%';
			elseif( $prevention->data['step'] == 3 ): echo '62%';
			elseif( $prevention->data['step'] == 2 ): echo '37%';
			else: echo '0%' ; endif; ?>	">
			</div>
		</div>
	</div>

	<div class="ajax-content digi-prevention-plan-parent step-<?php echo esc_attr( $prevention->data['step'] ); ?>">
		<input type="hidden" name="prevention_id" value="<?php echo esc_attr( $prevention->data['id'] ); ?>" />

		<?php Prevention_Page_Class::g()->display_step_nbr( $prevention ); ?>
		<?php Prevention_Class::g()->step_is_valid( $prevention->data['step'], $prevention ); ?>

		<!-- Next button -->
		<div class="wpeo-button wpeo-tooltip-event button-blue action-input prevention-start
			<?php echo Prevention_Class::g()->step_is_valid( $prevention->data['step'], $prevention ) ? '' : 'button-disable'; ?>"
		     data-parent="ajax-content"
		     data-action="next_step_prevention"
		     data-nonce="<?php echo esc_attr( wp_create_nonce( 'next_step_prevention' ) ); ?>"
		     data-id="<?php echo esc_attr( $prevention->data['id'] ); ?>"
		     aria-label="<?php esc_html_e( 'Suivant', 'digirisk' ); ?>"
		     style="float:right">
			<span><i class="fas fa-2x fa-long-arrow-alt-right"></i></span>
		</div>

	</div>
</div>
