<?php
/**
 * The list for the gallery
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

<ul class="image-list">
	<li data-id="<?php echo esc_attr( $main_picture_id ); ?>" class="current">
		<?php
		if ( 'image' === $data['mime_type'] ) :
			echo wp_get_attachment_image( $main_picture_id, 'full' );
		else :
			?>
			<div class="document">
				<i class="icon fas fa-paperclip" aria-hidden="true"></i>

				<?php $document_name = get_attached_file( $main_picture_id ); ?>
				<p>
					<span><?php echo esc_html( basename( $document_name ) ); ?></span>
					<?php esc_html_e( 'Preview not available', 'wpeo-upload' ); ?>
				</p>
			</div>
			<?php
		endif;
		?>
	</li>

	<?php if ( ! empty( $list_id ) ) : ?>
		<?php foreach ( $list_id as $key => $id ) : ?>
			<?php if ( $main_picture_id !== $id ) : ?>
				<li data-id="<?php echo esc_attr( $id ); ?>" class="hidden">
					<?php
					if ( 'image' === $data['mime_type'] ) :
						echo wp_get_attachment_image( $id, 'full' );
					else :
						?>
						<div class="document">
							<i class="icon fas fa-paperclip" aria-hidden="true"></i>

							<?php $document_name = get_attached_file( $id ); ?>
							<p>
								<span><?php echo esc_html( basename( $document_name ) ); ?></span>
								<?php esc_html_e( 'Preview not available', 'wpeo-upload' ); ?>
							</p>
						</div>
						<?php
					endif;
					?>
				</li>
			<?php endif; ?>
		<?php endforeach; ?>
	<?php endif; ?>
</ul>
