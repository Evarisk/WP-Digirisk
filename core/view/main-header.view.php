<?php
/**
 * Affichages du header pour toutes les pages.
 *
 * @author Evarisk <dev@evarisk.com>
 * @since 7.5.0
 * @copyright 2015-2019 Evarisk
 * @package DigiRisk
 */

namespace digi;

defined( 'ABSPATH' ) || exit;

$current_user = wp_get_current_user();

$link     = '';
if ( class_exists( 'user_switching' ) ) {
$old_user = \user_switching::get_old_user();
	if ( ! empty( $old_user ) ) {
		$link = add_query_arg( array(
			'redirect_to' => urlencode( \user_switching::current_url() ),
		), \user_switching::switch_back_url( $old_user ) );
	}
}
?>

<div id="top-header" class="ui sticky">
	<?php echo apply_filters( 'digirisk_main_header_before', '' ); ?>

	<div class="alignleft">
		<div class="alignleft floated column"><h4 class="page-title"><?php echo esc_html( apply_filters( 'digirisk_main_header_title', get_admin_page_title() ) ); ?></h4></div>
	</div>

	<ul class="nav-header alignleft">
		<?php echo apply_filters( 'digirisk_main_header_li', '' ); ?>
	</ul>

	<ul class="alignright nav-right" style="display: flex;">
		<li>
			<span>Bonjour, <?php echo esc_html( $current_user->display_name ); ?></span>
			<?php echo get_avatar( $current_user->ID, 24 ); ?>

			<?php
			if ( ! empty( $link ) ) :
				?>
				(<a href="<?php echo $link; ?>">Switch back (<?php echo $old_user->display_name; ?>)</a>)
				<?php
			endif;
			?>
		</li>
		<?php
		if ( is_multisite() ) :
			$sites = get_sites();

			usort( $sites, function( $a, $b ) {
				$al = strtolower($a->blogname);
        		$bl = strtolower($b->blogname);

				if ($al == $bl) {
		            return 0;
		        }
		        return ($al > $bl) ? +1 : -1;
			} );


			$current_site = get_blog_details( get_current_blog_id() );
			?>
			<li class="current-site">
				<div class="wpeo-dropdown dropdown-right">
				<div class="dropdown-toggle wpeo-button button-main"><span><?php echo '#' . $current_site->blog_id . ' - ' . $current_site->blogname; ?></span><i class="button-icon fas fa-caret-down"></i></div>
				<div class="dropdown-content dropdown-sites">
					<?php $one_site = false;
					if ( ! empty( $sites ) ) :
						foreach ( $sites as $site ) :
							if ( ! is_super_admin( get_current_user_id() ) && ( $site->blog_id == $current_site->blog_id || empty( get_user_meta( get_current_user_id(), 'wp_' . $site->blog_id . '_user_level', true ) ) ) ) :
								continue;
							endif;
							$one_site = true;
							$site_info = get_blog_details( $site->blog_id );
							?>
							<a href="<?php echo get_site_url( $site->blog_id, 'wp-admin' ); ?>" class="dropdown-item">
								<?php echo $site_info->blogname; ?>
							</a>
							<?php
						endforeach;
					endif;

					if ( ! $one_site ) :
						?>
						<a href="#" class="dropdown-item">
							<?php esc_html_e( 'Aucun site', 'digirisk' ); ?>
						</a>
						<?php
					endif;
					?>
				</div>
			</div>
			</li>
			<?php
		endif;
		?>
	</ul>

	<?php echo apply_filters( 'digirisk_main_header_after', '' ); ?>
</div>
