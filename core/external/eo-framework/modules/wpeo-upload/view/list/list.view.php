<?php
/**
 * List of media on the post.
 *
 * @author Eoxia <dev@eoxia.com>
 * @since 1.2.0
 * @version 1.2.0
 * @copyright 2017-2018 Eoxia
 * @package EO_Framework\EO_Upload\List\View
 */

namespace eoxia;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

?>
<ul>
	<?php
	if ( ! empty( $element->data['associated_document_id'][ $atts['field_name'] ] ) ) :
		foreach ( $element->data['associated_document_id'][ $atts['field_name'] ] as $file_id ) :
			$filelink = get_attached_file( $file_id );
			$filename_only = basename( $filelink );
			$fileurl_only = wp_get_attachment_url( $file_id );

			$view = apply_filters( 'wpeo_upload_view_list_item', array(
				'view' => \eoxia\Config_Util::$init['eo-framework']->wpeo_upload->path . '/view/' . $atts['display_type'] . '/list-item.view.php',
			) );
			require( $view );
		endforeach;
	else :
		if ( 0 != $atts['id'] ) :
			?>
			<li class="no-file-attached"><?php echo esc_html_e( 'No file attached', 'wpeo-upload' ); ?></li>
			<?php
		endif;
	endif;
	?>
</ul>
