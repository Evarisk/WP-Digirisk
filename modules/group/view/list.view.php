<?php namespace digi;

 if ( !defined( 'ABSPATH' ) ) exit;

if ( !empty( $list_groupment ) ):
	foreach( $list_groupment as $key => $groupment ):
		?>
		<ul class="<?php echo !empty( $groupment->parent_id ) ? 'sub-menu': 'parent'; ?>">
			<li data-id="<?php echo $groupment->id; ?>">
				<div class="<?php echo $groupment->id === $selected_group->id ? 'active' : ''; ?>">
					<span data-id="<?php echo $groupment->id; ?>" class="wp-digi-global-name"><?php echo $groupment->unique_identifier . ' - ' . $groupment->title; ?></span>
					<span class="wp-digi-new-group-action">
						<?php if ( empty( $groupment->list_workunit) ): ?>
							<a data-id="<?php echo $groupment->id; ?>" href="#" class="wp-digi-action dashicons dashicons-plus"></a>
						<?php endif; ?>
					</span>
				</div>

				<?php
				if ( !empty( $groupment->list_group ) ) {
					$list_groupment = $groupment->list_group;
					view_util::exec( 'group', 'list', array( 'list_groupment' => $list_groupment, 'selected_group' => $selected_group ) );
				}
				?>

			</li>
		</ul>
		<?php
	endforeach;
endif;
