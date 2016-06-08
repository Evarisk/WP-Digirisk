<?php if ( !defined( 'ABSPATH' ) ) exit;

if ( $risk_definition != null ):
?>
	<form method="post" action="<?php echo admin_url( 'admin-ajax.php' ); ?>" class="wp-digi-table-item-edit wp-digi-list-item wp-digi-risk-item" data-risk-id="<?php echo $risk_id; ?>">
		<?php wp_nonce_field( 'ajax_edit_risk_' . $risk_id ); ?>
		<input type="hidden" name="action" value="wpdigi-edit-risk" />
		<input type="hidden" name="digi_method" value="<?php echo $risk_definition->taxonomy['digi-method'][0]; ?>" />
		<input type="hidden" class="digi-method-simple" value="<?php echo $term_evarisk_simple->term_id; ?>" />
		<input type="hidden" name="risk_id" value="<?php echo $risk_id; ?>" />
		<input type="hidden" name="global" value="<?php echo str_replace( 'mdl_01', 'ctr',get_class( $element ) ); ?>" />

		<span class="wp-digi-element-thumbnail wp-digi-risk-thumbnail wpeo-upload-media" data-type="digi-risk" data-id="<?php echo $risk_id; ?>" >
			<?php if ( has_post_thumbnail( $risk_id ) ) : ?>
				<?php echo get_the_post_thumbnail( $risk_id, 'digirisk-element-miniature' ); ?>
				<?php echo do_shortcode( "[wpeo_gallery element_id='" . $risk_id . "' global='wpdigi_risk_ctr' ]" ); ?>
			<?php else: ?>
				<i class="wp-digi-element-thumbnail wp-digi-risk-thumbnail dashicons dashicons-format-image" data-type="digi-risk" data-id="<?php echo $risk_id; ?>" ></i>
			<?php endif; ?>
		</span>

		<input type="hidden" class="risk-level" name="risk_evaluation_level" value="<?php echo $risk_definition->evaluation->option['risk_level']['scale']; ?>" />
		<span data-target="wp-digi-risk-cotation-chooser" data-risk_level="<?php echo $risk_definition->evaluation->option['risk_level']['scale']; ?>" class="<?php echo $risk_definition->taxonomy['digi-method'][0] == $term_evarisk_simple->term_id ? 'digi-toggle' : 'open-method-evaluation-render'; ?> wp-digi-risk-list-column-cotation wp-digi-cotation wp-digi-risk-level-<?php echo $risk_definition->evaluation->option['risk_level']['scale']; ?>" >
			<div class="wp-digi-risk-level-<?php echo $risk_definition->evaluation->option['risk_level']['scale']; ?> wp-digi-risk-list-column-danger" ><?php echo $risk_definition->evaluation->option['risk_level']['equivalence']; ?></div>
			<?php if ( $risk_definition->taxonomy['digi-method'][0] == $term_evarisk_simple->term_id ): ?>
				<ul class="digi-popup wp-digi-risk-cotation-chooser" style="display: none;" >
					<li data-risk_level="1" data-value="1" data-risk-text="1" class="wp-digi-risk-level-1" >&nbsp;</li>
					<li data-risk_level="2" data-value="48" data-risk-text="48" class="wp-digi-risk-level-2" >&nbsp;</li>
					<li data-risk_level="3" data-value="51" data-risk-text="51" class="wp-digi-risk-level-3" >&nbsp;</li>
					<li data-risk_level="4" data-value="80" data-risk-text="80" class="wp-digi-risk-level-4" >&nbsp;</li>
				</ul>
			<?php endif; ?>
		</span>

		<span class="wp-digi-risk-list-column-reference" ><?php echo $risk_definition->option[ 'unique_identifier' ]; ?> - <?php echo $risk_definition->evaluation->option[ 'unique_identifier' ]?></span>
		<span class="wp-digi-risk-list-column-danger"><?php echo $risk_definition->danger->name; ?></span>
		<span class="wp-digi-risk-comment" >
			<ul>
				<?php if ( !empty( $risk_definition->comment ) ) : ?>
					<?php foreach ( $risk_definition->comment as $comment ) : ?>
						<?php if ( $comment->status == '-34070' ): ?>
							<li>
								<input type="text" class="wpdigi_date" name="list_comment[<?php echo $comment->id; ?>][comment_date]" value="<?php echo date( 'd/m/Y', strtotime( $comment->date ) ); ?>" /> : <input type="text" class="wpdigi_comment" name="list_comment[<?php echo $comment->id; ?>][comment_content]" value="<?php echo $comment->content; ?>" />
								<a href="#" data-id="<?php echo $comment->id; ?>" data-risk-id="<?php echo $risk_id; ?>" data-nonce="<?php echo wp_create_nonce( 'ajax_delete_risk_comment_' . $risk_id . '_' . $comment->id ); ?>" class="wp-digi-action wp-digi-action-comment-delete dashicons dashicons-no-alt" ></a>
							</li>
						<?php endif; ?>
					<?php endforeach; ?>
				<?php endif;?>
				<!-- Ajouter un commentaire -->
				<li><input type="text" class="wpdigi_date" name="comment_date" value="<?php echo date( 'd/m/Y' ); ?>" /> : <input type="text" class="wpdigi_comment" name="comment_content" value="" /></li>
			</ul>
		</span>
		<span class="wp-digi-action">
			<a href="#" data-id="<?php echo $risk_id; ?>" class="wp-digi-action wp-digi-action-edit dashicons dashicons-edit" ></a>
		</span>

		<div class="wpdigi-method-evaluation-render"></div>

	</form>
<?php endif ; ?>
