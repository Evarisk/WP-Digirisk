<?php if ( !defined( 'ABSPATH' ) ) exit; ?>

<li class="wp-digi-list-item">
	<span>
		<?php
		if ( !empty( $element ) && !empty( $element['self']->thumbnail_id ) ):
		   echo wp_get_attachment_image( $element['self']->thumbnail_id, 'element-miniature', false, array( 'class' => 'wp-post-image wp-digi-element-thumbnail', )  );
	  else:
	    ?>
			<img src="#" class="hidden wp-post-image wp-digi-element-thumbnail" />
			<?php
	  endif;
		?>
	</span>
	<span><?php echo $element['self']->unique_identifier; ?></span>
	<span><?php echo $element['self']->title; ?></span>
	<span><?php echo $element['groupment']->unique_identifier . ' ' . $element['groupment']->title; ?></span>
	<span><?php echo $element['affectation_date_info']['start']['date']; ?></span>
</li>
