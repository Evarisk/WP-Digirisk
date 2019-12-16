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

<a class="wpeo-button button-grey button-uppercase modal-close"><span>Annuler</span></a>

<a class="wpeo-button button-blue button-uppercase action-input"
   data-namespace="digirisk"
   data-module="signature"
   data-before-method="applySignature"
   data-parent="wpeo-modal"
   data-action="digi_save_signature"
   data-nonce="<?php echo esc_attr( wp_create_nonce( 'digi_save_signature' ) ); ?>"><span>Valider</span></a>

