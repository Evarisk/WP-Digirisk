<?php
/**
 * Affichages du header pour toutes les pages.
 *
 * @author Eoxia <technique@eoxia.com>
 * @since 1.0.0
 * @copyright 2015-2019 Eoxia
 * @package Eoxia
 */

namespace eoxia;

defined( 'ABSPATH' ) || exit; ?>

<div id="top-header" class="ui sticky">
	<?php echo apply_filters( 'eoxia_main_header_before', '' ); ?>

	<div class="alignleft">
		<div class="alignleft floated column"><h4 class="page-title"><?php echo esc_html( apply_filters( 'eoxia_main_header_title', get_admin_page_title() ) ); ?></h4></div>
	</div>

	<ul class="nav-header alignleft">
		<?php echo apply_filters( 'eoxia_main_header_li', '' ); ?>
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
		<?php echo apply_filters( 'eoxia_main_header_ul_after', '' ); ?>
	</ul>

	<?php echo apply_filters( 'eoxia_main_header_after', '' ); ?>
</div>
