<?php
/**
 * La liste des groupements dans la navigation
 *
 * @author Jimmy Latour <jimmy@evarisk.com>
 * @since 0.1
 * @version 6.2.8.0
 * @copyright 2015-2017 Evarisk
 * @package navigation
 * @subpackage view
 */

namespace digi;

if ( ! defined( 'ABSPATH' ) ) {	exit; }

if ( ! empty( $groupments ) ) :
	foreach ( $groupments as $key => $groupment ) :
		?>
		<ul class="<?php echo esc_attr( ! empty( $groupment->parent_id ) ? 'sub-menu': 'parent' ); ?>">
			<li data-groupment-id="<?php echo esc_attr( $groupment->id ); ?>">
				<div class="<?php echo $groupment->id === $selected_groupment_id ? 'active' : ''; ?>">
					<span
						data-action="load_society"
						data-groupment-id="<?php echo esc_attr( $groupment->id ); ?>"
						data-loader="digirisk-wrap"
						class="action-attribute"><?php echo esc_html( $groupment->unique_identifier . ' - ' . $groupment->title ); ?></span>

					<span class="wp-digi-new-group-action <?php echo empty( $groupment->count_workunit ) ? 'action-attribute' : ''; ?>"
								data-parent-id="<?php echo esc_attr( $groupment->id ); ?>"
								data-action="create_group"
								data-nonce="<?php echo esc_attr( wp_create_nonce( 'create_group' ) ); ?>"
								data-loader="navigation-container">
						<?php if ( empty( $groupment->count_workunit ) ) : ?>
							<a href="#"	class="wp-digi-action fa fa-plus"></a>
						<?php endif; ?>
					</span>
				</div>

				<?php Navigation_Class::g()->display_toggle_list( $selected_groupment_id, $groupment->id ); ?>
			</li>
		</ul>
		<?php
	endforeach;
endif;
