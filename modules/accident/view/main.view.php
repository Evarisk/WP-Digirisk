<?php

namespace digi;

if ( !defined( 'ABSPATH' ) ) exit; ?>

<form method="post" action="<?php echo admin_url( 'admin-ajax.php' ); ?>" class="wp-digi-bloc-loader form-accident">
	<?php wp_nonce_field( 'edit_accident' ); ?>
	<input type="hidden" name="action" value="edit_accident" />
	<input type="hidden" name="parent_id" value="<?php echo $society_id; ?>" />

	<ul class="wp-digi-list wp-digi-accident wp-digi-table">
		<?php
		Accident_Class::g()->display_accident_list( $society_id );
		View_Util::exec( 'accident', 'item-edit', array(
			'accident' => $accident,
			'society_id' => $society_id,
		) );
		?>
	</ul>
</form>
