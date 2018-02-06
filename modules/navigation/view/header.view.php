<?php
/**
 * Le header contenu le nom de la société
 *
 * @author Jimmy Latour <jimmy@evarisk.com>
 * @since 6.0.0
 * @version 6.3.0
 * @copyright 2015-2017 Evarisk
 * @package DigiRisk
 */

namespace digi;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
} ?>

<div class="society-header action-attribute"
			data-nonce="<?php echo esc_attr( wp_create_nonce( 'load_right_container' ) ); ?>"
			data-action="load_society"
			data-establishment-id="<?php echo esc_attr( $society->id ); ?>"
			data-loader="digirisk-wrap"
			data-namespace="digirisk"
			data-module="navigation"
			data-before-method="setUnitActive">
	<span class="icon fas fa-building fa-fw"></span>
	<div class="title">
		<?php echo esc_html( $society->title ); ?>
	</div>
	<div class="add-container">
		<div class="button w50 blue tooltip hover" aria-label="<?php echo esc_attr( 'Ajouter groupement', 'digirisk' ); ?>" data-type="Group_Class"><span class="icon dashicons dashicons-admin-multisite"></span><span class="button-add animated far fa-plus-circle"></span></div>
		<div class="button w50 blue tooltip hover" aria-label="<?php echo esc_attr( 'Ajouter unité', 'digirisk' ); ?>" data-type="Workunit_Class"><span class="icon dashicons dashicons-admin-home"></span><span class="button-add animated far fa-plus-circle"></span></div>
	</div>
	<div class="mobile-add-container toggle option" data-parent="toggle" data-target="content">
		<i class="action far fa-ellipsis-v"></i>
		<ul class="content">
			<li class="item" data-type="Group_Class"><i class="icon dashicons dashicons-admin-multisite"></i><?php echo esc_attr( 'Ajouter groupement', 'digirisk' ); ?></li>
			<li class="item" data-type="Workunit_Class"><i class="icon dashicons dashicons-admin-home"></i><?php echo esc_attr( 'Ajouter unité', 'digirisk' ); ?></li>
		</ul>
	</div>
	<div class="close-popup"><i class="icon far fa-times"></i></div>
</div>

<div class="toolbar">
	<div class="toggle-plus tooltip hover" aria-label="<?php echo esc_attr( 'Tout déplier', 'digirisk' ); ?>"><span class="icon fas fa-plus-square"></span></div>
	<div class="toggle-minus tooltip hover" aria-label="<?php echo esc_attr( 'Tout replier', 'digirisk' ); ?>"><span class="icon fas fa-minus-square"></span></div>
</div>
