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
<input type="hidden" class="input-hidden-method-id" name="risk[<?php echo $risk->id; ?>][taxonomy][digi-method][]" value="<?php echo $digi_method_id; ?>" />
<input type="hidden" class="risk-level" name="risk[<?php echo $risk->id; ?>][evaluation][scale]" value="<?php echo $risk->evaluation[0]->scale; ?>" />

<span data-target="wpdigi-method-evaluation-render" data-parent="wp-digi-risk-item" class="open-popup wp-digi-risk-list-column-cotation" >
	<div class="wp-digi-risk-level wp-digi-risk-level-<?php echo $risk->evaluation[0]->scale; ?> wp-digi-risk-level-new"><?php echo $risk->id !== 0 ? $risk->evaluation[0]->risk_level['equivalence'] : '0'; ?></div>
</span>
