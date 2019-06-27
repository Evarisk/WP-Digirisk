<?php
/**
 * Gestion des onglets dans la page "digirisk-setting".
 *
 * @author Evarisk <dev@evarisk.com>
 * @since 6.0.0
 * @version 6.4.0
 * @copyright 2015-2017 Evarisk
 * @package DigiRisk
 */

namespace digi;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
} ?>

<div class="wrap wpeo-wrap">
	<h1><?php esc_html_e( 'Digirisk settings', 'digirisk' ); ?></h1>

	<div class="digi-tools-main-container">
		<h2 class="nav-tab-wrapper">
			<a class="nav-tab <?php echo ( 'digi-general' === $default_tab ) ? 'nav-tab-active' : ''; ?>" href="#" data-id="digi-general" ><?php esc_html_e( 'Général', 'digirisk' ); ?></a>
			<a class="nav-tab <?php echo ( 'digi-capability' === $default_tab ) ? 'nav-tab-active' : ''; ?>" href="#" data-id="digi-capability" ><?php esc_html_e( 'Capacités', 'digirisk' ); ?></a>
			<a class="nav-tab <?php echo ( 'digi-accronym' === $default_tab ) ? 'nav-tab-active' : ''; ?>" href="#" data-id="digi-accronym" ><?php esc_html_e( 'Accronymes', 'digirisk' ); ?></a>
			<a class="nav-tab <?php echo ( 'digi-danger-preset' === $default_tab ) ? 'nav-tab-active' : ''; ?>" href="#" data-id="digi-danger-preset" ><?php esc_html_e( 'Danger preset', 'digirisk' ); ?></a>
		</h2>

		<div class="digirisk-wrap">

			<div id="digi-general" class="tab-content <?php echo ( 'digi-general' === $default_tab ) ? '' : 'hidden'; ?>">
				<?php
				\eoxia\View_Util::exec( 'digirisk', 'setting', 'general/main', array(
					'can_edit_risk_category'     => $can_edit_risk_category,
					'can_edit_type_cotation'     => $can_edit_type_cotation,
					'require_unique_security_id' => $require_unique_security_id,
					'unique_security_id'         => $unique_security_id,
					'sites'                      => $sites,
					'general_options'            => $general_options,
				) );
				?>
			</div>

			<div id="digi-capability" class="tab-content <?php echo ( 'digi-capability' === $default_tab ) ? '' : 'hidden'; ?>">
				<?php
				\eoxia\View_Util::exec( 'digirisk', 'setting', 'capability/main' );
				?>
			</div>

			<div id="digi-accronym" class="tab-content <?php echo ( 'digi-accronym' === $default_tab ) ? '' : 'hidden'; ?>">
				<?php
				\eoxia\View_Util::exec( 'digirisk', 'setting', 'accronym/form', array(
					'list_accronym' => $list_accronym,
				) );
				?>
			</div>

			<div id="digi-danger-preset" class="tab-content <?php echo ( 'digi-danger-preset' === $default_tab ) ? '' : 'hidden'; ?>">
					<?php
					\eoxia\View_Util::exec( 'digirisk', 'setting', 'preset/main', array(
						'dangers_preset' => $dangers_preset,
					) );
					?>
			</div>
		</div>
	</div>
</div>
