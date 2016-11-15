<?php
/**
 * Affiches la liste des groupements
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
		<ul data-id="<?php echo esc_attr( $groupment->id ); ?>" class="sortable">
			<li class="ui-state-default" data-id="<?php echo esc_attr( $groupment->id ); ?>">
				<span><?php echo esc_html( $groupment->unique_identifier ); ?></span>

				<ul class="child" data-id="<?php echo esc_attr( $groupment->id ); ?>">
					<?php
					if ( ! empty( $groupment->list_group ) ) :
						view_util::exec( 'page_sorter', 'list', array( 'groupments' => $groupment->list_group ) );
					endif;
					?>
				</ul>
			</li>
		</ul>
		<?php
	endforeach;
endif;
