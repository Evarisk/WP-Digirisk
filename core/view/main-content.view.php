<?php
/**
 * Contenue principale de l'application
 *
 * @package Evarisk\Plugin
 */

namespace digi;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
?>

<div class="wp-digi-societytree-right-container wp-digi-bloc-loader">
	<?php do_shortcode( '[digi_dashboard id="' . $society_id . '"]' ); ?>
</div>
