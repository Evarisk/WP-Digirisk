<?php
/**
 * Affiches le toggle pour sélectionner une cotation avec la méthode simple de digirisk
 * Ajoutes également un bouton qui permet d'évaluer avec la méthode complexe de digirisk
 *
 * @author Jimmy Latour <jimmy@evarisk.com>
 * @since 6.2.1.0
 * @version 6.2.3.0
 * @copyright 2015-2017 Evarisk
 * @package method_evaluation
 * @subpackage view
 */

namespace digi;


if ( ! defined( 'ABSPATH' ) ) { exit; } ?>

<input type="hidden" class="digi-method-simple" value="<?php echo esc_attr( $term_evarisk_simple->term_id ); ?>" />
<input type="hidden" class="input-hidden-method-id" name="risk[taxonomy][digi-method][]" value="<?php echo esc_attr( $digi_method_id ); ?>" />
<input type="hidden" class="risk-level" name="risk[evaluation][scale]" value="<?php echo esc_attr( $risk->evaluation->scale ); ?>" />

<div class="cotation-container toggle grid">
	<div class="action cotation default-cotation"><i class="icon fa fa-line-chart"></i></div>
	<ul class="content">
		<li class="item cotation level1"><span>0</span></li>
		<li class="item cotation level2"><span>48</span></li>
		<li class="item cotation level3"><span>51</span></li>
		<li class="item cotation level4"><span>80</span></li>
		<li class="item cotation method"><i class="icon fa fa-cog"></i></li>
	</ul>
</div>
