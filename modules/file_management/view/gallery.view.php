<?php
/**
 * La gallerie d'image avec bouton de navigation
 * Avec deux bouton :
 * Set as default thumbnail : Pour mettre l'image par défaut
 * Add a new picture : Permet d'ajouter une nouvelle image à la gallerie
 *
 * @author Jimmy Latour <jimmy@evarisk.com>
 * @since 0.1
 * @version 6.2.5.0
 * @copyright 2015-2017 Evarisk
 * @package file_management
 * @subpackage view
 */

namespace digi;


if ( ! defined( 'ABSPATH' ) ) { exit; } ?>

<div data-id="<?php echo esc_attr( $element_id ); ?>" class="gallery">

	<a href="#" class="close"><i class="dashicons dashicons-no-alt"></i></a>

	<ul class="image-list">

		<li data-id="<?php echo esc_attr( $thumbnail_id ); ?>" class="current"><?php echo wp_get_attachment_image( $thumbnail_id, 'full' ); ?></li>
		<?php if ( ! empty( $list_id ) ) : ?>
				<?php foreach ( $list_id as $key => $id ) : ?>
					<?php if ( $thumbnail_id !== $id ) : ?>
						<li data-id="<?php echo esc_attr( $id ); ?>" class="hidden"><?php echo wp_get_attachment_image( $id, 'full' ); ?></li>
					<?php endif; ?>
			<?php endforeach; ?>
	</ul>
	<?php endif; ?>

	<ul class="navigation">
		<li><a href="#" class="prev"><i class="dashicons dashicons-arrow-left-alt2"></i></a></li>
		<li><a href="#" class="next"><i class="dashicons dashicons-arrow-right-alt2"></i></a></li>
	</ul>

	<ul class="action">
		<li><a href="#"
						data-action="eo_set_thumbnail"
						data-element-id="<?php echo esc_attr( $element_id ); ?>"
						data-thumbnail-id="<?php echo esc_attr( $thumbnail_id ); ?>"
			 			class="edit-thumbnail-id action-attribute"><?php _e( 'Set as default thumbnail', 'digirisk' ); ?></a></li>
		<li>
			<a 	href="#"
					data-nonce="<?php echo esc_attr( wp_create_nonce( 'associate_file' ) ); ?>"
					data-action="<?php echo esc_attr( $action ); ?>"
					data-id="<?php echo esc_attr( $element_id ); ?>"
					data-object-name="<?php echo $param['object_name']; ?>"
					data-namespace="<?php echo $param['namespace']; ?>"
					class="media" ><i></i><?php _e( 'Add a new picture', 'digirisk' ); ?></a>
		</li>
		<li><a href="#"
						data-nonce="<?php echo esc_attr( wp_create_nonce( 'dessociate_file' ) ); ?>"
						data-action="dessociate_file"
						data-thumbnail-id="<?php echo esc_attr( $thumbnail_id ); ?>"
						data-element-id="<?php echo esc_attr( $element_id ); ?>"
						data-object-name="<?php echo esc_attr( $param['object_name'] ); ?>"
						data-namespace="<?php echo $param['namespace']; ?>"
						class="edit-thumbnail-id action-attribute" ><i></i><?php esc_html_e( 'Supprimer', 'digirisk' ); ?></a></li>
	</ul>

</div>
