<?php
/**
 * Gestion du formulaire pour générer un accident de travail bénin
 *
 * @author Jimmy Latour <jimmy@evarisk.com>
 * @since 6.3.0
 * @version 6.3.0
 * @copyright 2015-2017 Evarisk
 * @package DigiRisk
 */

if ( ! defined( 'ABSPATH' ) ) {	exit; } ?>

<tr class="accident-row">
	<input type="hidden" name="action" value="generate_accident_benin" />
	<?php wp_nonce_field( 'ajax_generate_accident_benin' ); ?>
	<td></td>
	<td><?php esc_html_e( 'Cliquer sur l\'icone d\'ajout pour générer un accident de travail bénin', 'digirisk' ); ?></td>
	<td>
		<div class="action">
			<div class="w50 action-input add button blue" data-loader="table" data-parent="accident-row">
				<i class="icon fa fa-plus"></i>
			</div>
		</div>
	</td>

</tr>
