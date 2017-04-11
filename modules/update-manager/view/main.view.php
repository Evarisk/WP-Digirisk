<?php
/**
 * La vue principale pour les mises à jour.
 *
 * @author Jimmy Latour <jimmy@evarisk.com>
 * @since 6.2.8.0
 * @version 6.2.8.0
 * @copyright 2015-2017 Evarisk
 * @package update-manager
 * @subpackage view
 */

namespace digi;

if ( ! defined( 'ABSPATH' ) ) {	exit; } ?>

<?php if ( ! empty( $waiting_updates ) ) : ?>
	<?php foreach ( $waiting_updates as $version => $data ) : ?>
		<input type="hidden" name="version_available[]" value="<?php echo esc_attr( $version ); ?>" />

		<?php foreach ( $data as $index => $def ) : ?>
			<input type="hidden" name="version[<?php echo esc_attr( $version ); ?>][action][]" value="<?php echo esc_attr( $def['action'] ); ?>" />
			<input type="hidden" name="version[<?php echo esc_attr( $version ); ?>][description][]" value="<?php echo esc_attr( $def['description'] ); ?>" />
		<?php endforeach; ?>
	<?php endforeach; ?>
<?php endif; ?>

<ul class="log"></ul>
