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

<div class="wpeo-table table-flex risk">
	<div class="table-row table-header">
		<div class="table-cell table-50"><?php esc_html_e( 'Risque', 'digirisk' ); ?></div>
		<div class="table-cell table-50"><?php esc_html_e( 'Cot', 'digirisk' ); ?></div>
		<div class="table-cell"><?php esc_html_e( 'Commentaire', 'digirisk' ); ?></div>
	</div>

	<?php
	foreach ( $dangers_preset as $danger ) :
		\eoxia\View_Util::exec( 'digirisk', 'setting', 'preset/item', array(
			'risk' => $danger,
		) );
	endforeach;
	?>
</div>

<a href="#" class="margin wpeo-button save-all button-disable"><?php esc_html_e( 'Enregistrer', 'digirisk' ); ?></a>
