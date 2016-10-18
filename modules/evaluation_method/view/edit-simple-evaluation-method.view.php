<?php namespace digi;
/**
* Affiches le toggle pour sélectionner une cotation avec la méthode simple de digirisk
* Ajoutes également un bouton qui permet d'évaluer avec la méthode complexe de digirisk
*
* @author Jimmy Latour <jimmy.latour@gmail.com>
* @version 0.1
* @copyright 2015-2016 Eoxia
* @package method_evaluation
* @subpackage view
*/

if ( !defined( 'ABSPATH' ) ) exit; ?>

<input type="hidden" class="digi-method-simple" value="<?php echo $term_evarisk_simple->term_id; ?>" />
<input type="hidden" class="input-hidden-method-id" name="risk[taxonomy][digi-method][]" value="<?php echo $digi_method_id; ?>" />
<input type="hidden" class="risk-level" name="risk[evaluation][scale]" value="<?php echo $risk->evaluation[0]->scale; ?>" />

<toggle data-target="<?php echo $target; ?>" data-parent="wp-digi-risk-item" class="<?php echo $term_evarisk_simple->term_id != $digi_method_id ? 'open-popup': ''; ?> digi-toggle wp-digi-risk-list-column-cotation" >
	<div class="wp-digi-risk-level wp-digi-risk-level-<?php echo $risk->evaluation[0]->scale; ?> wp-digi-risk-level-new"><?php echo $risk->id !== 0 ? $risk->evaluation[0]->risk_level['equivalence'] : '0'; ?></div>
	<ul class="wp-digi-risk-cotation-chooser digi-popup <?php echo ( $risk->id !== 0 ) ? 'simple': ''; ?>" style="display: none;" >
		<li data-level="1" class="level-chooser wp-digi-risk-level-1" >0</li>
		<li data-level="2" class="level-chooser wp-digi-risk-level-2" >48</li>
		<li data-level="3" class="level-chooser wp-digi-risk-level-3" >51</li>
		<li data-level="4" class="level-chooser wp-digi-risk-level-4" >80</li>
		<?php if ( $risk->id === 0 ): ?>
		    <li class="open-method-evaluation-render"><span class="dashicons dashicons-admin-generic open-popup" data-parent="wp-digi-risk-item" data-target="wpdigi-method-evaluation-render"></span></li>
    <?php endif; ?>
	</ul>
</toggle>
