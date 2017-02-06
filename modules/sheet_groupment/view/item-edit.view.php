<?php
/**
 * Gestion du formulaire pour générer une fiche de groupement
 *
 * @author Jimmy Latour <jimmy@evarisk.com>
 * @since 6.2.1.0
 * @version 6.2.4.0
 * @copyright 2015-2017 Evarisk
 * @package sheet_groupment
 * @subpackage view
 */

if ( ! defined( 'ABSPATH' ) ) {	exit; } ?>

<tr class="sheet-groupment-row">
	<input type="hidden" name="action" value="generate_fiche_de_groupement" />
	<?php wp_nonce_field( 'ajax_generate_fiche_de_groupement' ); ?>
	<input type="hidden" name="element_id" value="<?php echo esc_attr( $element_id ); ?>" />

	<td></td>
	<td><?php esc_html_e( 'Cliquer sur l\'icone d\'ajout pour générer une fiche de groupement', 'digirisk' ); ?></td>
	<td>
		<div class="action">
			<div class="w50 action-input add button blue" data-loader="table" data-parent="sheet-groupment-row">
				<i class="icon fa fa-plus"></i>
			</div>
		</div>
	</td>

</tr>
