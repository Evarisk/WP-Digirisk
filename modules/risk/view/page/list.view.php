<?php
/**
 * Affiches la liste des risques
 *
 * @author Jimmy Latour <jimmy@evarisk.com>
 * @since 6.2.3.0
 * @version 6.2.4.0
 * @copyright 2015-2017 Evarisk
 * @package risk
 * @subpackage view
 */

namespace digi;

if ( ! defined( 'ABSPATH' ) ) {	exit; } ?>

<thead>
	<tr>
		<td class="w100 padding">Groupement</td>
		<td class="w100 padding">Unité de travail</td>
		<td class="w50">&nbsp;</td>
		<td class="w50"><a class="tooltip hover" aria-label="<?php echo esc_attr( 'Cliquer pour trier par cotation', 'digirisk' ); ?>" href="<?php echo esc_attr( admin_url( 'admin.php?page=digirisk-handle-risk' ) . $url_ref_order ); ?>"><i class="fa fa-line-chart" aria-hidden="true"></i></a></td>
		<td class="w50"><?php esc_html_e( 'Ref.', 'digirisk' ); ?></td>
		<td class="w50"><?php esc_html_e( 'Risque', 'digirisk' ); ?></td>
		<td><?php esc_html_e( 'Comment', 'digirisk' ); ?></td>
		<td>&nbsp;</td>
	</tr>
</thead>

<tbody>
	<?php $i = 1; ?>
	<?php if ( ! empty( $risk_list ) ) : ?>
		<?php foreach ( $risk_list as $risk ) : ?>
			<?php View_Util::exec( 'risk', 'page/item-edit', array( 'risk' => $risk ) ); ?>
		<?php endforeach; ?>
	<?php endif; ?>
</tbody>
