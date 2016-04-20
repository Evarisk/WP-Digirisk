<?php if ( !defined( 'ABSPATH' ) ) exit;

if ( $risk != null ):
?>
	<li class="wp-digi-list-item wp-digi-risk-item" data-risk-id="<?php echo $risk->id; ?>" >
		<span data-id='<?php echo $risk->id; ?>' data-type='risk' data-nonce='<?php echo wp_create_nonce( 'ajax_file_association_' . $risk->id ); ?>' class="wp-digi-risk-thumbnail" ><?php
		if ( has_post_thumbnail( $risk->id ) ) :
			echo get_the_post_thumbnail( $risk->id, 'digirisk-element-miniature' );
		else: ?>
			<i class="wp-digi-element-thumbnail dashicons dashicons-format-image" ></i>
		<?php endif; ?></span>
		<span class="wp-digi-risk-list-column-cotation" ><div class="wp-digi-risk-level-<?php echo $risk->evaluation->option[ 'risk_level' ][ 'scale' ]; ?>" ><?php echo $risk->evaluation->option[ 'risk_level' ][ 'equivalence' ]; ?></div></span>
		<span class="wp-digi-risk-list-column-reference" ><?php echo $risk->option[ 'unique_identifier' ]; ?> - <?php echo $risk->evaluation->option[ 'unique_identifier' ]?></span>
		<span class="wp-digi-risk-list-column-danger"><?php echo $risk->danger->name; ?></span>
		<span class="wp-digi-risk-comment" >
			<?php if ( !empty( $risk->comment ) ) : ?>
				<ul>
			<?php foreach ( $risk->comment as $comment ) : ?>
					<?php if ( $comment->status != '-34071' ): ?>
						<li><strong><?php echo date( 'd/m/Y', strtotime( $comment->date ) ); ?></strong> : <?php echo $comment->content; ?></li>
					<?php endif; ?>
			<?php endforeach; ?>

				</ul>
			<?php endif;?>
		</span>
		<span class="wp-digi-action wp-digi-risk-action" >
			<a href="#" data-id="<?php echo $risk->id; ?>" data-global="<?php echo str_replace( 'mdl_01', 'ctr',get_class( $element ) ); ?>" data-nonce="<?php echo wp_create_nonce( 'ajax_load_risk_' . $risk->id ); ?>" class="wp-digi-action wp-digi-action-load dashicons dashicons-edit" ></a>
			<a href="#" data-id="<?php echo $risk->id; ?>" data-global="<?php echo str_replace( 'mdl_01', 'ctr',get_class( $element ) ); ?>" data-nonce="<?php echo wp_create_nonce( 'ajax_delete_risk_' . $risk->id ); ?>" class="wp-digi-action wp-digi-action-delete dashicons dashicons-no-alt" ></a>
		</span>
	</li>
<?php endif ; ?>
