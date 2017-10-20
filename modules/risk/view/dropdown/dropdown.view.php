<?php
/**
 * La liste des catégories de danger.
 *
 * @author Jimmy Latour <jimmy@evarisk.com>
 * @since 6.0.0
 * @version 6.4.0
 * @copyright 2015-2017 Evarisk
 * @package DigiRisk
 */

namespace digi;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
} ?>

<input class="input-hidden-danger" type="hidden" name="risk[danger_id]" value='<?php echo ! empty( $preset ) ? esc_attr( $selected_risk_category->id ) : '-1'; ?>' />

<div class="danger categorie-container toggle grid padding tooltip red"
			data-parent="categorie-container"
			data-target="content"
			data-nonce="<?php echo esc_attr( wp_create_nonce( 'check_predefined_danger' ) ); ?>"
			aria-label="<?php esc_html_e( 'Vous devez choisir une catégorie de risque.', 'digirisk' ); ?>">

	<div class="action">
		<span class="<?php echo ! empty( $preset ) && ! empty( $selected_risk_category ) ? 'hidden' : ''; ?>"><?php esc_html_e( 'Risque', 'digirisk' ); ?></span>
		<img class="<?php echo ! empty( $preset ) ? '' : 'hidden'; ?> tooltip hover" src="<?php echo ! empty( $selected_risk_category ) ? esc_attr( wp_get_attachment_url( $selected_risk_category->thumbnail_id ) ) : ''; ?>" aria-label="" />
		<i class="icon animated fa fa-angle-down"></i>
	</div>

	<ul class="content">
		<?php foreach ( $risks_categories as $risk_category ) : ?>
			<li class="item tooltip hover" aria-label="<?php echo esc_attr( $risk_category->name ); ?>" data-id="<?php echo esc_attr( $risk_category->id ); ?>">
				<?php echo wp_get_attachment_image( $risk_category->thumbnail_id, 'thumbnail', false ); ?>
			</li>
		<?php endforeach; ?>
	</ul>
</div>
