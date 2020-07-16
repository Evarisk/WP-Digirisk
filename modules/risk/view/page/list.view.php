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

<div class="table-row table-header">
	<div class="table-cell table-150"><?php esc_html_e( 'Parent', 'digirisk' ); ?>.</div>
	<div class="table-cell table-50"><i class="far fa-image"></i></div>
	<div class="table-cell table-50"><a href="<?php echo esc_attr( admin_url( 'admin.php?page=digirisk-handle-risk' . $url_ref_order ) ); ?>"><i class="fas fa-chart-line"></i></a></div>
	<div class="table-cell table-50"><?php esc_html_e( 'Ref.', 'digirisk' ); ?></div>
	<div class="table-cell table-50"><?php esc_html_e( 'Risque', 'digirisk' ); ?></div>
	<div class="table-cell"><?php esc_html_e( 'Comment', 'digirisk' ); ?></div>
	<div class="table-cell table-50 table-end"></div>
</div>

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
