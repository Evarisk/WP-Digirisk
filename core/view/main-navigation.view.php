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

				if ( $key == $_GET['page'] ) :
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
					<div class="item <?php echo esc_attr( $item['class'] ); ?> <?php echo esc_attr( $active ); ?>">
						<a href="<?php echo esc_url( $item['link'] ); ?>"><?php echo esc_html( $item['title'] ); ?></a>
					</div>
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
					<div class="item">
						<a href="<?php echo esc_url( $item['link'] ); ?>"><?php echo esc_html( $item['title'] ); ?></a>
					</div>
					<?php
				endforeach;
			endif;
			?>
		</div>
	</div>
</div>
