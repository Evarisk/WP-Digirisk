<?php
/**
 * Affiches une unité de travail dans la navigation
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

<li class="unit">
	<div class="unit-container">
		<div class="toggle"><span class="icon"></span></div>
		<div class="media no-file">
			<i class="add animated fa fa-plus-circle"></i>
			<i class="default-image fa fa-picture-o"></i>
		</div>
		<div class="title action-attribute"
				data-nonce="<?php echo esc_attr( wp_create_nonce( 'load_right_container' ) ); ?>"
				data-action="load_society"
				data-establishment-id="<?php echo esc_attr( $establishment->id ); ?>"
				data-loader="digirisk-wrap"
				data-namespace="digirisk"
				data-module="navigation"
				data-before-method="setUnitActive">
			<span class="title-container">
				<span class="ref"><?php echo esc_html( $establishment->modified_unique_identifier ); ?></span>
				<span class="name"><?php echo esc_html( $establishment->title ); ?></span>
			</span>
		</div>
		<?php
		if ( 'digi-group' === $establishment->type ) :
		?>
			<div class="add-container">
				<div class="button w30 blue" data-type="Group_Class"><span class="icon dashicons dashicons-admin-multisite"></span></div>
				<div class="button w30 blue" data-type="Workunit_Class"><span class="icon dashicons dashicons-admin-home"></span></div>
			</div>
		<?php
		endif;
		?>
	</div>
	<?php Navigation_Class::g()->display_list( $establishment->id ); ?>
</li>
