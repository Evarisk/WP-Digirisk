<?php if ( !defined( 'ABSPATH' ) ) exit;
if ( !empty( $group_list ) ): ?>
	<ul class="<?php echo $class; ?>">
		<?php foreach ( $group_list as $group ) : ?>
			<li data-id="<?php echo $group->id; ?>">
				<div class="<?php echo $default_selected_group_id == $group->id ? 'active' : ''; ?>">
					<span data-id="<?php echo $group->id; ?>" class="wp-digi-global-name"><?php echo $group->option[ 'unique_identifier' ] . ' - ' . $group->title; ?></span>
					<?php
					$list_workunit = workunit_class::get()->index( array( 'post_parent' => $group->id, 'status' => 'publish' ) );
					?>
					<?php if ( count( $list_workunit ) == 0 ): ?>
						<span class="wp-digi-new-group-action">
							<a data-id="<?php echo $group->id; ?>" href="#" class="wp-digi-action dashicons dashicons-plus"></a>
						</span>
					<?php else: ?>
						<span data-id="<?php echo $group->id; ?>"></span>
					<?php endif; ?>
				</div>
				<?php $this->render_list_item( $default_selected_group_id, $group->id, 'sub-menu' ); ?>
			</li>
			<?php
			if ( empty( $default_selected_group_id ) ) :
				$default_selected_group_id = $group->id;
			endif;
			?>
		<?php endforeach; ?>
	</ul>
<?php endif; ?>
