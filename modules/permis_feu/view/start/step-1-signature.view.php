<?php
/**
 * Evaluation d'une causerie: étape 1, permet d'affecter le formateur et d'éditer sa signature.
 *
 * @author    Evarisk <dev@evarisk.com>
 * @since     6.6.0
 * @version   6.6.0
 * @copyright 2018 Evarisk.
 * @package   DigiRisk
 */

namespace digi;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
} ?>

<td>
	<img class="signature" class="" src="<?php echo esc_attr( wp_get_attachment_url( $permis_feu->data[$user_type]['signature_id'] ) ); ?>">
</td>

<?php if( isset( $user_type_attr ) && $user_type_attr != "" ): ?>
	<input type="hidden" name="<?php echo esc_attr( $user_type_attr ); ?>" value="ok">
<?php endif; ?>
