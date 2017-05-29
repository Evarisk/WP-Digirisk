<?php
/**
 * L'affichage légal, inclus tous les templates nécessaires
 *
 * @author Jimmy Latour <jimmy@evarisk.com>
 * @since 0.1
 * @version 6.2.6.0
 * @copyright 2015-2017 Evarisk
 * @package legal_display
 * @subpackage view
 */

namespace digi;

if ( ! defined( 'ABSPATH' ) ) { exit; } ?>

<form action="<?php echo esc_attr( admin_url( 'admin-ajax.php' ) ); ?>" class="form" method="post">
	<input type="hidden" name="action" value="save_legal_display" />
	<input type="hidden" name="parent_id" value="<?php echo esc_attr( $element_id ); ?>" />
	<?php wp_nonce_field( 'save_legal_display' ); ?>

	<div class="grid-layout w2">
		<?php
		View_Util::exec( 'legal_display', 'form/detective-work', array(
			'legal_display' => $legal_display,
		) );

		View_Util::exec( 'legal_display', 'form/occupational-health-service', array(
			'legal_display' => $legal_display,
		) );

		View_Util::exec( 'legal_display', 'form/emergency-service', array(
			'legal_display' => $legal_display,
		) );

		View_Util::exec( 'legal_display', 'form/safety-rules', array(
			'legal_display' => $legal_display,
		) );

		?>
	</div>

	<div class="clear">
		<?php
			View_Util::exec( 'legal_display', 'form/working-hours', array(
				'legal_display' => $legal_display,
			) );

		?>
	</div>

	<div class="grid-layout w2">
		<?php
		View_Util::exec( 'legal_display', 'form/derogations-schedules', array(
			'legal_display' => $legal_display,
		) );

		View_Util::exec( 'legal_display', 'form/collective-agreement', array(
			'legal_display' => $legal_display,
		) );

		View_Util::exec( 'legal_display', 'form/rule', array(
			'legal_display' => $legal_display,
		) );

		View_Util::exec( 'legal_display', 'form/DUER', array(
			'legal_display' => $legal_display,
		) );

		View_Util::exec( 'legal_display', 'form/participation-agreement', array(
			'legal_display' => $legal_display,
		) );

		?>
	</div>

	<button class="button blue action-input float right" data-parent="form"><i class="icon fa fa-refresh"></i><span><?php esc_html_e( 'Générer les affichages légaux A3 et A4', 'digirisk' ); ?></span></button>
</form>
