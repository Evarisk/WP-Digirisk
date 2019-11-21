<?php
/**
 * Gestion du header pour les multisites.
 *
 * @author Evarisk <dev@evarisk.com>
 * @since 0.3.0
 * @copyright 2015-2019 Evarisk
 * @package DigiRiskDashboard
 */

namespace eoxia;

defined( 'ABSPATH' ) || exit;
if ( count( $sites ) === 0 ) :
	?>
	<li class="current-site">
		<span><?php echo $current_site->blogname; ?></span>
	</li>
<?php
else :
	?>
	<li class="current-site">
		<div class="wpeo-dropdown dropdown-right">
			<div class="dropdown-toggle wpeo-button button-main"><span><?php echo '#' . $current_site->blog_id . ' - ' . $current_site->blogname; ?></span><i class="button-icon fas fa-caret-down"></i></div>

			<div class="dropdown-content dropdown-sites">
			<span class="search-item form-element">
				<input type="text" class="form-field" placeholder="Rechercher" />
			</span>
				<?php
				if ( ! empty( $sites ) ) :
					foreach ( $sites as $site ) :
						?>
						<a href="<?php echo get_site_url( $site->blog_id, 'wp-admin' ); echo ! empty( $page ) ? '/admin.php?page=' . $_GET['page'] : ''; ?>" class="dropdown-item">
							<?php echo $site->site_info->blogname; ?>
						</a>
					<?php
					endforeach;
				endif;
				?>
			</div>

		</div>
	</li>
<?php
endif;
