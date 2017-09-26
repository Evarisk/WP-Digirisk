<?php
/**
 * Les options du champ select.
 *
 * @author Jimmy Latour <jimmy@evarisk.com>
 * @since 6.3.0
 * @version 6.3.0
 * @copyright 2015-2017 Evarisk
 * @package DigiRisk
 */

namespace digi;

if ( ! defined( 'ABSPATH' ) ) { exit; } ?>

<?php $selected = $risk_id === $risk->id ? "selected='selected'" : ''; ?>
<option <?php echo $selected; ?> value="<?php echo esc_attr( $risk->id ); ?>">
	<?php echo ' ' . $risk->unique_identifier . ' - ' . $risk->evaluation->unique_identifier; ?>
</option>
