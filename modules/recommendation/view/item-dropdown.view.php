<?php
/**
 * Affiches la préconisation
 *
 * @author Jimmy Latour <jimmy@evarisk.com>
 * @since 1.0
 * @version 6.2.4.0
 * @copyright 2015-2017 Evarisk
 * @package recommendation
 * @subpackage view
 */

namespace digi;

if ( ! defined( 'ABSPATH' ) ) { exit; } ?>

<div class="categorie-container toggle grid padding">
	<div class="action">
		<div class="help" aria-label="<?php echo esc_attr( $recommendation->recommendation_category_term[0]->recommendation_term[0]->name ); ?>">
			<?php echo wp_get_attachment_image( $recommendation->recommendation_category_term[0]->recommendation_term[0]->thumbnail_id, 'thumbnail', false ); ?>
		</div>
		<input class="input-hidden-danger" type="hidden" name="taxonomy[digi-recommendation][" value='<?php echo esc_attr( $recommendation->recommendation_category_term[0]->recommendation_term[0]->id ); ?>' />
	</div>
</div>
