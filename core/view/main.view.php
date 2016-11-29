<?php
/**
 * Vue principale de l'application
 * Utilises deux shortcodes
 * digi_navigation: Pour la navigation dans les groupements et les unités de travail
 * digi_content: Pour le contenu de l'application
 *
 * @package Evarisk\Plugin
 */

namespace digi;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
?>

<div class="wp-digi-societytree-main-container wp-digi-bloc-loader">
	<?php do_shortcode( '[digi_navigation]' ); ?>
	<?php do_shortcode( '[digi_content]' ); ?>
</div>
