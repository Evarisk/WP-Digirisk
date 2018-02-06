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
		<i class="far fa-file-archive" aria-hidden="true"></i>
	</a>
<?php else : ?>
<<<<<<< HEAD
	<span class="button grey h50 tooltip hover red" aria-label="<?php echo esc_attr_e( 'ZIP Corrompu', 'digirisk' ); ?>">
		<i class="fa fa-times icon" aria-hidden="true"></i>
=======
	<span class="button grey h50 tooltip hover red" aria-label="<?php echo esc_attr_e( 'Corrompu', 'digirisk' ); ?>">
		<i class="far fa-times icon" aria-hidden="true"></i>
>>>>>>> 4193b35d61798b531a1a17e53fabe874155c4b92
	</span>
<?php endif; ?>
