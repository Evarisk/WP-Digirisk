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

<div class="wrap digirisk-wrap prevention-wrap wpeo-wrap">
	<a class="back" href="<?php echo esc_attr( admin_url( 'admin.php?page=digirisk-prevention' ) ); ?>">
		<i class="fas fa-arrow-left"></i>
		<span><?php esc_html_e( 'Retour à la liste des plans de préventions', 'digirisk' ); ?>
	</a>

	<h2 style="font-size: 25px; font-weight: 400">
		<?php if( $prevention->data[ 'is_end' ] ): ?>
			<?php esc_html_e( 'Plan de Prevention en modification', 'digirisk' ); ?> (#<?php echo esc_attr( $prevention->data[ 'id' ] ); ?>)
		<?php else: ?>
			<?php esc_html_e( 'Plan de Prevention en cours', 'digirisk' ); ?> (#<?php echo esc_attr( $prevention->data[ 'id' ] ); ?>)
	<?php endif; ?>
	</h2>

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
				<span class="title"><?php esc_html_e( 'Société extérieure', 'digirisk' ); ?></span></a>
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

	<div class="ajax-content digi-prevention-parent step-<?php echo esc_attr( $prevention->data['step'] ); ?>">
		<?php Prevention_Page_Class::g()->display_step_nbr( $prevention ); ?>
	</div>
</div>
