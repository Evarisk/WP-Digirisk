<?php
/**
 * Le bouton "Télécharger le ZIP"
 *
 * @author Jimmy Latour <jimmy@evarisk.com>
 * @since 6.0.0
 * @version 6.4.4
 * @copyright 2015-2017 Evarisk
 * @package DigiRisk
 */

namespace digi;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
} ?>

<?php if ( ! empty( $zip_url ) ) : ?>
	<a class="button purple h50 tooltip hover"
		href="<?php echo esc_attr( $zip_url ); ?>"
		aria-label="<?php echo esc_attr_e( 'ZIP', 'digirisk' ); ?>">
		<i class="fa fa-file-archive-o" aria-hidden="true"></i>
	</a>
<?php else : ?>
	<span class="button grey h50 tooltip hover red" aria-label="<?php echo esc_attr_e( 'ZIP Corrompu', 'digirisk' ); ?>">
		<i class="fa fa-times icon" aria-hidden="true"></i>
	</span>
<?php endif; ?>
