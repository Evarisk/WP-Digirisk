<?php
/**
 * La vue principale pour les mises à jour.
 *
 * @author Eoxia <dev@eoxia.com>
 * @since 1.0.0
 * @version 1.0.0
 * @copyright 2015-2018 Eoxia
 * @package EO_Framework\EO_Update_Manager\View
 */

namespace task_manager;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
} ?>

<div class="wpeo-wrap wpeo-project-wrap">
	<input type="hidden" class="user-id" value="<?php echo esc_attr( get_current_user_id() ); ?>" />
	<input type="hidden" name="action_when_update_finished" value="tm_redirect_to_dashboard" />

	<div class="wpeo-project-update-manager">

<?php if ( ! empty( $waiting_updates ) ) : ?>
	<?php foreach ( $waiting_updates as $version => $data ) : ?>
		<h2><?php /* Translators: %s represent current version number. */ echo esc_html( sprintf( __( 'List of updates for version %s', 'eoxia' ), $version ) ); ?></h2>

		<div class="notice notice-error" >
			<p><?php esc_html_e( 'Be careful, before using this data update manager, please back up your datas', 'eoxia' ); ?></p>
			<p><?php esc_html_e( 'You may loose data if you quit this page until the update is in progress', 'eoxia' ); ?></p>
		</div>

		<div class="wpeo-grid grid-3">
			<?php
			foreach ( $data as $index => $def ) :
				$total_number = null;
				$stats        = '';
				if ( isset( $def['count_callback'] ) && ! empty( $def['count_callback'] ) ) {
					$total_number = call_user_func( $def['count_callback'] );
					$stats        = '0 / ' . $total_number;
					if ( 0 === $total_number ) {
						$stats = __( 'No update requires for your installation', 'eoxia' );
					}
				}
			?>
			<div>
				<div class="wpeo-update-item <?php echo esc_attr( null === $total_number || 0 < $total_number ? 'wpeo-update-waiting-item' : 'wpeo-update-done-item' ); ?>" id="wpeo-upate-item-<?php echo esc_attr( $def['update_index'] ); ?>" >
					<div class="wpeo-update-item-spin">
						<span class="wpeo-update-spinner"><i class="fas fa-circle-notch fa-spin"></i></span>
						<i class="icon dashicons" ></i>
					</div>
					<div class="wpeo-update-item-container">
						<form action="<?php echo esc_url( admin_url( 'admin-ajax.php' ) ); ?>" method="POST">
							<input type="hidden" name="_wpnonce" value="<?php echo esc_attr( wp_create_nonce( $def['action'] ) ); ?>" />
							<input type="hidden" name="action" value="<?php echo esc_attr( $def['action'] ); ?>" />
							<div class="wpeo-update-item-content" >
								<div class="wpeo-update-item-title"><?php echo esc_attr( $def['title'] ); ?></div>
								<div class="wpeo-update-item-description"><?php echo esc_attr( $def['description'] ); ?></div>
							</div>
							<div class="wpeo-update-item-result" >
								<input type="hidden" name="total_number" value="<?php echo ( null !== $total_number ? esc_attr( $total_number ) : 0 ); ?>" />
								<input type="hidden" name="done_number" value="0" />
								<div class="wpeo-update-item-progress" >
									<div class="wpeo-update-item-progression" >&nbsp;</div>
									<div class="wpeo-update-item-stats" ><?php echo esc_html( $stats ); ?></div>
								</div>
							</div>
						</form>
					</div>
				</div>
			</div>
			<?php endforeach; ?>
		</div>
	<?php endforeach; ?>
	<div class="wpeo-update-waiting-item" id="wpeo-update-redirect-to-application" >
		<form action="<?php echo esc_url( admin_url( 'admin-ajax.php' ) ); ?>" method="POST">
			<input type="hidden" name="_wpnonce" value="<?php echo esc_attr( wp_create_nonce( $def['action'] ) ); ?>" />
			<input type="hidden" name="action" value="<?php echo esc_attr( $redirect_action ); ?>" />
			<input type="hidden" name="version" value="<?php echo esc_attr( $version ); ?>" />
		</form>
	</div>
	<div class="wpeo-update-general-message" ></div>
<?php else : ?>
		<h1><?php esc_html_e( 'Update manager', 'eoxia' ); ?></h1>
		<?php esc_html_e( 'No updates available for current version', 'eoxia' ); ?>
		<strong><a href="<?php echo esc_attr( admin_url( 'admin.php?page=' . $dashboard_url ) ); ?>"><?php echo esc_html_e( 'Back to main application', 'eoxia' ); ?></a></strong>
<?php endif; ?>
	</div>
</div>
