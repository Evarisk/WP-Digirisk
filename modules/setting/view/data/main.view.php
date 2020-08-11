<?php
/**
 * Affichage principale pour définir les préfix des odt Causeries / Plan de prévention / Permis de feu
 *
 * @author Evarisk <dev@evarisk.com>
 * @since 7.3.5
 * @copyright 2019 Evarisk
 */

namespace digi;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
} ?>

<div class="wpeo-table table-flex">
	<div class="table-row table-header">
		<div class="table-cell"><?php esc_html_e( 'Element', 'digirisk' ); ?></div>
		<div class="table-cell table-150"><?php esc_html_e( 'Valeur par défaut', 'digirisk' ); ?></div>
	</div>
	<?php
	if ( ! empty( $list_default_values ) ) :
		foreach ( $list_default_values as $key => $element ) :
			\eoxia\View_Util::exec( 'digirisk', 'setting', 'data/item-default-values', array(
				'key'     => $key,
				'element' => $element,
			) );
		endforeach;
	endif;
	?>
</div>

<a href="#" class="margin wpeo-button button-disable action-input save-default-values"
data-action="update_default_values"
data-nonce="<?php echo esc_attr( wp_create_nonce( 'update_default_values' ) ); ?>"
data-parent="tab-content"
style="float: right; margin-top: 10px;">
	<?php esc_html_e( 'Enregistrer', 'digirisk' ); ?>
</a>

<div class="wpeo-notification notification-green default-values-response-success"
style="opacity:1; display:none; bottom:auto; cursor : pointer; pointer-events : auto;position: inherit; margin-top: 1em; max-width: 250px;">
	<i class="notification-icon fas fa-check"></i>
	<div class="notification-title"></div>
	<div class="notification-close"><i class="fas fa-times"></i></div>
</div>

