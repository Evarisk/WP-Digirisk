<?php
/**
 * La page principale des causeries.
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

<div>
	<h2 style="float: left"><?php esc_html_e( 'Dernières causeries réalisées', 'digirisk' ); ?></h2>
	<a href="<?php echo esc_attr( admin_url( 'admin.php?page=digirisk-setting&tab=digi-accronym' ) ); ?>"
		class="wpeo-tooltip-event" aria-label="<?php esc_html_e( 'Référence des causeries', 'digirisk' ); ?>" style="float: right;">
		<div class="wpeo-button button-main">
			<span><i class="icon fa fa-cog"></i></span>
		</div>
	</a>

	<table class="table closed-causerie">
		<thead>
			<tr>
				<td class="w50 padding"><?php esc_html_e( 'Ref.', 'digirisk' ); ?></td>
				<td class="w50 padding"><?php esc_html_e( 'Photo', 'digirisk' ); ?></td>
				<td class="w50 padding"><?php esc_html_e( 'Cat.', 'digirisk' ); ?></td>
				<td class="padding"><?php esc_html_e( 'Titre et description', 'digirisk' ); ?></td>
				<td class="padding"><?php esc_html_e( 'Date début', 'digirisk' ); ?></td>
				<td class="padding"><?php esc_html_e( 'Date cloture', 'digirisk' ); ?></td>
				<td class="padding"><?php esc_html_e( 'Formateur', 'digirisk' ); ?></td>
				<td class="padding"><?php esc_html_e( 'Participants', 'digirisk' ); ?></td>
				<td class="w50"></td>
			</tr>
		</thead>
		<?php
		if ( ! empty( $causeries_intervention ) ) :
			foreach ( $causeries_intervention as $causerie ) :
				$causerie = apply_filters( 'digi_add_custom_key_to_causerie', $causerie );
				\eoxia\View_Util::exec( 'digirisk', 'causerie', 'dashboard/list-item', array(
					'causerie' => $causerie,
				) );
			endforeach;
		else :
			?>
			<tr>
				<td colspan="9" style="text-align: center;"><?php esc_html_e( 'Aucune causerie réalisée pour le moment.', 'digirisk' ); ?></td>
			</tr>
			<?php
		endif;
		?>
	</table>
</div>
