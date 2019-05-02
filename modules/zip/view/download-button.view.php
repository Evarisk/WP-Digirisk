<?php
/**
 * Le bouton "Télécharger le ZIP"
 *
 * @author Evarisk <dev@evarisk.com>
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
	<a class="wpeo-button button-purple button-square-50 wpeo-tooltip-event"
		href="<?php echo esc_attr( $zip_url ); ?>"
		aria-label="<?php echo esc_attr_e( 'ZIP', 'digirisk' ); ?>">
		<i class="fas fa-file-archive" aria-hidden="true"></i>
	</a>
<?php else : ?>
	<span class="wpeo-button button-grey button-square-50 wpeo-tooltip-event" data-color="red" aria-label="<?php echo esc_attr_e( 'ZIP Corrompu', 'digirisk' ); ?>">
		<i class="fas fa-times button-icon" aria-hidden="true"></i>
	</span>
<?php endif; ?>
