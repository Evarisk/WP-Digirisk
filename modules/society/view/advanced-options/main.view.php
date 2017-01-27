<?php
/**
 * Ajoutes le champs pour déplacer une societé vers une autre.
 *
 * @author Jimmy Latour <jimmy@evarisk.com>
 * @since 6.2.5.0
 * @version 6.2.5.0
 * @copyright 2015-2017 Evarisk
 * @package society
 * @subpackage view
 */

namespace digi;

if ( ! defined( 'ABSPATH' ) ) {	exit; } ?>

<form method="POST" class="form" action="<?php echo esc_attr( admin_url( 'admin-ajax.php' ) ); ?>">
	<input type="hidden" name="action" value="advenced_options_move_to" />
	<?php wp_nonce_field( 'advenced_options_move_to' ); ?>

	<ul class="grid-layout w2">
		<li class="form-element <?php echo esc_attr( ! empty( $element->title ) ? 'active' : '' ); ?>">
			<input type="text" value="<?php echo esc_attr( $element->title ); ?>" />
			<label><?php esc_html_e( 'Entrer l\'identifiant ou le nom du GP', 'digirisk' ); ?></label>
			<span class="bar"></span>
		</li>
		<li>
			<button class="button blue submit-form"><?php esc_html_e( 'Déplacer', 'digirisk' ); ?></button>
		</li>
	</ul>
</form>
