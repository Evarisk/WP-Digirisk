<?php
/**
 * Affiches le contenu principale
 *
 * @author Jimmy Latour <jimmy@evarisk.com>
 * @since 1.0
 * @version 6.2.3.0
 * @copyright 2015-2017 Evarisk
 * @package tab
 * @subpackage view
 */

namespace digi;

if ( ! defined( 'ABSPATH' ) ) { exit; } ?>

<div class="main-content">
	<?php echo do_shortcode( '[' . $tab_to_display . ' post_id="' . $element_id . '" ]' ); ?>
</div>
