<?php
/**
 * The actions button for the gallery.
 *
 * @author Eoxia <dev@eoxia.com>
 * @since 1.0.0
 * @version 1.0.0
 * @copyright 2017-2018 Eoxia
 * @package EO_Framework\EO_Upload\Gallery\View
 */

namespace eoxia;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
} ?>

<?php
if ( 'edit' === $data['mode'] ) :
	?>
	<div class="wpeo-button button-main upload no-file"
				<?php echo WPEO_Upload_Class::g()->out_all_attributes( $data ); // WPCS: XSS is ok. ?>
				data-nonce="<?php echo esc_attr( wp_create_nonce( 'associate_file' ) ); ?>">
		<i class="button-icon fas fa-image"></i>
		<span><?php esc_html_e( 'Add new media', 'wpeo-upload' ); ?></span>
	</div>
	<?php
endif;
