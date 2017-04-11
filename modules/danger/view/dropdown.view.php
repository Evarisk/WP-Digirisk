<?php
/**
 * La liste des danger
 *
 * @author Jimmy Latour <jimmy@evarisk.com>
 * @since 6.2.1.0
 * @version 6.2.9.0
 * @copyright 2015-2017 Evarisk
 * @package danger
 * @subpackage view
 */

namespace digi;

if ( ! defined( 'ABSPATH' ) ) { exit; } ?>

<input class="input-hidden-danger" type="hidden" name="risk[danger_id]" value='<?php echo ! empty( $preset ) ? esc_attr( $selected_danger->id ) : '-1'; ?>' />

<div class="danger categorie-container toggle grid padding tooltip red"
			data-parent="categorie-container"
			data-target="content"
			data-nonce="<?php echo esc_attr( wp_create_nonce( 'check_predefined_danger' ) ); ?>"
			aria-label="<?php esc_html_e( 'Vous devez choisir un danger.', 'digirisk' ); ?>">

	<div class="action">
		<span class="<?php echo ! empty( $preset ) && ! empty( $selected_danger ) ? 'hidden' : ''; ?>"><?php esc_html_e( 'Choisir un danger', 'digirisk' ); ?></span>
		<img class="<?php echo ! empty( $preset ) ? '' : 'hidden'; ?> tooltip hover" src="<?php echo ! empty( $selected_danger ) ? esc_attr( wp_get_attachment_url( $selected_danger->thumbnail_id ) ) : ''; ?>" aria-label="" />
		<i class="icon animated fa fa-angle-down"></i>
	</div>

	<ul class="content">
		<?php foreach ( $danger_category_list as $danger_category ) : ?>
			<?php if ( ! empty( $danger_category->danger ) ) : ?>
				<?php foreach ( $danger_category->danger as $danger ) : ?>
					<?php if ( 0 !== $danger->thumbnail_id ) : ?>
						<li class="item tooltip hover" aria-label="<?php echo esc_attr( $danger->name ); ?>" data-id="<?php echo esc_attr( $danger->id ); ?>">
							<?php echo wp_get_attachment_image( $danger->thumbnail_id, 'thumbnail', false ); ?>
						</li>
					<?php endif; ?>
				<?php endforeach; ?>
			<?php endif; ?>
		<?php endforeach; ?>
	</ul>
</div>
