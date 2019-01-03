<?php
/**
 * Affichage principale pour faire les régagles des risques prédéfinis.
 *
 * @author Evarisk <dev@evarisk.com>
 * @since 6.2.9
 * @copyright 2015-2019 Evarisk
 * @package risk
 * @subpackage view
 */

namespace digi;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
} ?>

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
			\eoxia\View_Util::exec( 'digirisk', 'setting', 'preset/item', array(
				'risk' => $danger,
			) );
		endforeach;
		?>
	</tbody>

</table>

<a href="#" class="margin wpeo-button save-all"><?php esc_html_e( 'Enregistrer', 'digirisk' ); ?></a>
