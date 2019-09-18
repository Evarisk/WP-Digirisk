<?php
/**
 * Liste des interventions du plan de prévention
 *
 * @author    Evarisk <dev@evarisk.com>
 * @since     7.3.0
 * @version   7.3.0
 * @copyright 2019 Evarisk.
 * @package   DigiRisk
 */

namespace digi;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

global $eo_search;
?>


	<div class="intervention-table" style="margin-top: 30px">
		<span style="text-align : center"><h2>
			<?php esc_html_e( 'Intervention du plan de prévention', 'digirisk' ); ?>
			<span class="wpeo-tooltip-event"
			aria-label="<?php esc_html_e( 'Listes des interventions associés aux risques', 'digirisk' ); ?>"
			style="color : dodgerblue; cursor : pointer">
				<i class="fas fa-info-circle"></i>
			</span>
		</h2></span>
		<?php
			Prevention_Intervention_Class::g()->display_table( $id, $edit ); // id du plan de prévention
		?>
	</div>
