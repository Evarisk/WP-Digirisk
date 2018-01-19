<?php
/**
 * The file.
 *
 * @author Eoxia
 * @since 1.2.0
 * @version 1.2.0
 * @copyright 2017
 * @package EO-Upload
 */

namespace eoxia;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
} ?>

<li>
	<input type="hidden" name="<?php echo esc_attr( $field_name ) . '[]'; ?>" value="<?php echo esc_attr( $file_id ); ?>" />
	<a target="_blank" href="<?php echo esc_attr( $fileurl_only ); ?>">
		<i class="fa fa-download" aria-hidden="true"></i>
		<?php echo esc_attr( $filename_only ); ?>
	</a>
</li>
