<?php
/**
 * Affiches la catégorie de risque d'un risque
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

<div class="categorie-container toggle grid padding">
	<div class="action">
	<?php if ( isset( $risk_category ) && null !== $risk_category->data['id'] ) : ?>
		<div class="wpeo-tooltip-event hover" aria-label="<?php echo esc_attr( $risk_category->data['name'] ); ?>">
			<?php echo wp_get_attachment_image( $risk_category->data['thumbnail_id'], 'thumbnail', false ); ?>
		</div>
		<input class="input-hidden-danger" type="hidden" name="risk_category_id" value='<?php echo esc_attr( $risk_category->data['id'] ); ?>' />
	<?php else : ?>
		<div class="wpeo-button button-square-40 wpeo-tooltip-event button-disable button-event" data-direction="top" data-color="red" aria-label="<?php echo esc_attr_e( 'Corrompu', 'digirisk' ); ?>" >
			<i class="button-icon fas fa-times" aria-hidden="true"></i>
		</div>
	<?php endif; ?>
	</div>
</div>
