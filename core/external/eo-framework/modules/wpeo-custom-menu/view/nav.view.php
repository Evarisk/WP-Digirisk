<?php
/**
 * Display Nav Menu.
 *
 * @author Eoxia <techinque@eoxia.com>
 * @since 1.0.0
 * @copyright 2015-2019 Eoxia
 * @package EOFramework
 */

namespace eoxia;

defined( 'ABSPATH' ) || exit;

$minimize_menu = get_user_meta( get_current_user_id(), '_eo_menu_minimize', true );
$minimize_menu = empty( $minimize_menu ) ? false : true;
?>

<div class="nav-wrap <?php echo $minimize_menu ? 'wrap-reduce' : ''; ?>">
	<div id="logo">
		<h1><a href="<?php echo $logo_url; ?>"><img src="<?php echo $logo_src; ?>" alt="Logo" /></a></h1>
	</div>

	<?php
	if ( ! empty( $menus ) ) :
		foreach ( $menus as $key_menu => $menu ) :
			?>
		<div class="nav-menu nav-<?php echo $menu['position']; ?>">
			<?php
			if ( ! empty( $menu['items'] ) ) :
				foreach ( $menu['items'] as $key => $item ) :
					if ( 'hidden' !== $item->position ) :
						$active = "";
						if ( $key == $_REQUEST['page'] ) :
							$active = "item-active";
						endif;

						$have_right = false;

						if ( current_user_can( $item->capability ) ) :
							$have_right = true;
						endif;

						if ( empty( $item->capability ) ):
							$have_right = true;
						endif;

						if ( $have_right ) :
							?>
							<a class="item <?php echo esc_attr( $item->class ); ?> <?php echo esc_attr( $active ); ?> item-<?php echo 'nav-' . $item->position; ?>" href="<?php echo esc_url( $item->link ); ?>"
								<?php echo isset( $item->additional_attrs ) ? esc_attr( $item->additional_attrs ) : ''; ?>>
								<div>
									<?php
									if ( ! empty( $item->icon_url ) ) :
										if ( strpos( $item->icon_url, 'http' ) !== FALSE ) :
											?>
											<img src="<?php echo esc_attr( $item->icon_url ); ?>" />
										<?php
										else:
											?>
											<i class="<?php echo esc_attr( $item->icon_url ); ?>"></i>
										<?php
										endif;
									endif;
									?>
									<span href="<?php echo esc_url( $item->link ); ?>"><?php echo esc_html( $item->page_title ); ?></span>
								</div>
							</a>
						<?php
						else :
							?>
							<div aria-label="<?php esc_html_e( 'You don\'t have right for view this page', 'eoxia' ); ?>>"
								 data-direction="right"
								 class="wpeo-tooltip-event item <?php echo esc_attr( $item->class ); ?>"><span class="disabled"><?php echo esc_html( $item->page_title ); ?></span></div>
						<?php
						endif;
					endif;
				endforeach;
				?>
				</div>
			<?php
			endif;
		endforeach;
	endif;
	?>
</div>
