<?php
/**
 * Apelle la vue list.view du module causerie
 *
 * @author Jimmy Latour <jimmy@evarisk.com>
 * @since 6.5.0
 * @version 6.5.0
 * @copyright 2015-2017 Evarisk
 * @package DigiRisk
 */

namespace digi;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
} ?>

<div class="wrap digirisk-wrap">
	<h1><?php esc_html_e( 'Causeries sécurités', 'digirisk' ); ?></h1>

	<?php Causerie_Page_Class::g()->display_causerie_list(); ?>
</div>
