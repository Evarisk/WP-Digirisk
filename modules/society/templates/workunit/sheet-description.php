<?php if ( !defined( 'ABSPATH' ) ) exit; ?>
	<ul class="wp-digi-workunit-sheet-main-information wp-digi-clearer" >
		<li class="wp-digi-workunit-sheet-galerypics" >
			<?php echo do_shortcode( '[wpeofiles element-type="' . $this->get_post_type() . '" element-id="' . $this->current_workunit->id . '" file_list_association="' . ( !empty( $this->current_workunit->option ) && !empty( $this->current_workunit->option[ 'associated_document_id' ] ) && !empty( $this->current_workunit->option[ 'associated_document_id' ][ 'image' ] ) ? implode( ',', $this->current_workunit->option[ 'associated_document_id' ][ 'image' ] ) : null ) . '" picture_size="digirisk-element-miniature" output_type="mini-gallery" limit="5" thumbnail_id="' . $this->current_workunit->thumbnail_id . '" thumbnail_size="digirisk-element-thumbnail" ]' ); ?>
		</li>
		<li class="wp-digi-workunit-sheet-description" ><textarea class="wp-digi-input-editable" name="wp-digi-workunit-content" ><?php echo $this->current_workunit->content; ?></textarea></li>
		<li class="wp-digi-workunit-sheet-stats" >
			<ul>
				<li><label class="wp-digi-stat-label" ><?php _e( 'Risk number', 'digirisk' ); ?></label> : <?php echo count( $this->current_workunit->option[ 'associated_risk' ] ); ?></li>
				<li><label class="wp-digi-stat-label" ><?php _e( 'Affected users', 'digirisk' ); ?></label> : <?php echo !empty( $this->current_workunit->option[ 'user_info' ][ 'affected_id' ][ 'user' ] ) ? count( $this->current_workunit->option[ 'user_info' ][ 'affected_id' ][ 'user' ] ) : 0; ?></li>
				<li><label class="wp-digi-stat-label" ><?php _e( 'Affected evaluators', 'digirisk' ); ?></label> : <?php echo !empty( $this->current_workunit->option[ 'user_info' ][ 'affected_id' ][ 'evaluator' ] ) ? count( $this->current_workunit->option[ 'user_info' ][ 'affected_id' ][ 'evaluator' ] ) : 0; ?></li>
			</ul>
		</li>
	</ul>
