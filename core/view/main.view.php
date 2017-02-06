<?php
/**
 * Vue principale de l'application
 * Utilises deux shortcodes
 * digi_navigation: Pour la navigation dans les groupements et les unités de travail
 * digi_content: Pour le contenu de l'application
 *
 * @package Evarisk\Plugin
 *
 * @since 0.1
 * @version 6.2.4.0
 */

namespace digi;

if ( ! defined( 'ABSPATH' ) ) {	exit; } ?>

<div class="digirisk-wrap" style="clear: both;">
	<?php do_shortcode( '[digi_navigation id="' . $id . '"]' ); ?>
	<?php do_shortcode( '[digi_content id="' . $id . '"]' ); ?>
</div>
