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

<div class="wrap wrap-causerie digirisk-wrap">
	<h2><?php esc_html_e( 'Causeries', 'digirisk' ); ?></h2>

	<div class="wpeo-tab">
		<ul class="tab-list">
			<li class="tab-element tab-active" data-action="causerie_load_tab" data-nonce="<?php echo esc_attr( wp_create_nonce( "causerie_load_tab" ) ); ?>" data-tab="dashboard"><?php esc_html_e( 'Dashboard', 'digirisk' ); ?></li>

			<?php
			if ( user_can( get_current_user_id(), 'manage_causerie' ) ) :
				?>
				<li class="tab-element" data-action="causerie_load_tab" data-nonce="<?php echo esc_attr( wp_create_nonce( "causerie_load_tab" ) ); ?>" data-tab="start"><?php esc_html_e( 'Démarrer une causerie', 'digirisk' ); ?></li>
				<?php
			endif;

			if ( user_can( get_current_user_id(), 'create_causerie' ) ) :
				?>
				<li class="tab-element" data-action="causerie_load_tab" data-nonce="<?php echo esc_attr( wp_create_nonce( "causerie_load_tab" ) ); ?>" data-tab="form"><?php esc_html_e( 'Bibliothèque des causeries', 'digirisk' ); ?></li>
				<?php
			endif;
			?>
		</ul>

		<div class="tab-content main-content">
			<?php Causerie_Page_Class::g()->display_start(); ?>
		</div>
	</div>
</div>
