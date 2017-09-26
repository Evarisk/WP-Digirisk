<?php
/**
 * Affiches le champs de texte et le bouton "Plus" pour créer un établissement.
 *
 * @author Jimmy Latour <jimmy@evarisk.com>
 * @since 0.1.0
 * @version 6.3.0
 * @copyright 2015-2017 Evarisk
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
	<input type="hidden" name="class" value="" />
	<input class="unit-label" name="title" placeholder="" type="text" />
	<div class="button w50 add blue action-input" data-parent="new" data-loader="new"><i class="icon dashicons dashicons-plus"></i></<div>
</li>
