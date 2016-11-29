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
	data-id="<?php echo esc_attr( $workunit->id ); ?>"
	data-type="<?php echo esc_attr( $workunit->type ); ?>">

	<?php view_util::exec( 'society', 'identity', array( 'element' => $workunit ) ); ?>

	<span class="wp-digi-workunit-action" >
	<a href="#"
		data-id="<?php echo esc_attr( $workunit->id ); ?>"
		data-nonce="<?php echo wp_create_nonce( 'ajax_delete_workunit_' . $workunit->id ); ?>"
		data-action="delete_society"
		class="wp-digi-action wp-digi-action-delete dashicons dashicons-no-alt" ></a>
	</span>
</li>
