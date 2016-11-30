<?php
/**
 * Affiches la liste des préconisations
 *
 * @author Jimmy Latour <jimmy@evarisk.com>
 * @version 6.2.1.0
 * @copyright 2015-2016 Eoxia
 * @package recommendation
 * @subpackage view
 */

namespace digi;

if ( ! defined( 'ABSPATH' ) ) { exit; } ?>

<ul class="wp-digi-list wp-digi-recommendation wp-digi-table">
	<li class="wp-digi-table-header">
		<span class="wp-digi-recommendation-list-column-thumbnail" >&nbsp;</span>
		<span class="wp-digi-recommendation-list-column-reference" ><?php _e( 'Ref.', 'digirisk' ); ?></span>
		<span><?php esc_html_e( 'Préconisation', 'digirisk' ); ?></span>
		<span><?php esc_html_e( 'Commentaire', 'digirisk' ); ?></span>
		<span>&nbsp;</span>
		<span>&nbsp;</span>
	</li>

	<?php if ( ! empty( $recommendations ) ) : ?>
		<?php foreach ( $recommendations as $recommendation ) : ?>
			<?php view_util::exec( 'recommendation', 'list-item', array( 'recommendation' => $recommendation ) ); ?>
		<?php endforeach; ?>
	<?php endif; ?>

	<?php
	if ( ! empty( $recommendation_schema ) ) :
		view_util::exec( 'recommendation', 'item-edit', array( 'society_id' => $society_id, 'recommendation' => $recommendation_schema ) );
	endif;
	?>
</ul>
