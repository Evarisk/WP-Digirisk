<?php
/**
 * Affichage principale de la page "Causeries".
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

<div class="content-wrap">
	<?php Digirisk::g()->display_header(); ?>

	<div class="wrap wrap-permis-feu digirisk-wrap wpeo-wrap">
		<div class="wpeo-tab">
			<ul class="tab-list">
				<li class="tab-element tab-active"
				data-action="permisfeu_load_tab"
				data-nonce="<?php echo esc_attr( wp_create_nonce( "permisfeu_load_tab" ) ); ?>"
				data-tab="<?php echo esc_attr( 'dashboard' ); ?>">
					<?php esc_html_e( 'Dashboard', 'digirisk' ); ?>
				</li>

				<?php // if ( user_can( get_current_user_id(), 'manage_permisfeu' ) ): ?>
					<li class="tab-element"
					data-action="permisfeu_load_tab"
					data-nonce="<?php echo esc_attr( wp_create_nonce( "permisfeu_load_tab" ) ); ?>"
					data-tab="<?php echo esc_attr( 'progress' ); ?>">
						<?php esc_html_e( 'En cours', 'digirisk' ); ?>
					</li>
				<?php // endif; ?>
			</ul>

			<div class="tab-content main-content">
				<?php Permis_Feu_Page_Class::g()->display_dashboard(); ?>
			</div>
		</div>
	</div>
</div>
