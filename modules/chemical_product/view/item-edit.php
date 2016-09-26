<?php if ( !defined( 'ABSPATH' ) ) exit; ?>
<li class="wp-digi-list-item">
		<input name="chemi_product[<?php echo $chemical_product->id; ?>][id]" type="hidden" value="<?php echo $chemical_product->id; ?>" />
		<?php echo do_shortcode( '[eo_upload_button id="' . $chemical_product->id . '" type="chemi_product"]' ); ?>
		<span class="padded"><?php echo $chemical_product->unique_identifier; ?></span>
		<span class="padded"><input type="text" name="chemi_product[<?php echo $chemical_product->id; ?>][title]" value="<?php echo $chemical_product->title; ?>" placeholder="Nom" /></span>
		<span class="padded"><input type="text" name="chemi_product[<?php echo $chemical_product->id; ?>][content]" value="<?php echo $chemical_product->content; ?>" placeholder="Description" /></span>
		<span class="padded"><input type="text" name="chemi_product[<?php echo $chemical_product->id; ?>][CAS_number]" value="<?php echo $chemical_product->CAS_number; ?>" placeholder="N. CAS" /></span>
		<span class="padded"><input type="text" name="chemi_product[<?php echo $chemical_product->id; ?>][reference]" value="<?php echo $chemical_product->reference; ?>" placeholder="Reference" /></span>
		<span class="wp-digi-chemical-product-action wp-digi-action-new wp-digi-action" >
			<?php
			if ( empty( $chemical_product->id ) ):
				?>
				<a href="#" class="wp-digi-action dashicons dashicons-plus" ></a>
				<?php
			else:
				?>
				<a href="#" data-id="<?php echo $chemical_product->id; ?>" class="wp-digi-action wp-digi-action-edit fa fa-floppy-o" aria-hidden="true" ></a>
				<?php
			endif;
			?>
		</span>
</li>
