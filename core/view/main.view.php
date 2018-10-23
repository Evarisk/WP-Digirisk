<?php
/**
 * Vue principale de l'application
 * Exécutes deux shortcodes:
 *
 * [digi_navigation] pour afficher la navigation entre les différentes sociétés créées dans DigiRisk.
 * [digi_application] pour afficher l'application DigiRisk.
 *
 * @author    Evarisk <dev@evarisk.com>
 * @copyright (c) 2006-2018 Evarisk <dev@evarisk.com>.
 *
 * @license   AGPLv3 <https://spdx.org/licenses/AGPL-3.0-or-later.html>
 *
 * @package   DigiRisk\Templates
 *
 * @since     6.0.0
 */

namespace digi;

defined( 'ABSPATH' ) || exit; ?>

<div class="digirisk-wrap wpeo-wrap" style="clear: both;">
	<?php
	if ( ! empty( $waiting_updates ) && strpos( $_SERVER['REQUEST_URI'], 'admin.php' ) && ! strpos( $_SERVER['REQUEST_URI'], 'admin.php?page=' . \eoxia\Config_Util::$init['digirisk']->update_page_url ) ) :
		\eoxia\Update_Manager_Class::g()->display_say_to_update( 'digirisk', __( 'Need to update DigiRisk data', 'digirisk' ) );
	else :
		echo do_shortcode( '[digi_navigation id="' . $id . '"]' );
		echo do_shortcode( '[digi_application id="' . $id . '"]' );
	endif;

	$version = get_user_meta( get_current_user_id(), '_wpdigi_user_change_log', true );

	if ( empty( $version[ \eoxia\Config_Util::$init['digirisk']->version ] ) ) :
		require PLUGIN_DIGIRISK_PATH . '/core/view/patch-note.view.php';
	endif;
	?>
</div>
