<?php namespace digi;

if ( !defined( 'ABSPATH' ) ) exit; ?>
	<li class="<?php echo $element->id === $workunit_selected_id ? "active": ""; ?> wp-digi-list-item wp-digi-workunit-<?php echo $element->id; ?> wp-digi-item-workunit" data-id="<?php echo $element->id; ?>" data-type="<?php echo $element->type; ?>">
		<?php view_util::exec( 'society', 'identity', array( 'element' => $element ) ); ?>

		<span class="wp-digi-workunit-action" >
		<a href="#"
			data-id="<?php echo $element->id; ?>"
			data-nonce="<?php echo wp_create_nonce( 'ajax_delete_workunit_' . $element->id ); ?>"
			data-action="delete_society"
			class="wp-digi-action wp-digi-action-delete dashicons dashicons-no-alt" ></a>
		</span>
	</li>
