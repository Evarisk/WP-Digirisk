<?php
/**
 * Contenu de la modal
 *
 * @author Evarisk <dev@evarisk.com>
 * @since 6.6.0
 * @version 6.6.0
 * @copyright 2015-2018 Evarisk
 * @package DigiRisk
 */

namespace digi;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
} ?>

<input type="hidden" name="signature_of_the_caregiver" />
<input type="hidden" class="url" value="<?php echo ! empty( $accident->associated_document_id['signature_of_the_caregiver_id'][0] ) ? esc_attr( wp_get_attachment_url( $accident->associated_document_id['signature_of_the_caregiver_id'][0] ) ) : ''; ?>" />
<canvas></canvas>
