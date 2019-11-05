<?php
/**
 * Le menu principale
 *
 * @author Evarisk <dev@evarisk.com>
 * @since 7.5.0
 * @copyright 2015-2019 Evarisk
 * @package DigiRisk
 */

namespace digi;

defined( 'ABSPATH' ) || exit; ?>

<div class="nav-wrap">
	<div id="logo">
		<h1><a href="<?php echo admin_url( 'admin.php?page=digirisk-welcome' ); ?>"><img src="<?php echo PLUGIN_DIGIRISK_URL . '/core/assets/images/favicon_hd.png'; ?>" alt="DigiRisk" /></a></h1>
	</div>

	<div class="nav-menu">
		<?php
		if ( ! empty( Digirisk::g()->menu ) ) :
			foreach ( Digirisk::g()->menu as $key => $item ) :
				$active = "";

				if ( $key == $_REQUEST['page'] ) :
					$active = "item-active";
				endif;

				$have_right = false;

				if ( current_user_can( $item['right'] ) ) {
					$have_right = true;
				}

				if ( empty( $item['right'] ) ) {
					$have_right = true;
				}

				if ( $have_right ) :
					?>
					<a class="item <?php echo esc_attr( $item['class'] ); ?> <?php echo esc_attr( $active ); ?>" href="<?php echo esc_url( $item['link'] ); ?>">
						<div>
							<?php
							if ( ! empty( $item['icon'] ) ) :
								?>
								<i class="<?php echo esc_attr( $item['icon'] ); ?>"></i>
								<?php
							endif;
							?>
							<span href="<?php echo esc_url( $item['link'] ); ?>"><?php echo esc_html( $item['title'] ); ?></span>
						</div>
					</a>
					<?php
				else :
					?>
					<div aria-label="Vous n'avez pas les droits pour accéder à cette page"
					 	data-direction="right"
						class="wpeo-tooltip-event item <?php echo esc_attr( $item['class'] ); ?>"><span class="disabled"><?php echo esc_html( $item['title'] ); ?></span></div>
					<?php
				endif;

			endforeach;
		endif;
		?>
		<div class="nav-menu item-bottom">
			<?php
			if ( ! empty( Digirisk::g()->menu_bottom ) ) :
				foreach ( Digirisk::g()->menu_bottom as $key => $item ) :
					?>
					<a class="item <?php echo esc_attr( $item['class'] ); ?>" href="<?php echo esc_url( $item['link'] ); ?>">
						<div>
							<?php
							if ( ! empty( $item['icon'] ) ) :
								?>
								<i class="<?php echo esc_attr( $item['icon'] ); ?>"></i>
								<?php
							endif;
							?>
							<span><?php echo esc_html( $item['title'] ); ?></span>
						</div>
					</a>
					<?php
				endforeach;
			endif;
			?>
		</div>
	</div>
</div>
