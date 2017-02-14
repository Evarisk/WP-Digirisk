<?php
/**
 * Accord de participation
 *
 * @author Jimmy Latour <jimmy@evarisk.com>
 * @since 6.2.6.0
 * @version 6.2.6.0
 * @copyright 2015-2017 Evarisk
 * @package legal_display
 * @subpackage view
 */

namespace digi;

if ( ! defined( 'ABSPATH' ) ) { exit; } ?>

<ul class="form">
	<li><h2><?php esc_html_e( 'Accord de participation', 'digirisk' ); ?></h2></li>
	<li class="form-element <?php echo esc_attr( ! empty( $legal_display->participation_agreement['information_procedures'] ) ? 'active' : '' ); ?>">
		<input name="participation_agreement[information_procedures]" type="text" value="<?php echo esc_attr( $legal_display->participation_agreement['information_procedures'] ); ?>" />
		<label><?php esc_html_e( 'Modalités d\'information', 'digirisk' ); ?></label>
		<span class="bar"></span>
	</li>
</ul>
