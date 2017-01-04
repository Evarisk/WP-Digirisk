<?php
/**
 * Affiches la cotation d'un risque
 *
 * @author Jimmy Latour <jimmy@evarisk.com>
 * @since 6.2.3.0
 * @version 6.2.3.0
 * @copyright 2015-2017 Evarisk
 * @package method_evaluation
 * @subpackage view
 */

namespace digi;


if ( ! defined( 'ABSPATH' ) ) { exit; } ?>

<div class="cotation-container grid">

	<div class="action cotation default-cotation level<?php echo esc_attr( $risk->evaluation->scale ); ?>">
		<i class="icon fa fa-line-chart" style="<?php echo ( 0 !== $risk->evaluation->scale ) ? 'display: none;': ''; ?>"></i>
		<span><?php echo esc_html( $risk->evaluation->risk_level['equivalence'] ); ?></span>
	</div>

</div>
