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

$old_user = \user_switching::get_old_user();
$link     = '';
if ( ! empty( $old_user ) ) {
	$link = add_query_arg( array(
		'redirect_to' => urlencode( \user_switching::current_url() ),
	), \user_switching::switch_back_url( $old_user ) );
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

	<ul class="alignright nav-right">
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
	</ul>

	<?php echo apply_filters( 'digirisk_main_header_after', '' ); ?>
</div>
