<?php namespace digi;
/**
* Affiches le toggle pour sélectionner une cotation avec la méthode simple de digirisk
* Ajoutes également un bouton qui permet d'évaluer avec la méthode complexe de digirisk
*
* @author Jimmy Latour <jimmy@evarisk.com>
* @version 0.1
* @copyright 2015-2016 Eoxia
* @package method_evaluation
* @subpackage view
*/

if ( !defined( 'ABSPATH' ) ) exit; ?>

<input type="hidden" class="digi-method-simple" value="<?php echo $term_evarisk_simple->term_id; ?>" />
<input type="hidden" class="input-hidden-method-id" name="risk[taxonomy][digi-method][]" value="<?php echo $digi_method_id; ?>" />
<input type="hidden" class="risk-level" name="risk[evaluation][scale]" value="<?php echo $risk->evaluation->scale; ?>" />

<div class="cotation-container toggle grid" data-parent="toggle" data-target="content">
	<div class="action cotation default-cotation level<?php echo esc_attr( $risk->evaluation->scale ); ?>">
		<i class="icon fa fa-line-chart" style="<?php echo ( 0 !== $risk->evaluation->id ) ? 'display: none;': ''; ?>"></i>
		<span>
			<?php if ( 0 !== $risk->evaluation->id ) :
				echo esc_html( $risk->evaluation->risk_level['equivalence'] );
			endif ?>
		</span>
	</div>
</div>
