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

namespace eoxia;

use eoxia\Custom_Menu_Handler as CMH;

defined( 'ABSPATH' ) || exit;

$minimize_menu = get_user_meta( get_current_user_id(), '_eo_menu_minimize', true );
$minimize_menu = empty( $minimize_menu ) ? false : $minimize_menu;
?>

<div class="content-wrap <?php echo esc_attr( $minimize_menu ) ? 'content-reduce' : ''; ?>">
	<?php require_once( PLUGIN_EO_FRAMEWORK_PATH . '/modules/wpeo-custom-menu/view/header.view.php' ); ?>

	<div class="wrap eo-wrap">
		<?php
		$this->display_screen_option();

		if ( is_array( $menu->function[0] ) ) {
			call_user_func(array($menu->function[0], $menu->function[1]));
		} else {
			call_user_func($menu->function);
		}
		?>
	</div>
</div>
