<?php if ( !defined( 'ABSPATH' ) ) exit;

if ( !empty( $group ) ):
	?>
	<ul class="<?php echo isset( $key ) ? 'sub-menu': 'parent'; ?>">
		<li data-id="<?php echo $group->id; ?>">
			<div>
				<span data-id="<?php echo $group->id; ?>" class="wp-digi-global-name"><?php echo $group->unique_identifier . ' - ' . $group->title; ?></span>
				<span class="wp-digi-new-group-action">
					<a data-id="<?php echo $group->id; ?>" href="#" class="wp-digi-action dashicons dashicons-plus"></a>
				</span>
			</div>

			<?php
			if ( !empty( $group->list_group ) ) {
			  foreach ( $group->list_group as $key => $sub_group ) {
					$group = $sub_group;
					require ( GROUP_VIEW_DIR . '/list.view.php' );
			  }
			}
			?>

		</li>
	</ul>
	<?php
endif;
