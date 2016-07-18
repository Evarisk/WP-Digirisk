<?php if ( !defined( 'ABSPATH' ) ) exit; ?>

<ul class="wp-digi-list wp-digi-table wp-digi-list-document">
	<?php
	if ( !empty( $list_document ) ):
	  foreach ( $list_document as $element ):
			require( wpdigi_utils::get_template_part( WPDIGI_DOC_DIR, WPDIGI_DOC_TEMPLATES_MAIN_DIR, 'common', 'printed-list', 'item' ) );
	  endforeach;
	endif;
	?>
</ul>
