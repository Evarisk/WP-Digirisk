<?php
/**
 * L'affichage légal, inclus tous les templates nécessaires
 *
 * @author    Evarisk <dev@evarisk.com>
 * @since     6.0.0
 * @version   7.0.0
 * @copyright 2018 Evarisk.
 * @package   DigiRisk
 */

namespace digi;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
} ?>

<form action="<?php echo esc_attr( admin_url( 'admin-ajax.php' ) ); ?>" class="form" method="post">
	<input type="hidden" name="parent_id" value="<?php echo esc_attr( $element_id ); ?>" />
	<?php wp_nonce_field( 'save_legal_display' ); ?>

	<div class="wpeo-gridlayout padding grid-2">
		<?php
		\eoxia\View_Util::exec( 'digirisk', 'legal_display', 'form/detective-work', array(
			'legal_display' => $legal_display,
		) );

		\eoxia\View_Util::exec( 'digirisk', 'legal_display', 'form/occupational-health-service', array(
			'legal_display' => $legal_display,
		) );

		\eoxia\View_Util::exec( 'digirisk', 'legal_display', 'form/emergency-service', array(
			'legal_display' => $legal_display,
		) );

		\eoxia\View_Util::exec( 'digirisk', 'legal_display', 'form/safety-rules', array(
			'legal_display' => $legal_display,
		) );

		?>
	</div>

	<div class="clear">
		<?php
			\eoxia\View_Util::exec( 'digirisk', 'legal_display', 'form/working-hours', array(
				'legal_display' => $legal_display,
			) );

		?>
	</div>

	<div class="wpeo-gridlayout padding grid-2">
		<?php
		\eoxia\View_Util::exec( 'digirisk', 'legal_display', 'form/derogations-schedules', array(
			'legal_display' => $legal_display,
		) );

		\eoxia\View_Util::exec( 'digirisk', 'legal_display', 'form/collective-agreement', array(
			'legal_display' => $legal_display,
		) );

		\eoxia\View_Util::exec( 'digirisk', 'legal_display', 'form/rule', array(
			'legal_display' => $legal_display,
		) );

		\eoxia\View_Util::exec( 'digirisk', 'legal_display', 'form/DUER', array(
			'legal_display' => $legal_display,
		) );

		\eoxia\View_Util::exec( 'digirisk', 'legal_display', 'form/participation-agreement', array(
			'legal_display' => $legal_display,
		) );

		?>
	</div>

	<div class="alignright">
		<button data-action="save_legal_display" class="wpeo-button button-main button-green action-input" data-parent="form">
			<i class="button-icon fas fa-sync-alt"></i>
			<span><?php esc_html_e( 'Enregister les modifications', 'digirisk' ); ?></span>
		</button>

		<button data-action="generate_legal_display" class="wpeo-button button-main action-input" data-parent="form">
			<i class="button-icon fas fa-sync-alt"></i>
			<span><?php esc_html_e( 'Générer les affichages légaux A3 et A4', 'digirisk' ); ?></span>
		</button>
	</div>
</form>
