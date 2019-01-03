<?php
/**
 * Apelle la vue list.view du module accident
 *
 * @author Evarisk <dev@evarisk.com>
 * @since 6.3.0
 * @version 6.4.0
 * @copyright 2015-2017 Evarisk
 * @package DigiRisk
 */

namespace digi;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
} ?>

<div class="wrap wpeo-wrap digirisk-wrap">
	<h1><?php esc_html_e( 'Les accidents bénins', 'digirisk' ); ?></h1>

	<?php Accident_Class::g()->display_accident_list(); ?>
</div>
