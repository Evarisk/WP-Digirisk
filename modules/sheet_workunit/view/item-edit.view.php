<?php
/**
 * Gestion du formulaire pour générer une fiche de poste
 *
 * @author Jimmy Latour <jimmy@evarisk.com>
 * @since 6.2.1.0
 * @version 6.2.5.0
 * @copyright 2015-2017 Evarisk
 * @package sheet_workunit
 * @subpackage view
 */

if ( ! defined( 'ABSPATH' ) ) {	exit; } ?>

<tr class="sheet-workunit-row">
	<input type="hidden" name="action" value="generate_fiche_de_poste" />
	<?php wp_nonce_field( 'ajax_generate_fiche_de_poste' ); ?>
	<input type="hidden" name="element_id" value="<?php echo esc_attr( $element_id ); ?>" />

	<td></td>
	<td><?php esc_html_e( 'Cliquer sur l\'icone d\'ajout pour générer une fiche d\'unité de travail.', 'digirisk' ); ?></td>

	<td>
		<div class="action">
			<div class="action-input button blue add w50" data-loader="table" data-parent="sheet-workunit-row">
				<i class="icon fa fa-plus"></i>
			</div>
		</div>
	</td>
</li>
