<?php
/**
 * Affiches une unité de travail dans la navigation
 *
 * @author Jimmy Latour <jimmy@evarisk.com>
 * @since 0.1
 * @version 6.2.4.0
 * @copyright 2015-2017 Evarisk
 * @package navigation
 * @subpackage view
 */

namespace digi;

if ( ! defined( 'ABSPATH' ) ) { exit; } ?>

<li class="unit-header <?php echo esc_attr( $workunit->id === $workunit_selected_id ) ? 'active' : ''; ?>"
	data-workunit-id="<?php echo esc_attr( $workunit->id ); ?>"
	data-type="<?php echo esc_attr( $workunit->type ); ?>">

	<?php do_shortcode( '[eo_upload_button id=' . $workunit->id . ' type=' . $workunit->type . ']' ); ?>

	<span
		data-nonce="<?php echo esc_attr( wp_create_nonce( 'load_right_container' ) ); ?>"
		data-action="load_society"
		data-groupment-id="<?php echo esc_attr( $workunit->parent_id ); ?>"
		data-workunit-id="<?php echo esc_attr( $workunit->id ); ?>"
		data-loader="digirisk-wrap"
		class="action-attribute title">
		<strong><?php echo esc_html( $workunit->unique_identifier ); ?> -</strong>
		<span class="title" title="<?php echo esc_attr( $workunit->title ); ?>"><?php echo esc_html( $workunit->title ); ?></span>
	</span>


	<span class="action-delete delete button w50"
		data-id="<?php echo esc_attr( $workunit->id ); ?>"
		data-nonce="<?php echo esc_attr( wp_create_nonce( 'delete_society' ) ); ?>"
		data-action="delete_society"
		data-loader="unit-header">
		<i class="icon dashicons dashicons-no-alt"></i>
	</span>
</li>
