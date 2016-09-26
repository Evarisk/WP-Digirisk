<?php if ( !defined( 'ABSPATH' ) ) exit; ?>

<li class="wp-digi-list-item wp-digi-accident-item" data-accident-id="<?php echo $accident->id; ?>" >
	<span class="padded"><?php echo $accident->unique_identifier; ?></span>
	<span class="padded"><?php _e( 'Risque', 'digirisk' ); echo ' ' . $accident->list_risk[0]->unique_identifier . ' - ' . $accident->list_risk[0]->evaluation[0]->unique_identifier; ?></span>
	<span class="padded"><?php echo $accident->accident_date; ?></span>
	<span class="padded"><?php echo $accident->list_user[0]->displayname; ?></span>
	<span class="padded"><?php echo $accident->content; ?></span>
	<span class="padded"><?php echo $accident->number_stop_day; ?></span>
	<span class="wp-digi-action wp-digi-accident-action" >
		<span class="padded"><a href="#" data-id="<?php echo $accident->id; ?>" data-nonce="<?php echo wp_create_nonce( 'ajax_load_accident_' . $accident->id ); ?>" class="wp-digi-action wp-digi-action-load dashicons dashicons-edit" ></a></span>
		<span class="padded"><a href="#" data-id="<?php echo $accident->id; ?>" data-nonce="<?php echo wp_create_nonce( 'ajax_delete_accident_' . $accident->id ); ?>" class="wp-digi-action wp-digi-action-delete dashicons dashicons-no-alt" ></a></span>
	</span>
</li>
