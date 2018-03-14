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

<div class="main-container">
	<div class="wpeo-tab">
		<?php do_shortcode( '[digi_dashboard id="' . $establishment_id . '"]' ); ?>
	</div>
</div>
