<?php namespace digi;

if ( !defined( 'ABSPATH' ) ) exit;

?><div class="doc-content"><?php

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

	<!-- Pagination -->
	<?php if ( !empty( $current_page ) && !empty( $number_page ) ): ?>
		<div class="wp-digi-pagination wp-digi-doc-pagination">
			<?php
			$big = 999999999;
			echo paginate_links( array(
				'base' => admin_url( 'admin-ajax.php?action=paginate_doc&current_page=%_%&element_id=' . $element_id ),
				'format' => '%#%',
				'current' => $current_page,
				'total' => $number_page,
				'before_page_number' => '<span class="screen-reader-text">'. __( 'Page', 'digirisk' ) .' </span>',
				'type' => 'plain',
				'next_text' => '<i class="dashicons dashicons-arrow-right"></i>',
				'prev_text' => '<i class="dashicons dashicons-arrow-left"></i>'
			) );
			?>
		</div>
	<?php endif; ?>

</div>
