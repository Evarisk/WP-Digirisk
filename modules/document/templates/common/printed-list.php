<?php if ( !defined( 'ABSPATH' ) ) exit; ?>
<?php if ( !empty( $list_document_id )  ) : rsort( $list_document_id ); ?>
<ul class="wp-digi-list wp-digi-table wp-digi-list-document" >
<?php foreach ( $list_document_id as $document_id ) : ?>
<?php if ( has_term( 'printed', 'attachment_category', $document_id ) ) : ?>
<?php 
	$document = $this->show( $document_id );
	$document->option['document_meta'] = json_decode( $document->option['document_meta' ] );
	$document_full_path = null;


	if ( is_file( $this->get_document_path( 'basedir' ) . '/' . $element->type . '/' . $element->id . '/' . $document->title . '_merged.zip' )  && !empty( $document->option['document_meta']->zip ) ) {
		$document_full_path = $this->get_document_path( 'baseurl' ) . '/' . $element->type . '/' . $element->id . '/' . $document->title . '_merged.zip';
	}
	else if ( is_file( $this->get_document_path( 'basedir' ) . '/' . $element->type . '/' . $element->id . '/' . $document->title . '.odt' ) ) {
		$document_full_path = $this->get_document_path( 'baseurl' ) . '/' . $element->type . '/' . $element->id . '/' . $document->title . '.odt';
	}


	require( wpdigi_utils::get_template_part( WPDIGI_DOC_DIR, WPDIGI_DOC_TEMPLATES_MAIN_DIR, 'common', 'printed-list', 'item' ) );
?>
<?php endif; ?>
<?php endforeach; ?>
</ul>
<?php else: ?>
	<?php _e( 'There is no document yet', 'wpdigi-i18n' ); ?>
<?php endif; ?>
