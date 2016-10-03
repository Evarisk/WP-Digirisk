<?php namespace digi;

if ( !defined( 'ABSPATH' ) ) exit;

if ( !empty( $list_document ) ):
	?>
	<ul class="wp-digi-list wp-digi-table wp-digi-list-document">
	<?php
  foreach ( $list_document as $element ):
		view_util::exec( 'document', 'printed-list-item', array( 'element' => $element ) );
  endforeach;
	?>
	</ul>
	<?php
else:
	_e( 'There is no document yet', 'digirisk' );
endif;
?>
