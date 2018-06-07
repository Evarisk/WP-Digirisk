<?php
/**
 * Interface "dashboard" des causeries
 *
 * @author Evarisk <dev@evarisk.com>
 * @since 6.6.0
 * @version 6.6.0
 * @copyright 2015-2018 Evarisk
 * @package DigiRisk
 */

namespace digi;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
} ?>

<div class="wpeo-grid grid-2">
	<div><?php esc_html_e( 'Nombre de risque concernés ce mois-ci', 'digirisk' ); ?></div>
	<div>
		<h2><?php esc_html_e( 'Stats d\'avril 2018', 'digirisk' ); ?></h2>
		<ul>
			<li><?php esc_html_e( 'Participants:', 'digirisk' ); ?> <strong>40</strong></li>
			<li><?php esc_html_e( 'Causeries:', 'digirisk' ); ?> <strong>10</strong></li>
			<li><?php esc_html_e( 'Formateurs:', 'digirisk' ); ?>: <strong>3</strong></li>
		</ul>
	</div>
</div>

<div>
	<h2><?php esc_html_e( 'Dernières causeries réalisées', 'digirisk' ); ?></h2>

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
		if ( ! empty( $final_causeries ) ) :
			foreach ( $final_causeries as $causerie ) :
				\eoxia\View_Util::exec( 'digirisk', 'causerie', 'dashboard/list-item', array(
					'causerie' => $causerie,
				) );
			endforeach;
		endif;
		?>
	</table>

	<!-- Pagination -->
	<?php if ( ! empty( $current_page ) && ! empty( $number_page ) ) : ?>
		<div class="wp-digi-pagination">
			<?php
			echo paginate_links( array(
				'base'               => admin_url( 'admin-ajax.php?action=digirisk-setting&tab=digi-capability&current_page=%_%' ),
				'format'             => '%#%',
				'current'            => $current_page,
				'total'              => $number_page,
				'before_page_number' => '<span class="screen-reader-text">' . __( 'Page', 'digirisk' ) . ' </span>',
				'type'               => 'plain',
				'next_text'          => '<i class="dashicons dashicons-arrow-right"></i>',
				'prev_text'          => '<i class="dashicons dashicons-arrow-left"></i>',
			) );
			?>
		</div>
	<?php endif; ?>
</div>
