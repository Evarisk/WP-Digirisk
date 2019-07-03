<?php
/**
 * Affichage de la liste des utilisateurs pour affecter les capacités
 *
 * @author Evarisk <dev@evarisk.com>
 * @since 6.4.0
 * @version 6.4.0
 * @copyright 2015-2017 Evarisk
 * @package DigiRisk
 */

namespace digi;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
} ?>

<div class="list-users">
	<table class="table users">
		<thead>
			<tr>
				<td class="w50"></td>
				<td class="w50 padding"><?php esc_html_e( 'ID', 'digirisk' ); ?></td>
				<td class="padding"><?php esc_html_e( 'Nom', 'digirisk' ); ?></td>
				<td class="padding"><?php esc_html_e( 'Prénom', 'digirisk' ); ?></td>
				<td class="padding"><?php esc_html_e( 'Email', 'digirisk' ); ?></td>
				<td class="padding"><?php esc_html_e( 'Rôle', 'digirisk' ); ?></td>
				<td class="padding"><?php esc_html_e( 'A les droit sur DigiRisk', 'digirisk' ); ?></td>
			</tr>
		</thead>
		<?php
		if ( ! empty( $users ) ) :
			foreach ( $users as $user ) :
				\eoxia\View_Util::exec( 'digirisk', 'setting', 'capability/list-item', array(
					'user'                 => $user,
					'has_capacity_in_role' => $has_capacity_in_role,
				) );
			endforeach;
		endif;
		?>
	</table>

	<!-- Pagination -->
	<?php if ( ! empty( $current_page ) && ! empty( $number_page ) ) : ?>
		<div class="wp-digi-pagination">
			<?php
			$big = 999999999;
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
