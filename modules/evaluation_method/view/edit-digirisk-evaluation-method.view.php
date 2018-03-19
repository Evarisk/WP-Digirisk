<?php
/**
 * Affiches le toggle pour sélectionner une cotation avec la méthode simple de digirisk
 * Ajoutes également un bouton qui permet d'évaluer avec la méthode complexe de digirisk
 *
 * @author Evarisk <dev@evarisk.com>
 * @since 6.2.1
 * @version 6.5.0
 * @copyright 2015-2018 Evarisk
 * @package DigiRisk
 */

namespace digi;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
} ?>

<input type="hidden" name="evaluation_method_id" value="<?php echo esc_attr( $digi_method_id ); ?>" />
<input type="hidden" name="scale" value="<?php echo esc_attr( $risk->evaluation->scale ); ?>" />
<input type="hidden" name="equivalence" value="<?php echo esc_attr( $risk->evaluation->equivalence ); ?>" />

<div 	class="cotation-container tooltip toggle red grid"
			data-parent="toggle"
			data-target="content"
			aria-label="<?php esc_html_e( 'Vous devez coter votre risque.', 'digirisk' ); ?>">

	<div class="action cotation default-cotation level<?php echo esc_attr( $risk->evaluation->scale ); ?>">
		<i class="icon fas fa-chart-line" style="<?php echo ( 0 !== $risk->evaluation->id ) ? 'display: none;' : ''; ?>"></i>
		<span>
			<?php
			if ( 0 !== $risk->evaluation->id ) :
				echo esc_html( $risk->evaluation->equivalence );
			endif
			?>
		</span>
	</div>

	<ul class="content dropdown-padding-0">
		<li data-level="1" class="item cotation level1"><span>0</span></li>
		<li data-level="2" class="item cotation level2"><span>48</span></li>
		<li data-level="3" class="item cotation level3"><span>51</span></li>
		<li data-level="4" class="item cotation level4"><span>80</span></li>

		<?php if ( 0 === $risk->id || $risk->preset ) : ?>
			<li class="item cotation method open-popup" data-parent="risk-row" data-class="popup-evaluation" data-target="popup-evaluation"><i class="icon fas fa-cog"></i></li>
		<?php endif; ?>
	</ul>
</div>
