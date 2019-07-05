<?php
namespace digi;
?>

<div class="move-to move-to-risk">
	<?php
	if( isset( $task->parent_id ) ):
		$risk = Risk_Class::g()->get( array(
			'id' => $task->parent_id,
		), true );
	endif;

	if( ! empty( $risk ) ):
	?>
	<p>Cette tâche est associé au risque <strong><?php echo esc_attr( $risk->unique_identifier ); ?></strong></p>
	<div>
		<input type="hidden" name="task_id" value="<?php echo esc_attr( $task->id ); ?>" />
		<input type="hidden" name="action" value="move_task_to" />
		<?php wp_nonce_field( 'move_task_to' ); ?>

		<label for="move_task"><?php esc_html_e( 'Déplacer la tâche vers le risque...', 'task-manager' ); ?></label>
		<div class="form-fields">
			<input type="text" class="search-parent" />
			<input type="hidden" name="to_element_id" />
			<input type="button" class="action-input" data-loader="move-to-risk" data-parent="move-to-risk" value="<?php esc_html_e( 'OK', 'task-manager' ); ?>" />
		</div>
		<div class="list-posts">
		</div>
	</div>
<?php endif; ?>
</div>
