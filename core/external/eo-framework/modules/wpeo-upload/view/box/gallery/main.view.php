<?php
/**
 * The gallery
 *
 * @author Eoxia <dev@eoxia.com>
 * @since 0.1.0-alpha
 * @version 1.0.0
 * @copyright 2017-2018 Eoxia
 * @package EO_Framework\EO_Upload\Gallery\View
 */

namespace eoxia;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
} ?>

<div class="wpeo-modal modal-active wpeo-gallery" data-nonce="<?php echo esc_attr( wp_create_nonce( 'load_gallery' ) ); ?>">
	<input type="hidden" class="main-thumbnail-id" value="<?php echo esc_attr( $main_picture_id ); ?>" />
	<div class="modal-container">

		<!-- Entête -->
		<div class="modal-header">
			<h2 class="modal-title">
				<?php
				echo wp_kses( $data['title'], array(
					'span' => array(),
					'i' => array(
						'class' => array(),
					),
					'div' => array(
						'class' => array(),
						'data-id' => array(),
						'data-title' => array(),
						'data-mode' => array(),
						'data-field-name' => array(),
						'data-model-name' => array(),
						'data-custom-class' => array(),
						'data-size' => array(),
						'data-single' => array(),
						'data-mime-type' => array(),
						'data-display-type' => array(),
						'data-nonce' => array(),
					),
				) );
				?>
			</h2>
			<div class="modal-close"><i class="fas fa-times"></i></div>
		</div>

		<!-- Corps -->
		<div class="modal-content">
			<?php require( \eoxia\Config_Util::$init['eo-framework']->wpeo_upload->path . '/view/box/gallery/list.view.php' ); ?>
			<?php require( \eoxia\Config_Util::$init['eo-framework']->wpeo_upload->path . '/view/box/gallery/navigation-arrow.view.php' ); ?>

			<?php if ( 'edit' === $data['mode'] ) :
				require( \eoxia\Config_Util::$init['eo-framework']->wpeo_upload->path . '/view/box/gallery/actions.view.php' );
			endif;
			?>
		</div>

		<!-- Footer -->
		<div class="modal-footer">
			<a class="wpeo-button button-main button-uppercase"><span><?php esc_html_e( 'Close', 'wpeo-upload' ); ?></span></a>
		</div>
	</div>
</div>
