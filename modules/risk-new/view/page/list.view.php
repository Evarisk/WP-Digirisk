<?php
/**
 * Affiches la liste des risques
 *
 * @author Evarisk <dev@evarisk.com>
 * @since 6.2.3
 * @version 6.4.0
 * @copyright 2015-2017 Evarisk
 * @package DigiRisk
 */

namespace digi;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
} ?>

<thead>
	<tr>
		<td class="w100 padding"><?php esc_html_e( 'Parent', 'digirisk' ); ?></td>
		<td>&nbsp;</td>
		<td class="w50"><a href="<?php echo esc_attr( admin_url( 'admin.php?page=digirisk-handle-risk' . $url_ref_order ) ); ?>"><i class="fas fa-chart-line"></i></a></td>
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
			<?php
			\eoxia\View_Util::exec( 'digirisk', 'risk', 'page/item-edit', array(
				'risk' => $risk,
			) );
			?>
		<?php endforeach; ?>
	<?php endif; ?>
</tbody>
