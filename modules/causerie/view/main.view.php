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

	<ul class="tab" data-nonce="<?php echo esc_attr( wp_create_nonce( 'causerie_load_tab' ) ); ?>">
		<li class="tab-element active" data-tab="dashboard"><?php esc_html_e( 'Dashboard', 'digirisk' ); ?></li>
		<li class="tab-element" data-tab="start"><?php esc_html_e( 'Démarrer une causerie', 'digirisk' ); ?></li>
		<li class="tab-element" data-tab="form"><?php esc_html_e( 'Bibliothèque des causeries', 'digirisk' ); ?></li>
	</ul>

	<div class="ajax-content main-content">
		<?php Causerie_Page_Class::g()->display_dashboard(); ?>
	</div>
</div>
