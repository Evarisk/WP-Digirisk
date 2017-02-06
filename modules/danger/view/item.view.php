<?php
/**
 * Affiches le danger d'un risque
 *
 * @author Jimmy Latour <jimmy@evarisk.com>
 * @since 1.0
 * @version 6.2.4.0
 * @copyright 2015-2017 Evarisk
 * @package danger
 * @subpackage view
 */

namespace digi;

if ( ! defined( 'ABSPATH' ) ) { exit; } ?>

<div class="categorie-container toggle grid padding">
	<div class="action">
		<div class="tooltip hover" aria-label="<?php echo esc_attr( $risk->danger->name ); ?>">
			<?php echo wp_get_attachment_image( $risk->danger->thumbnail_id, 'thumbnail', false ); ?>
		</div>
		<input class="input-hidden-danger" type="hidden" name="risk[danger_id]" value='<?php echo esc_attr( $risk->danger->id ); ?>' />
	</div>
</div>
