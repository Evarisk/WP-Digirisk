<?php
/**
 * Affiches la liste des risques
 *
 * @author Jimmy Latour <jimmy@evarisk.com>
 * @version 6.2.1.0
 * @copyright 2015-2016 Eoxia
 * @package recommendation
 * @subpackage shortcode
 */

namespace digi;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
?>
<ul class="wp-digi-list wp-digi-risk wp-digi-table">
	<li class="wp-digi-risk-list-header wp-digi-table-header" >
		<span class="wp-digi-risk-list-column-thumbnail" >&nbsp;</span>
		<span class="wp-digi-risk-list-column-cotation" ><i class="fa fa-line-chart" aria-hidden="true"></i></span>
		<span class="wp-digi-risk-list-column-reference header" ><?php esc_html_e( 'Ref.', 'digirisk' ); ?></span>
		<span><?php esc_html_e( 'Risque', 'digirisk' ); ?></span>
		<span><?php esc_html_e( 'Comment', 'digirisk' ); ?></span>
		<span class="wp-digi-risk-list-column-actions" >&nbsp;</span>
	</li>

	<?php if ( ! empty( $risks ) ) : ?>
		<?php foreach ( $risks as $risk ) : ?>
			<?php view_util::exec( 'risk', 'list-item', array( 'risk' => $risk ) ); ?>
		<?php endforeach; ?>
	<?php endif; ?>

	<?php
	if ( ! empty( $risk_schema ) ) :
		view_util::exec( 'risk', 'item-edit', array( 'society_id' => $society_id, 'risk' => $risk_schema ) );
	endif;
	?>
</ul>

<?php
// if ( ! empty( $society->list_workunit ) ) :
// 	foreach ( $society->list_workunit as $workunit ) :
// 		view_util::exec( 'risk', 'main', array( 'society' => $workunit, 'risks' => $workunit->list_risk, 'risk_schema' => null ) );
// 	endforeach;
// endif;
//
// if ( ! empty( $society->list_group ) ) :
// 	foreach ( $society->list_group as $group ) :
// 		view_util::exec( 'risk', 'main', array( 'society' => $group, 'risks' => $group->list_risk, 'risk_schema' => null ) );
// 		if ( ! empty( $group->list_workunit ) ) :
// 			foreach ( $group->list_workunit as $workunit ) :
// 				view_util::exec( 'risk', 'main', array( 'society' => $workunit, 'risks' => $workunit->list_risk, 'risk_schema' => null ) );
// 			endforeach;
// 		endif;
// 	endforeach;
// endif;
