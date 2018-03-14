<?php
/**
 * Vue principale de l'application
 * Utilises deux shortcodes
 * digi_navigation: Pour la navigation dans les groupements et les unités de travail
 * digi_content: Pour le contenu de l'application
 *
 * @author Jimmy Latour <jimmy@evarisk.com>
 * @since 6.0.0
 * @version 6.5.0
 * @copyright 2015-2018 Evarisk
 * @package DigiRisk
 */

namespace digi;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
} ?>

<div class="digirisk-wrap wpeo-wrap" style="clear: both;">
	<?php
	$waiting_updates = get_option( '_digi_waited_updates', array() );

	if ( ! empty( $waiting_updates ) && strpos( $_SERVER['REQUEST_URI'], 'admin.php' ) && ! strpos( $_SERVER['REQUEST_URI'], 'admin.php?page=digirisk-update' ) && ! strpos( $_SERVER['REQUEST_URI'], 'admin.php?page=digi-setup' ) ) :
		\eoxia\View_Util::exec( 'digirisk', 'update_manager', 'say-to-update' );
	else :
		do_shortcode( '[digi_navigation id="' . $id . '"]' );
		do_shortcode( '[digi_content id="' . $id . '"]' );
	endif;

	$version = get_user_meta( get_current_user_id(), '_wpdigi_user_change_log', true );

	if ( empty( $version[ \eoxia\Config_Util::$init['digirisk']->version ] ) ) :
		require PLUGIN_DIGIRISK_PATH . '/core/view/patch-note.view.php';
	endif;
	?>
</div>
