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
	<?php if ( isset( $risk_category ) && 0 !== $risk_category->data['id'] ) : ?>
		<div class="tooltip hover" aria-label="<?php echo esc_attr( $risk_category->data['name'] ); ?>">
			<?php echo wp_get_attachment_image( $risk_category->data['thumbnail_id'], 'thumbnail', false ); ?>
		</div>
		<input class="input-hidden-danger" type="hidden" name="risk_category_id" value='<?php echo esc_attr( $risk_category->data['id'] ); ?>' />
	<?php else : ?>
		<div class="button grey h50 tooltip hover red" aria-label="<?php echo esc_attr_e( 'Corrompu', 'digirisk' ); ?>" >
			<i class="fa fa-times icon" aria-hidden="true"></i>
		</div>
	<?php endif; ?>
	</div>
</div>
