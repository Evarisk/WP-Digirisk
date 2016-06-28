<?php if ( !defined( 'ABSPATH' ) ) exit; ?>
<div class="wp-digi-workunit-sheet wp-digi-clearer" data-id="<?php echo $this->current_workunit->id; ?>"  >

	<div class="wp-digi-workunit-sheet-header wp-digi-global-sheet-header .wp-digi-clearer" >
		<?php $workunit = $this->current_workunit; $editable_identity = true; require( wpdigi_utils::get_template_part( WPDIGI_STES_DIR, WPDIGI_STES_TEMPLATES_MAIN_DIR, 'workunit', 'identity' ) ); unset($workunit); ?><span class="wp-digi-workunit-infos wp-digi-global-infos" > | <?php printf( __( 'Last update on %s', 'digirisk' ), mysql2date( 'd.m.y', $this->current_workunit->date_modified, true ) ); ?></span>
		<div class="wp-digi-workunit-action-container wp-digi-global-action-container hidden" >
			<button class="wp-digi-bton-fourth" id="wp-digi-save-workunit-identity-button" data-nonce="<?php echo wp_create_nonce( 'ajax_update_workunit_' . $this->current_workunit->id ); ?>" ><?php _e( 'Save', 'digirisk' ); ?></button>
		</div>
	</div>

	<?php //require_once( wpdigi_utils::get_template_part( WPDIGI_STES_DIR, WPDIGI_STES_TEMPLATES_MAIN_DIR, 'workunit', 'sheet', 'description' )); ?>

	<ul class="wp-digi-workunit-sheet-tab wp-digi-global-sheet-tab wp-digi-clearer" data-type="workunit" ><?php $this->display_workunit_tab( $this->current_workunit, $workunit_default_tab ); ?></ul>
	<ul class="wp-digi-workunit-sheet-tab responsive wp-digi-global-sheet-tab wp-digi-clearer" data-type="workunit" >
		<ul class="wp-digi-sheet-tab-responsive-content" data-type="workunit" style="display: none;"><?php $this->display_workunit_tab( $this->current_workunit, $workunit_default_tab ); ?></ul>
		<span class="wp-digi-sheet-tab-title"></span>
		<div class="wp-digi-sheet-tab-toggle"><i class="dashicons dashicons-menu"></i></div>
	</ul>

	<div class="wp-digi-workunit-sheet-content wp-digi-global-sheet-content wp-digi-clearer wp-digi-bloc-loader" ><?php $this->display_workunit_tab_content( $this->current_workunit, $workunit_default_tab ); ?></div>
</div>
