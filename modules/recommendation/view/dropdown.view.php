<?php
/**
 * La liste des recommendations
 *
 * @author Evarisk <dev@evarisk.com>
 * @since 6.2.1
 * @version 6.5.0
 * @copyright 2015-2018 Evarisk
 * @package DigiRisk
 */

namespace digi;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
} ?>

<input class="input-hidden-recommendation" type="hidden" name="taxonomy[digi-recommendation][]" value='-1' />

<div 	class="recommendation categorie-container toggle grid padding tooltip red"
			aria-label="<?php esc_html_e( 'Vous devez choisir une signalisation.', 'digirisk' ); ?>"
			data-parent="categorie-container"
			data-target="content">

	<div class="action">
		<span><?php esc_html_e( 'Choisir une signalisation', 'digirisk' ); ?></span>
		<img class="hidden" src="" title="<?php echo esc_attr( 'Choisir une signalisation', 'digirisk' ); ?>" />
		<i class="icon animated far fa-angle-down"></i>
	</div>

	<ul class="content">
		<?php foreach ( $recommendation_category_list as $recommendation_category ) : ?>
				<?php if ( ! empty( $recommendation_category->recommendation_term ) ) : ?>
					<?php foreach ( $recommendation_category->recommendation_term as $recommendation ) : ?>
						<li class="item tooltip hover" aria-label="<?php echo esc_attr( $recommendation->name ); ?>" data-id="<?php echo esc_attr( $recommendation->id ); ?>">
							<?php echo wp_get_attachment_image( $recommendation->thumbnail_id, 'thumbnail', false ); ?>
						</li>
					<?php endforeach; ?>
				<?php endif; ?>
		<?php endforeach; ?>
	</ul>
</div>
