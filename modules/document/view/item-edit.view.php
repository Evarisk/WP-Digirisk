<?php
/**
 * Template permettant de générer une fiche de groupement ou de poste.
 *
 * @author    Evarisk <dev@evarisk.com>
 * @copyright (c) 2006-2018 Evarisk <dev@evarisk.com>.
 *
 * @license   AGPLv3 <https://spdx.org/licenses/AGPL-3.0-or-later.html>
 *
 * @package   DigiRisk\Templates
 *
 * @since     6.0.0
 */

namespace digi;

defined( 'ABSPATH' ) || exit; ?>

<tr class="sheet-groupment-row">
	<input type="hidden" name="action" value="<?php echo esc_attr( $action ); ?>" />
	<?php wp_nonce_field( $action ); ?>
	<input type="hidden" name="element_id" value="<?php echo esc_attr( $element->data['id'] ); ?>" />

	<td></td>
	<td>
		<?php
		// Translators: Cliquer sur l'icone d'ajout pour générer une fiche de groupement.
		sprintf( esc_html_e( 'Cliquer sur l\'icone d\'ajout pour générer une %s', 'digirisk' ), esc_html( $_this->get_post_type_name() ) );
		?>
	</td>
	<td>
		<div class="action">
			<div class="w50 action-input add button blue" data-loader="table" data-parent="sheet-groupment-row">
				<i class="icon far fa-plus"></i>
			</div>
		</div>
	</td>

</tr>
