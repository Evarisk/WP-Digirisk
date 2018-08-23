<?php
/**
 * Edition d'une causerie
 *
 * @author    Evarisk <dev@evarisk.com>
 * @since     6.6.0
 * @version   6.6.1
 * @copyright 2018 Evarisk.
 * @package   DigiRisk
 */

namespace digi;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
} ?>

<tr class="causerie-row edit" data-id="<?php echo esc_attr( $causerie->data['id'] ); ?>">

	<!-- Les champs obligatoires pour le formulaire -->
	<input type="hidden" name="action" value="edit_causerie" />
	<?php wp_nonce_field( 'edit_causerie' ); ?>
	<input type="hidden" name="id" value="<?php echo esc_attr( $causerie->data['id'] ); ?>" />

	<td data-title="Ref." class="padding">
		<span>
			<strong><?php echo esc_html( $causerie->data['unique_identifier'] ); ?></strong>
		</span>
	</td>
	<td>
		<?php echo do_shortcode( '[wpeo_upload id="' . $causerie->data['id'] . '" model_name="/digi/Causerie_Class" single="false" field_name="image" ]' ); ?>
	</td>
	<td>
		<?php do_shortcode( '[digi_dropdown_categories_risk id="' . $causerie->data['id'] . '" type="causerie" display="' . ( ( 0 !== $causerie->data['id'] ) ? 'view' : 'edit' ) . '" category_risk_id="' . ( isset( $causerie->data['risk_category'] ) ? $causerie->data['risk_category']->data['id'] : 0 ) . '" preset="0"]' ); ?>
	</td>
	<td class="wpeo-grid grid-1">
		<div>
			<input type="text" name="title" value="<?php echo esc_attr( $causerie->data['title'] ); ?>" />
		</div>
		<div>
			<textarea rows="2" name="description"><?php echo esc_html( $causerie->data['content'] ); ?></textarea>
		</div>
	</td>
	<td data-title="action">
		<?php if ( 0 !== $causerie->data['id'] ) : ?>
			<div class="action grid-layout w3">
				<div data-parent="causerie-row" data-loader="table" class="button w50 green save action-input"><i class="icon fa fa-floppy-o"></i></div>
			</div>
		<?php else : ?>
			<div class="action grid-layout w3">
				<div data-namespace="digirisk"
					data-module="causerie"
					data-before-method="beforeSaveCauserie"
					data-loader="table"
					data-parent="causerie-row"
					class="button disable w50 blue add action-input progress"><i class="icon fa fa-plus"></i></div>
			</div>
		<?php endif; ?>
	</td>
</tr>
