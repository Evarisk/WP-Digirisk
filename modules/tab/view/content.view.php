<?php
/**
 * Affiches le contenu principale
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

<div class="tab-container">
	<div class="tab-content tab-active">
		<h1><?php echo esc_html( $title ); ?></h1>
		<?php echo do_shortcode( '[' . $tab_to_display . ' post_id="' . $element_id . '" ]' ); ?>
	</div>
</div>
