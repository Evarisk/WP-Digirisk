<?php if ( !defined( 'ABSPATH' ) ) exit; ?>
<div class="wp-digi-group-header wp-digi-group-selector" >
<?php
	if ( !empty( $group_list ) ) : /**	Si il y a des groupements / If there are group existing	*/
		$unique_identifier = $this->get_unique_identifier_in_list_by_id( $group_id, $group_list );
		$title = $this->get_title_in_list_by_id( $group_id, $group_list );

		if ( true /*2 <= count( $group_list )*/ ) : /**	Si il y au moins 2 groupements / If there are at least 2 groups	*/
?>

			<toggle class="wp-digi-summon-list navigation wp-digi-button-popup" data-target="wp-digi-develop-list">
				<?php do_shortcode( '[eo_upload_button id=' . $group_id . ' type=digi-group]' ); ?>
				<?php echo $unique_identifier . ' - <span>' . $title . '</span>'; ?><i class="dashicons dashicons-arrow-down"></i>
			</toggle>
			<div class="wp-digi-develop-list digi-popup hidden">
				<?php $this->render_list_item( $group_id, 0, 'parent' ); ?>
			</div>
<?php
		else: /**	Si il n'y a qu'un seul groupement / If there is only one group	*/
?>
			<div><?php echo $unique_identifier . ' - ' . $title; ?></div>
<?php

		endif;
	endif;
?>
</div>
