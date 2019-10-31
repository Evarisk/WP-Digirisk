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

<div class="content-wrap">
	<?php Digirisk::g()->display_header(); ?>

	<div class="wrap wpeo-wrap digirisk-wrap">
		<div class="wpeo-tab">
			<ul class="tab-list">
				<li class="tab-element <?php echo ( 'digi-general' === $default_tab ) ? 'tab-active' : ''; ?>" href="#" data-target="digi-general" ><?php esc_html_e( 'Général', 'digirisk' ); ?></li>
				<li class="tab-element <?php echo ( 'digi-capability' === $default_tab ) ? 'tab-active' : ''; ?>" href="#" data-target="digi-capability" ><?php esc_html_e( 'Capacités', 'digirisk' ); ?></li>
				<li class="tab-element <?php echo ( 'digi-accronym' === $default_tab ) ? 'tab-active' : ''; ?>" href="#" data-target="digi-accronym" ><?php esc_html_e( 'Accronymes', 'digirisk' ); ?></li>
				<li class="tab-element <?php echo ( 'digi-danger-preset' === $default_tab ) ? 'tab-active' : ''; ?>" href="#" data-target="digi-danger-preset" ><?php esc_html_e( 'Danger preset', 'digirisk' ); ?></li>
				<li class="tab-element <?php echo ( 'digi-child' === $default_tab ) ? 'tab-active' : ''; ?>" href="#" data-target="digi-child" ><?php esc_html_e( 'Enfant', 'digirisk' ); ?></li>
				<li class="tab-element <?php echo ( 'digi-configuration' === $default_tab ) ? 'tab-active' : ''; ?>" href="#" data-target="digi-configuration" ><?php esc_html_e( 'Configuration', 'digirisk' ); ?></li>
				<li class="tab-element <?php echo ( 'digi-htpasswd' === $default_tab ) ? 'tab-active' : ''; ?>" href="#" data-target="digi-htpasswd" ><?php esc_html_e( 'Htpasswd', 'digirisk' ); ?></li>
			</ul>
				<?php /* <a class="nav-tab <?php echo ( 'digi-define-prefix' === $default_tab ) ? 'nav-tab-active' : ''; ?>" href="#" data-id="digi-define-prefix" ><?php esc_html_e( 'Prefix ODT', 'digirisk' ); ?></a> */ ?>
			<div class="tab-container">
				<div id="digi-general" class="tab-content <?php echo ( 'digi-general' === $default_tab ) ? 'tab-active' : ''; ?>">
					<?php
					\eoxia\View_Util::exec( 'digirisk', 'setting', 'general/main', array(
						'can_edit_risk_category'     => $can_edit_risk_category,
						'can_edit_type_cotation'     => $can_edit_type_cotation,
						'general_options'            => $general_options,
					) );
					?>
				</div>

				<div id="digi-capability" class="tab-content <?php echo ( 'digi-capability' === $default_tab ) ? 'tab-active' : ''; ?>">
					<?php
					\eoxia\View_Util::exec( 'digirisk', 'setting', 'capability/main' );
					?>
				</div>

				<div id="digi-accronym" class="tab-content <?php echo ( 'digi-accronym' === $default_tab ) ? 'tab-active' : ''; ?>">
					<?php
					\eoxia\View_Util::exec( 'digirisk', 'setting', 'accronym/form', array(
						'list_accronym' => $list_accronym,
					) );
					?>
				</div>

				<div id="digi-danger-preset" class="tab-content <?php echo ( 'digi-danger-preset' === $default_tab ) ? 'tab-active' : ''; ?>">
						<?php
						\eoxia\View_Util::exec( 'digirisk', 'setting', 'preset/main', array(
							'dangers_preset' => $dangers_preset,
						) );
						?>
				</div>

				<div id="digi-child" class="tab-content <?php echo ( 'digi-child' === $default_tab ) ? 'tab-active' : ''; ?>">
						<?php
						\eoxia\View_Util::exec( 'digirisk', 'setting', 'child/main', array(
							'require_unique_security_id' => $require_unique_security_id,
							'unique_security_id'         => $unique_security_id,
							'parent_sites'               => $parent_sites,
						) );
						?>
				</div>

				<div id="digi-configuration" class="tab-content <?php echo ( 'digi-configuration' === $default_tab ) ? 'tab-active' : ''; ?>">
					<div class="">
						<?php
						$element    = Society_Class::g()->get_societies_in( 0 );
						Society_Configuration_Class::g()->display( $element[0] );
						?>
					</div>
					<style media="screen">
						.main-information-society .wpeo-notice{
							border : solid #c1b5b5 1px;
							background-color : #c3c3c366;
						}
					</style>
				</div>

				<div id="digi-htpasswd" class="tab-content <?php echo ( 'digi-htpasswd' === $default_tab ) ? 'tab-active' : ''; ?>">
					<?php Setting_Class::g()->display_htpasswd(); ?>
				</div>

				<?php /*
				<div id="digi-define-prefix" class="tab-content <?php echo ( 'digi-define-prefix' === $default_tab ) ? 'tab-active' : ''; ?>">
						<?php
						\eoxia\View_Util::exec( 'digirisk', 'setting', 'prefix/main', array(
							'prefix' => $prefix,
						) );
						?>
				</div>
				*/
			 	?>
			</div>
		</div>
	</div>
</div>
