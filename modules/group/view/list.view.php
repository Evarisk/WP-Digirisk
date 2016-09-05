<?php if ( !defined( 'ABSPATH' ) ) exit;

if ( !empty( $list_groupment ) ):
	foreach( $list_groupment as $key => $groupment ):
		?>
		<ul class="<?php echo isset( $key ) ? 'sub-menu': 'parent'; ?>">
			<li data-id="<?php echo $groupment->id; ?>" class="<?php echo $groupment->id === $selected_group->id ? 'active' : ''; ?>">
				<div>
					<span data-id="<?php echo $groupment->id; ?>" class="wp-digi-global-name"><?php echo $groupment->unique_identifier . ' - ' . $groupment->title; ?></span>
					<span class="wp-digi-new-group-action">
						<a data-id="<?php echo $groupment->id; ?>" href="#" class="wp-digi-action dashicons dashicons-plus"></a>
					</span>
				</div>

				<?php
				if ( !empty( $groupment->list_group ) ) {
					$list_groupment = $groupment->list_group;
					require ( GROUP_VIEW_DIR . '/list.view.php' );
				}
				?>

			</li>
		</ul>
		<?php
	endforeach;
endif;
