<?php
/**
 * Déclares le champ "select" avec les risques de la société.
 *
 * @author Jimmy Latour <jimmy@evarisk.com>
 * @since 6.3.0
 * @version 6.3.0
 * @copyright 2015-2017 Evarisk
 * @package DigiRisk
 */

namespace digi;

if ( ! defined( 'ABSPATH' ) ) { exit; } ?>

<?php
if ( ! empty( $risks ) ) :
	?>
	<select name="accident[risk_id]">
		<?php
		foreach ( $risks as $risk ) :
			\eoxia\View_Util::exec( 'digirisk', 'risk', 'dropdown/list-item', array(
				'risk' => $risk,
				'risk_id' => $risk_id,
			) );
		endforeach;
		?>
	</select>
	<?php
else :
	?><span><?php esc_html_e( 'Aucun risque', 'digirisk' ); ?></span><?php
endif;
?>
