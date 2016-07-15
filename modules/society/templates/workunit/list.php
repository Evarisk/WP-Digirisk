<?php if ( !defined( 'ABSPATH' ) ) exit; ?>
<ul class="wp-digi-list wp-digi-list-workunit" >
	<?php if ( !empty( $list ) ) : ?>
	<!-- List existing work unit -->
	<?php foreach ( $list as $element ) : ?>
		<?php require( wpdigi_utils::get_template_part( WPDIGI_STES_DIR, WPDIGI_STES_TEMPLATES_MAIN_DIR, 'workunit', 'list', 'item' ) ); ?>
	<?php endforeach; ?>
<?php endif; ?>

<?php $count_children = count( get_children( array( 'post_parent' => $args['group_id'], 'post_type' => 'digi-group' ) ) );?>

<?php if ( $count_children == 0 ): ?>
		<li class="wp-digi-workunit wp-digi-new-workunit" >
			<span class="wp-digi-new-workunit-name" >
				<form id="wpdigi-workunit-creation-form" action="<?php echo admin_url( 'admin-ajax.php' ); ?>" method="post" >
					<input type="hidden" name="action" value="wpdigi_ajax_workunit_create" />
					<input type="hidden" name="workunit[parent_id]" value="<?php echo $args[ 'group_id' ]; ?>" />
					<?php wp_nonce_field( 'wpdigi-workunit-creation', 'wpdigi_nonce', false, true ); ?>
					<input type="text" placeholder="<?php _e( 'New work unit', 'digirisk' ); ?>" name="workunit[title]" />
				</form>
			</span>
			<span class="wp-digi-new-workunit-action" ><a href="#" class="wp-digi-action dashicons dashicons-plus" ></a></span>
		</li>
	<?php endif; ?>
</ul>
