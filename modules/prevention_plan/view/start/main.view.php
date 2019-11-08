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

	<div class="step" style="margin-top: 20px; margin-bottom: 40px;">
		<div class="step-list">
			<a href="<?php echo Prevention_Class::g()->get_link( $prevention, 1 ); ?>" class="step	<?php echo ( in_array( $prevention->data['step'], array( 1, 2, 3 ) ) ) ? 'active' : ''; ?>"
				style="text-decoration: none;">
				<span class="title"><?php esc_html_e( 'Maitre oeuvre', 'digirisk' ); ?></span></a>
			<a href="<?php echo Prevention_Class::g()->get_link( $prevention, 2 ); ?>" class="step <?php echo ( in_array( $prevention->data['step'], array( 2, 3 ) ) ) ? 'active' : ''; ?>"
				data-width="50" style="text-decoration: none;">
				<span class="title"><?php esc_html_e( 'Plan de prévention', 'digirisk' ); ?></span></a>
			<a href="<?php echo Prevention_Class::g()->get_link( $prevention, 3 ); ?>" class="step <?php echo ( in_array( $prevention->data['step'], array( 3 ) ) ) ? 'active' : ''; ?>"
				data-width="100" style="text-decoration: none;">
				<span class="title"><?php esc_html_e( 'Société extérieure', 'digirisk' ); ?></span></a>
		</div>

		<div class="bar">
			<div class="background"></div>
			<div class="loader" data-width="<?php echo esc_attr( 37,5 * ( $prevention->data['step'] - 1 ) ); ?>" style="width:
			<?php if( $prevention->data['step'] == 3 ): echo '100%';
			elseif( $prevention->data['step'] == 2 ): echo '50%';
			else: echo '0%' ; endif; ?>	">
			</div>
		</div>
	</div>

	<div class="ajax-content digi-prevention-parent step-<?php echo esc_attr( $prevention->data['step'] ); ?>">
		<?php Prevention_Page_Class::g()->display_step_nbr( $prevention ); ?>
	</div>
</div>
