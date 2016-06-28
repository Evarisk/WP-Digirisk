<?php if ( !defined( 'ABSPATH' ) ) exit; ?>
<div>
	<ul class="wp-digi-list wp-digi-risk wp-digi-table" >
		<li class="wp-digi-risk-list-header wp-digi-table-header" >
			<span class="wp-digi-risk-list-column-thumbnail" >&nbsp;</span>
			<span class="wp-digi-risk-list-column-cotation" ><?php _e( 'Cot.', 'wpdigi-i18n' ); ?></span>
			<span class="wp-digi-risk-list-column-reference header" ><?php _e( 'Ref.', 'wpdigi-i18n' ); ?></span>
			<span><?php _e( 'Danger', 'wpdigi-i18n' ); ?></span>
			<span><?php _e( 'Comment', 'wpdigi-i18n' ); ?></span>
			<span class="wp-digi-risk-list-column-actions" >&nbsp;</span>
		</li>

		<?php $i = 1; ?>
		<?php if ( !empty( $list_risk ) ) : ?>
			<?php foreach ( $list_risk as $risk ) : ?>
				<?php require( wpdigi_utils::get_template_part( WPDIGI_RISKS_DIR, WPDIGI_RISKS_TEMPLATES_MAIN_DIR, 'simple', 'list', 'item' ) ); ?>
			<?php endforeach; ?>
		<?php endif; ?>

	</ul>

	<?php require_once( wpdigi_utils::get_template_part( WPDIGI_RISKS_DIR, WPDIGI_RISKS_TEMPLATES_MAIN_DIR, 'simple', 'item', 'new' ) ); ?>
</div>
