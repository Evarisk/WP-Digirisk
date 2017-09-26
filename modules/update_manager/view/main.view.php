<?php
/**
 * La vue principale pour les mises à jour.
 *
 * @author Jimmy Latour <jimmy@evarisk.com>
 * @since 6.2.8
 * @version 6.3.0
 * @copyright 2015-2017 Evarisk
 * @package DigiRisk
 */

namespace digi;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
} ?>

<h1><?php esc_html_e( 'Mise à jour de DigiRisk', 'digirisk' ); ?></h1>
<?php if ( ! empty( $waiting_updates ) ) : ?>
	<?php foreach ( $waiting_updates as $version => $data ) : ?>
		<input type="hidden" name="version_available[]" value="<?php echo esc_attr( $version ); ?>" />

		<?php foreach ( $data as $index => $def ) : ?>
			<input type="hidden" name="version[<?php echo esc_attr( $version ); ?>][action][]" value="<?php echo esc_attr( $def['action'] ); ?>" />
			<input type="hidden" name="version[<?php echo esc_attr( $version ); ?>][description][]" value="<?php echo esc_attr( $def['description'] ); ?>" />
		<?php endforeach; ?>
	<?php endforeach; ?>
<?php else : ?>
	<?php esc_html_e( 'Rien à faire ici,', 'digirisk' ); ?>
	<strong><a href="<?php echo esc_attr( admin_url( '?page=digirisk-simple-risk-evaluation' ) ); ?>"><?php echo esc_html_e( 'retour à l\'application.', 'digirisk' ); ?></a></strong>
<?php endif; ?>

<ul class="log"></ul>
