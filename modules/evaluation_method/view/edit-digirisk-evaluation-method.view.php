<?php
/**
 * Affiches le toggle pour sélectionner une cotation avec la méthode simple de digirisk
 * Ajoutes également un bouton qui permet d'évaluer avec la méthode complexe de digirisk
 *
 * @author Jimmy Latour <jimmy@evarisk.com>
 * @since 6.2.1.0
 * @version 6.2.4.0
 * @copyright 2015-2017 Evarisk
 * @package method_evaluation
 * @subpackage view
 */

namespace digi;

if ( ! defined( 'ABSPATH' ) ) { exit; } ?>

<input type="hidden" class="digi-method-simple" value="<?php echo esc_attr( $term_evarisk_simple->term_id ); ?>" />
<input type="hidden" class="input-hidden-method-id" name="risk[taxonomy][digi-method][]" value="<?php echo esc_attr( $digi_method_id ); ?>" />
<input type="hidden" class="risk-level" name="risk[evaluation][scale]" value="<?php echo esc_attr( $risk->evaluation->scale ); ?>" />

<div 	class="cotation-container tooltip toggle red grid"
			data-parent="toggle"
			data-target="content"
			aria-label="<?php esc_html_e( 'Vous devez coter votre risque.', 'digirisk' ); ?>">

	<div class="action cotation default-cotation level<?php echo esc_attr( $risk->evaluation->scale ); ?>">
		<i class="icon fa fa-line-chart" style="<?php echo ( 0 !== $risk->evaluation->id ) ? 'display: none;': ''; ?>"></i>
		<span>
			<?php if ( 0 !== $risk->evaluation->id ) :
				echo esc_html( $risk->evaluation->risk_level['equivalence'] );
			endif ?>
		</span>
	</div>

	<ul class="content">
		<li data-level="1" class="item cotation level1"><span>0</span></li>
		<li data-level="2" class="item cotation level2"><span>48</span></li>
		<li data-level="3" class="item cotation level3"><span>51</span></li>
		<li data-level="4" class="item cotation level4"><span>80</span></li>

		<?php if ( 0 === $risk->id || $risk->preset ) : ?>
			<li class="item cotation method open-popup" data-parent="risk-row" data-target="popup-evaluation"><i class="icon fa fa-cog"></i></li>
		<?php endif; ?>
	</ul>
</div>
