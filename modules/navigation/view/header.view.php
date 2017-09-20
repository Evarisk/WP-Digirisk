<?php
/**
 * Le header contenu le nom de la société
 *
 * @author Jimmy Latour <jimmy@evarisk.com>
 * @since 0.1.0
 * @version 6.3.0
 * @copyright 2015-2017 Evarisk
 * @package DigiRisk
 */

namespace digi;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
} ?>

<div class="society-header">
	<div class="title action-attribute"
			data-nonce="<?php echo esc_attr( wp_create_nonce( 'load_right_container' ) ); ?>"
			data-action="load_society"
			data-establishment-id="<?php echo esc_attr( $society->id ); ?>"
			data-loader="digirisk-wrap">
		<span class="icon dashicons dashicons-building"></span>
		<?php echo esc_html( $society->title ); ?>
	</div>
	<div class="add-container">
		<div class="button w30 blue" data-type="Group_Class"><span class="icon dashicons dashicons-admin-multisite"></span></div>
		<div class="button w30 blue" data-type="Workunit_Class"><span class="icon dashicons dashicons-admin-home"></span></div>
	</div>
</div>

<div class="toolbar">
	<div class="toggle-plus tooltip hover" aria-label="<?php echo esc_attr( 'Tout déplier', 'digirisk' ); ?>"><span class="icon fa fa-plus-square"></span></div>
	<div class="toggle-minus tooltip hover" aria-label="<?php echo esc_attr( 'Tout replier', 'digirisk' ); ?>"><span class="icon fa fa-minus-square"></span></div>
</div>
