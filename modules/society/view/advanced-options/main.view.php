<?php
/**
 * Ajoutes le champs pour déplacer une societé vers une autre.
 *
 * @author Evarisk <dev@evarisk.com>
 * @since 6.2.5
 * @version 6.3.0
 * @copyright 2015-2017 Evarisk
 * @package DigiRisk
 */

namespace digi;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
} ?>

<div class="form">
	<input type="hidden" name="action" value="advanced_options_move_to" />
	<input type="hidden" name="id" value="<?php echo esc_attr( $selected_society->id ); ?>" />
	<?php wp_nonce_field( 'advanced_options_move_to' ); ?>

	<ul class="wpeo-gridlayout padding grid-2">
		<li class="form-element">
			<select name="parent_id">
				<?php if ( ! empty( $groupments ) ) : ?>
					<?php foreach ( $groupments as $groupment ) : ?>
						<?php
						$selected = '';
						if ( $groupment->id === $selected_society->id ) :
							$selected = "selected='true'";
						endif;
						?>
						<option <?php echo esc_attr( $selected ); ?> value="<?php echo esc_attr( $groupment->id ); ?>"><?php echo esc_html( $groupment->unique_identifier . ' - ' . $groupment->title ); ?></option>
					<?php endforeach; ?>
				<?php endif; ?>
			</select>
		</li>
		<li>
			<button data-parent="form" class="button blue action-input"><?php esc_html_e( 'Déplacer', 'digirisk' ); ?></button>
		</li>
	</ul>
</div>
