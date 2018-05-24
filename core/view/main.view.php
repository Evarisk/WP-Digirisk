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
 * @version 6.6.0
 */

namespace digi;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
} ?>

<div class="digirisk-wrap" style="clear: both;">

	<?php do_shortcode( '[digi_navigation id="' . $id . '"]' ); ?>
	<?php do_shortcode( '[digi_content id="' . $id . '"]' ); ?>

	<?php
	if ( strpos( @$_SERVER['HTTP_USER_AGENT'], 'Trident/7.0; rv:11.0' ) !== false || strpos( 'MSIE', @$_SERVER['HTTP_USER_AGENT'] ) !== false ) :
		require PLUGIN_DIGIRISK_PATH . '/core/view/ie-no-supported.view.php';
	else :

		$waiting_updates = get_option( '_digi_waited_updates', array() );
		if ( ! empty( $waiting_updates ) && strpos( $_SERVER['REQUEST_URI'], 'admin.php' ) && ! strpos( $_SERVER['REQUEST_URI'], 'admin.php?page=digirisk-update' ) && ! strpos( $_SERVER['REQUEST_URI'], 'admin.php?page=digi-setup' ) ) :
			\eoxia\View_Util::exec( 'digirisk', 'update_manager', 'say-to-update' );
		endif;

		$version = get_user_meta( get_current_user_id(), '_wpdigi_user_change_log', true );

		if ( empty( $version[ \eoxia\Config_Util::$init['digirisk']->version ] ) ) :
			require PLUGIN_DIGIRISK_PATH . '/core/view/patch-note.view.php';
		endif;
	endif;
	?>
</div>
