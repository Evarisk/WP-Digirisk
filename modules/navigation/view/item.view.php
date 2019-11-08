<?php
/**
 * Le template pour afficher un item dans le menu de navigation.
 *
 * @author    Evarisk <dev@evarisk.com>
 * @copyright (c) 2006-2018 Evarisk <dev@evarisk.com>.
 *
 * @license   AGPLv3 <https://spdx.org/licenses/AGPL-3.0-only.html>
 *
 * @package   DigiRisk\Templates
 *
 * @since     6.0.0
 */

namespace digi;

defined( 'ABSPATH' ) || exit; ?>

<li class="unit <?php echo ( $society->ID === $selected_society_id ) ? 'active' : ''; echo ( \eoxia\Post_Util::is_parent( $society->ID, $selected_society_id ) ) ? 'toggled' : ''; ?>"
	data-id="<?php echo esc_attr( $society->ID ); ?>">
	<div class="unit-container">

		<?php if ( Workunit_Class::g()->get_type() !== $society->post_type && \eoxia\Post_Util::have_child( $society->ID, array( 'digi-group', 'digi-workunit' ) ) ) : ?>
			<div class="toggle-unit">
				<i class="fas fa-chevron-right"></i>
			</div>
		<?php else : ?>
			<div class="spacer"><span class="icon"></span></div>
		<?php endif; ?>

		<?php
		echo \eoxia\WPEO_Upload_Shortcode::g()->wpeo_upload( array(
			'id'         => $society->ID,
			'title'      => $society->unique_identifier . ' - ' . $society->post_title,
			'model_name' => esc_attr( Group_Class::g()->get_type() === $society->post_type ? '\digi\Group_Class' : '\digi\Workunit_Class' ),
			'field_name' => 'image',
			'single'     => 'false',
		) );
		?>

		<div class="title action-attribute"
				data-nonce="<?php echo esc_attr( wp_create_nonce( 'load_right_container' ) ); ?>"
				data-action="load_society"
				data-establishment-id="<?php echo esc_attr( $society->ID ); ?>"
				data-loader="digirisk-wrap"
				data-namespace="digirisk"
				data-module="navigation"
				data-before-method="setUnitActive">
			<span class="title-container">
				<span class="ref"><?php echo esc_html( $society->unique_identifier ); ?></span>
				<span class="name"><?php echo esc_html( $society->post_title ); ?></span>
			</span>
		</div>
		<?php
		if ( 'digi-group' === $society->post_type ) :
			?>
			<div class="add-container">
				<div class="wpeo-button button-square-50 wpeo-tooltip-event" data-direction="bottom" data-color="light" aria-label="<?php echo esc_attr( 'Ajouter groupement', 'digirisk' ); ?>" data-type="Group_Class"><span class="button-icon dashicons dashicons-admin-multisite"></span><span class="button-add animated fas fa-plus-circle"></span></div>
				<div class="wpeo-button button-square-50 wpeo-tooltip-event" data-direction="bottom" data-color="light" aria-label="<?php echo esc_attr( 'Ajouter unité', 'digirisk' ); ?>" data-type="Workunit_Class"><span class="button-icon dashicons dashicons-admin-home"></span><span class="button-add animated fas fa-plus-circle"></span></div>
			</div>
			<div class="mobile-add-container wpeo-dropdown dropdown-right option">
				<div class="dropdown-toggle"><i class="action fas fa-ellipsis-v"></i></div>
				<ul class="dropdown-content">
					<li class="dropdown-item" data-type="Group_Class"><i class="icon dashicons dashicons-admin-multisite"></i><?php echo esc_attr( 'Ajouter groupement', 'digirisk' ); ?></li>
					<li class="dropdown-item" data-type="Workunit_Class"><i class="icon dashicons dashicons-admin-home"></i><?php echo esc_attr( 'Ajouter unité', 'digirisk' ); ?></li>
				</ul>
			</div>
			<?php
		endif;
		?>
	</div>

	<?php
	if ( $with_children ) :
		Navigation_Class::g()->display_list( $society->ID, $selected_society_id, $with_children );
	endif;
	?>
</li>
