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

defined( 'ABSPATH' ) || exit; ?>

<input type="hidden" name="id" value="<?php echo esc_attr( $id ); ?>" />
<input type="hidden" name="signature_data" />
<input type="hidden" class="url" value="<?php echo esc_attr( $url ); ?>" />
<input type="hidden" name="key" value="<?php echo esc_attr( $key ); ?>" />
<input type="hidden" name="type" value="<?php echo esc_attr( $type ); ?>" />

<a class="wpeo-button button-erase-signature button-grey button-uppercase">
	<i class="fas fa-eraser"></i>
	<span>Effacer</span>
</a>

<canvas></canvas>

