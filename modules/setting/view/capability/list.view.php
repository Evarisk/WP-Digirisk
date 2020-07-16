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

<div class="settings-users-content">
	<div class="wpeo-table table-flex users">
		<div class="table-row table-header">
			<div class="table-cell table-50"></div>
			<div class="table-cell table-50"><?php esc_html_e( 'ID', 'digirisk' ); ?></div>
			<div class="table-cell table-75"><?php esc_html_e( 'Nom', 'digirisk' ); ?></div>
			<div class="table-cell table-75"><?php esc_html_e( 'Prénom', 'digirisk' ); ?></div>
			<div class="table-cell table-200"><?php esc_html_e( 'Email', 'digirisk' ); ?></div>
			<div class="table-cell table-100"><?php esc_html_e( 'Rôle', 'digirisk' ); ?></div>
			<div class="table-cell table-50"><?php esc_html_e( 'Tous', 'digirisk' ); ?></div>
			<div class="table-cell table-50"><?php esc_html_e( 'DU', 'digirisk' ); ?></div>
			<div class="table-cell table-50"><?php esc_html_e( 'Accidents', 'digirisk' ); ?></div>
			<div class="table-cell table-50"><?php esc_html_e( 'Causeries', 'digirisk' ); ?></div>
			<div class="table-cell table-50"><?php esc_html_e( 'Prevention plan', 'digirisk' ); ?></div>
			<div class="table-cell table-50"><?php esc_html_e( 'Permis feu', 'digirisk' ); ?></div>
			<div class="table-cell table-50"><?php esc_html_e( 'Listing risque', 'digirisk' ); ?></div>
			<div class="table-cell table-50"><?php esc_html_e( 'Organisation UT', 'digirisk' ); ?></div>
			<div class="table-cell table-50"><?php esc_html_e( 'Utilisateurs', 'digirisk' ); ?></div>
			<div class="table-cell table-50"><?php esc_html_e( 'Outils', 'digirisk' ); ?></div>
			<div class="table-cell table-50"><?php esc_html_e( 'Réglages', 'digirisk' ); ?></div>
		</div>
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
	</div>

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
