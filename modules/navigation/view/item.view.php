<?php
/**
 * Une unité de travail
 *
 * @package Evarisk\Plugin
 */

namespace digi;

if ( ! defined( 'ABSPATH' ) ) { exit; }
?>

<li class="<?php echo esc_attr( $workunit->id === $workunit_selected_id ? 'active' : '' ); ?> wp-digi-list-item wp-digi-workunit-<?php echo esc_attr( $workunit->id ); ?> wp-digi-item-workunit"
	data-workunit-id="<?php echo esc_attr( $workunit->id ); ?>"
	data-type="<?php echo esc_attr( $workunit->type ); ?>">

	<?php do_shortcode( '[eo_upload_button id=' . $workunit->id . ' type=' . $workunit->type . ']' ); ?>

	<span
		data-nonce="<?php echo esc_attr( wp_create_nonce( 'load_right_container' ) ); ?>"
		data-action="load_society"
		data-workunit-id="<?php echo esc_attr( $workunit->id ); ?>"
		class="action-attribute">
		<strong><?php echo esc_html( $workunit->unique_identifier ); ?> -</strong>
		<span title="<?php echo esc_attr( $workunit->title ); ?>"><?php echo esc_html( $workunit->title ); ?></span>
	</span>


	<span class="wp-digi-workunit-action" >
	<a href="#"
		data-workunit-id="<?php echo esc_attr( $workunit->id ); ?>"
		data-nonce="<?php echo esc_attr( wp_create_nonce( 'ajax_delete_workunit_' . $workunit->id ) ); ?>"
		data-action="delete_society"
		class="wp-digi-action wp-digi-action-delete dashicons dashicons-no-alt" ></a>
	</span>
</li>
