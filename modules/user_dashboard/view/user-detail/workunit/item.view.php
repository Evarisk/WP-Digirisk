<?php if ( !defined( 'ABSPATH' ) ) exit; ?>

<li class="wp-digi-list-item">
	<span>
		<?php
		if ( !empty( $element ) && !empty( $element->thumbnail_id ) ):
		   echo wp_get_attachment_image( $element->thumbnail_id, 'element-miniature', false, array( 'class' => 'wp-post-image wp-digi-element-thumbnail', )  );
	  else:
	    ?>
			<img src="#" class="hidden wp-post-image wp-digi-element-thumbnail" />
			<?php
	  endif;
		?>
	</span>
	<span><?php echo $element->unique_identifier; ?></span>
	<span><?php echo $element->title; ?></span>
	<span>GP</span>
	<span>22/09/2016</span>
</li>
