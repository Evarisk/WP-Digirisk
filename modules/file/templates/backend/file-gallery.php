<?php if ( !defined( 'ABSPATH' ) ) exit; ?>
<?php if ( !empty( $files ) ) : ?>
	<input type="hidden" id="wpeo-files-associated-element-id" value="<?php echo $params[ 'element-id' ]; ?>" />
	<ul class="wpeofile-list-container" >
		<?php foreach ( $files as $file_id ) : ?>
			<?php if ( !empty( $file_id ) ) : ?>
			<?php
				$file_infos = get_post( $file_id );
				if ( wp_attachment_is_image( $file_id ) ) {
					$file_attachment = wp_get_attachment_metadata( $file_id );
				}
				$attached_file = get_post_meta( $file_id, '_wp_attached_file', true );
				$file_path = $upload_dir[ 'baseurl' ] . '/' . $attached_file;
			?>
			<li data-id="<?php echo $file_id; ?>" >
				<i class="dashicons <?php echo $this->get_icon_for_attachment( $file_id ); ?>" ></i>
				<span>#<?php echo $file_id; ?></span>
				<span><?php echo $file_infos->post_title; ?></span>
				<span class="wpeofile-action-button-container" ><a href="<?php echo $file_path; ?>" class="dashicons dashicons-download" title="<?php _e( 'Download the file', 'wpdigi-i18n' ); ?>" download ></a></span>
				<span class="wpeofile-action-button-container" ><a href="#" class="dashicons dashicons-trash" title="<?php _e( 'Delete file', 'wpdigi-i18n' ); ?>" ></a></span>
			</li>
			<?php endif; ?>
		<?php endforeach; ?>
	</ul>
<?php else : ?>
	<div class="wpeomtm-no-result-msg" ><?php _e( 'No files affected', 'wpdigi-i18n' ); ?></div>
<?php endif; ?>
