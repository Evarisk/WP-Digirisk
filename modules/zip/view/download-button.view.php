<?php
/**
 * Le bouton "Télécharger le ZIP"
 *
 * @author Jimmy Latour <jimmy@evarisk.com>
 * @since 1.0
 * @version 6.2.5.0
 * @copyright 2015-2017 Evarisk
 * @package zip
 * @subpackage view
 */

namespace digi;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
} ?>

<a class="button dark h50" href="<?php echo esc_attr( $zip_url ); ?>">
	<i class="fa fa-file-archive-o" aria-hidden="true"></i>
	<span><?php esc_html_e( 'ZIP', 'digirisk' ); ?></span>
</a>
