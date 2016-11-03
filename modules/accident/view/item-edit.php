<?php if ( !defined( 'ABSPATH' ) ) exit; ?>
<li class="wp-digi-list-item">
		<input name="accident[<?php echo $accident->id; ?>][id]" type="hidden" value="<?php echo $accident->id; ?>" />
		<span class="padded"><?php echo $accident->unique_identifier; ?></span>
		<?php do_shortcode( '[digi_dropdown_risk society_id=' . $society_id . ' element_id=' . $accident->id . ' risk_id=' . $accident->risk_id . ']' ); ?>
		<span class="padded"><input type="text" name="accident[<?php echo $accident->id; ?>][accident_date]" value="<?php echo $accident->accident_date; ?>" placeholder="Date" class="eva-date" /></span>
		<?php do_shortcode( '[digi_dropdown_user element_id=' . $accident->id . ' user_id=' . $accident->user_id . ']' ); ?>
		<span class="padded"><input type="text" name="accident[<?php echo $accident->id; ?>][content]" value="<?php echo $accident->content; ?>" placeholder="Ajouter une description" /></span>
		<span class="padded"><input type="text" name="accident[<?php echo $accident->id; ?>][number_stop_day]" value="<?php echo $accident->number_stop_day; ?>" placeholder="Nb. de jour" /></span>
		<span class="wp-digi-accident-action wp-digi-action-new wp-digi-action" >
			<?php
			if ( empty( $accident->id ) ):
				?>
				<a href="#" class="wp-digi-action dashicons dashicons-plus" ></a>
				<?php
			else:
				?>
				<a href="#" data-id="<?php echo $accident->id; ?>" class="wp-digi-action wp-digi-action-edit fa fa-floppy-o" aria-hidden="true" ></a>
				<?php
			endif;
			?>
		</span>
</li>
