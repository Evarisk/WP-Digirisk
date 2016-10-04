<?php namespace digi;

if ( !defined( 'ABSPATH' ) ) exit; ?>

<form method="post" action="<?php echo admin_url( 'admin-ajax.php' ); ?>" class="wp-digi-bloc-loader form-risk">
	<?php wp_nonce_field( 'edit_epi' ); ?>
	<input type="hidden" name="action" value="edit_risk" />
	<input type="hidden" name="parent_id" value="<?php echo $society_id; ?>" />

	<ul class="wp-digi-list wp-digi-risk wp-digi-table">
		<?php risk_class::g()->display_risk_list( $society_id ); ?>
		<?php view_util::exec( 'risk', 'item-edit', array( 'society_id' => $society_id, 'risk' => $risk ) ); ?>
	</ul>
</form>
