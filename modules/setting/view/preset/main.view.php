<?php
/**
 * Affichage principale pour faire les régagles des risques prédéfinis.
 *
 * @author Jimmy Latour <jimmy@evarisk.com>
 * @since 6.2.9.0
 * @version 6.2.9.0
 * @copyright 2015-2017 Evarisk
 * @package risk
 * @subpackage view
 */

namespace digi;

if ( ! defined( 'ABSPATH' ) ) { exit; } ?>

<table class="table risk">
	<thead>
		<tr>
			<th class="w50"><?php esc_html_e( 'Risque', 'digirisk' ); ?></th>
			<th><?php esc_html_e( 'Cot', 'digirisk' ); ?></th>
			<th class="full"><?php esc_html_e( 'Commentaire', 'digirisk' ); ?></th>
			<th></th>
		</tr>
	</thead>

	<tbody>
		<?php
		foreach ( $dangers_preset as $danger ) :
			View_Util::exec( 'setting', 'preset/item', array(
				'danger' => $danger,
			) );
		endforeach;
		?>
	</tbody>

</table>

<a href="#" class="margin button disable save-all right"><?php esc_html_e( 'Enregistrer', 'digirisk' ); ?></a>
