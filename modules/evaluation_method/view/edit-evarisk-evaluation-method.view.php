<?php
/**
 * Affiches le toggle pour sélectionner une cotation avec la méthode simple de digirisk
 * Ajoutes également un bouton qui permet d'évaluer avec la méthode complexe de digirisk
 *
 * @author Evarisk <dev@evarisk.com>
 * @since 6.0.0
 * @version 6.5.0
 * @copyright 2015-2018 Evarisk
 * @package DigiRisk
 */

namespace digi;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
} ?>

<input type="hidden" class="digi-method-simple" value="<?php echo esc_attr( $term_evarisk_simple->term_id ); ?>" />
<input type="hidden" class="input-hidden-method-id" name="evaluation_method_id" value="<?php echo esc_attr( $digi_method_id ); ?>" />
<input type="hidden" class="risk-level" name="scale" value="<?php echo esc_attr( $risk->evaluation->scale ); ?>" />
<input type="hidden" name="equivalence" value="<?php echo esc_attr( $risk->evaluation->equivalence ); ?>" />

<div class="cotation-container toggle grid">
	<div class="action cotation default-cotation level<?php echo esc_attr( $risk->evaluation->scale ); ?> open-popup" data-parent="risk-row" data-class="popup-evaluation" data-target="popup-evaluation">
		<i class="icon fas fa-chart-line" style="<?php echo ( 0 !== $risk->evaluation->id ) ? 'display: none;' : ''; ?>"></i>
		<span>
			<?php
			if ( 0 !== $risk->evaluation->id ) :
				echo esc_html( $risk->evaluation->equivalence );
			endif;
			?>
		</span>
	</div>
</div>
