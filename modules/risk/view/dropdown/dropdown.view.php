<?php
/**
 * La liste des catégories de danger.
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

<input class="input-hidden-danger" type="hidden" name="risk_category_id" value='<?php echo ! empty( $preset ) ? esc_attr( $selected_risk_category->data['id'] ) : '-1'; ?>' />

<div class="wpeo-dropdown category-danger padding tooltip red"
			data-nonce="<?php echo esc_attr( wp_create_nonce( 'check_predefined_danger' ) ); ?>"
			aria-label="<?php esc_html_e( 'Vous devez choisir une catégorie de risque.', 'digirisk' ); ?>">

	<div class="dropdown-toggle">
		<span class="<?php echo ! empty( $preset ) && ! empty( $selected_risk_category ) ? 'hidden' : ''; ?>"><?php esc_html_e( 'Risque', 'digirisk' ); ?></span>
		<img class="<?php echo ! empty( $preset ) ? '' : 'hidden'; ?> tooltip hover" src="<?php echo ! empty( $selected_risk_category ) ? esc_attr( wp_get_attachment_url( $selected_risk_category->data['thumbnail_id'] ) ) : ''; ?>" aria-label="" />
		<i class="icon animated far fa-angle-down"></i>
	</div>

	<ul class="dropdown-content wpeo-grid grid-4">
		<?php foreach ( $risks_categories as $risk_category ) : ?>
			<li class="item tooltip hover" data-is-preset="<?php echo esc_attr( $risk_category->data['is_preset'] ); ?>" aria-label="<?php echo esc_attr( $risk_category->data['name'] ); ?>" data-id="<?php echo esc_attr( $risk_category->data['id'] ); ?>">
				<?php echo wp_get_attachment_image( $risk_category->data['thumbnail_id'], 'thumbnail', false ); ?>
			</li>
		<?php endforeach; ?>
	</ul>
</div>
