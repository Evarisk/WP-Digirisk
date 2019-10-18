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


<div class="content-wrap">
	<?php require PLUGIN_DIGIRISK_PATH . '/core/view/main-header.view.php'; ?>
	<div class="wrap wrap-causerie digirisk-wrap wpeo-wrap">
		<div class="wpeo-tab">
			<ul class="tab-list tab-select-redirect">
				<li class="tab-element <?php echo $page == "dashboard" ? 'tab-active' : ''; ?>" data-tab="dashboard" data-url="<?php echo esc_attr( admin_url( 'admin.php?page=digirisk-causerie&tab=dashboard' ) ); ?>">
					<?php esc_html_e( 'Dashboard', 'digirisk' ); ?>
				</li>

				<?php
				if ( user_can( get_current_user_id(), 'manage_causerie' ) ) :
					?>
					<li class="tab-element <?php echo $page == "start" ? 'tab-active' : ''; ?>" data-url="<?php echo esc_attr( admin_url( 'admin.php?page=digirisk-causerie&tab=start' ) ); ?>" data-tab="start">
						<?php esc_html_e( 'Démarrer une causerie', 'digirisk' ); ?>
					</li>

					<?php
				endif;

				if ( user_can( get_current_user_id(), 'create_causerie' ) ) :
					?>
					<li class="tab-element <?php echo $page == "form" ? 'tab-active' : ''; ?>" data-url="<?php echo esc_attr( admin_url( 'admin.php?page=digirisk-causerie&tab=form' ) ); ?>" data-tab="form"><?php esc_html_e( 'Bibliothèque des causeries', 'digirisk' ); ?></li>
					<?php
				endif;
				?>
			</ul>

			<div class="tab-content main-content">
				<?php
					if( $page == "dashboard" ):
						Causerie_Page_Class::g()->display_dashboard();
					elseif( $page == "start" ):
						Causerie_Page_Class::g()->display_start();
					elseif( $page == "form" ):
						Causerie_Page_Class::g()->display_form();
					endif;
				 ?>
			</div>
		</div>
	</div>
</div>
