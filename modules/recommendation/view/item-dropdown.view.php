<?php
/**
 * Affiches la préconisation
 *
 * @author Evarisk <dev@evarisk.com>
 * @since 6.0.0
 * @version 6.5.0
 * @copyright 2015-2018 Evarisk
 * @package DigiRisk
 */

namespace digi;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
} ?>

<div class="categorie-container toggle grid padding">
	<div class="action">
		<div class="help" aria-label="<?php echo esc_attr( $recommendation->recommendation_category_term->recommendation_term->name ); ?>">
			<?php echo wp_get_attachment_image( $recommendation->recommendation_category_term->recommendation_term->thumbnail_id, 'thumbnail', false ); ?>
		</div>
		<input class="input-hidden-danger" type="hidden" name="recommendation_term_id" value='<?php echo esc_attr( $recommendation->recommendation_category_term->recommendation_term->id ); ?>' />
	</div>
</div>
