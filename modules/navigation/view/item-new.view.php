<?php
/**
 * Affiches le champs de texte et le bouton "Plus" pour créer un établissement.
 *
 * @author Evarisk <dev@evarisk.com>
 * @since 6.0.0
 * @version 7.0.0
 * @copyright 2015-2018 Evarisk
 * @package DigiRisk
 */

namespace digi;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
} ?>

<li class="unit new">
	<i class="placeholder-icon dashicons dashicons-admin-multisite"></i>
	<input type="hidden" name="action" value="create_society" />
	<?php wp_nonce_field( 'create_society' ); ?>
	<input type="hidden" name="parent_id" value="<?php echo esc_attr( $id ); ?>" />
	<input class="unit-label" name="title" placeholder="" type="text" />
	<input type="hidden" name="class" value="" />
	<div class="wpeo-button button-square-50 add action-input" data-parent="new" data-loader="wpeo-button"><i class="button-icon fas fa-plus"></i></<div>
</li>
