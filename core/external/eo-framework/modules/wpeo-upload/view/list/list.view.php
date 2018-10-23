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
	if ( ! empty( $element->associated_document_id[ $atts['field_name'] ] ) ) :
		foreach ( $element->associated_document_id[ $atts['field_name'] ] as $file_id ) :
			$filelink = get_attached_file( $file_id );
			$filename_only = basename( $filelink );
			$fileurl_only = wp_get_attachment_url( $file_id );

			require( \eoxia\Config_Util::$init['eo-framework']->wpeo_upload->path . '/view/' . $atts['display_type'] . '/list-item.view.php' );
		endforeach;
	else :
		if ( 0 != $atts['id'] ) :
			?>
			<li><?php echo esc_html_e( 'No file attached', 'wpeo-upload' ); ?></li>
			<?php
		endif;
	endif;
	?>
</ul>
