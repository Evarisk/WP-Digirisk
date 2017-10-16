<?php
/**
 * Vue principale de l'application
 * Utilises deux shortcodes
 * digi_navigation: Pour la navigation dans les groupements et les unités de travail
 * digi_content: Pour le contenu de l'application
 *
 * @package Evarisk\Plugin
 *
 * @since 6.0.0
 * @version 6.3.2
 */

namespace digi;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
} ?>

<div class="digirisk-wrap" style="clear: both;">
	<?php do_shortcode( '[digi_navigation id="' . $id . '"]' ); ?>
	<?php do_shortcode( '[digi_content id="' . $id . '"]' ); ?>

	<?php
	$version = get_user_meta( get_current_user_id(), '_wpdigi_user_change_log', true );

	if ( empty( $version[ \eoxia\Config_Util::$init['digirisk']->major_version ] ) ) :
		require( PLUGIN_DIGIRISK_PATH . '/core/view/patch-note.view.php' );
	endif;
	?>
</div>
