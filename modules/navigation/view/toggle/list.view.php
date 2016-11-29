<?php
/**
 * La liste des groupements
 *
 * @package Evarisk\Plugin
 */

namespace digi;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! empty( $groupments ) ) :
	foreach ( $groupments as $key => $groupment ) :
		?>
		<ul class="<?php echo esc_attr( ! empty( $groupment->parent_id ) ? 'sub-menu': 'parent' ); ?>">
			<li data-groupment-id="<?php echo esc_attr( $groupment->id ); ?>">
				<div class="<?php echo $groupment->id === $selected_groupment_id ? 'active' : ''; ?>">
					<span
						data-action="load_society"
						data-groupment-id="<?php echo esc_attr( $groupment->id ); ?>"
						class="action-attribute"><?php echo esc_html( $groupment->unique_identifier . ' - ' . $groupment->title ); ?></span>

					<span class="wp-digi-new-group-action">
						<?php if ( empty( $groupment->list_workunit ) ) : ?>
							<a
								data-parent-id="<?php echo esc_attr( $groupment->id ); ?>"
								data-action="create_group"
								href="#"
								class="wp-digi-action dashicons dashicons-plus action-attribute"></a>
						<?php endif; ?>
					</span>
				</div>

				<?php Navigation_Class::g()->display_toggle_list( $selected_groupment_id, $groupment->id ); ?>
			</li>
		</ul>
		<?php
	endforeach;
endif;
