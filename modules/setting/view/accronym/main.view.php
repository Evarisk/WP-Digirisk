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

<table class="table">
	<thead>
		<tr>
			<th class="padding"><?php esc_html_e( 'Element', 'digirisk' ); ?></th>
			<th class="padding"><?php esc_html_e( 'Prefix', 'digirisk' ); ?></th>
			<th class="w100 padding"><?php esc_html_e( 'Accéder', 'digirisk' ); ?></th>
		</tr>
	</thead>
	<tbody>
		<ul>
			<?php
			if ( ! empty( $list_accronym ) ) :
				foreach ( $list_accronym as $key => $element ) :
					\eoxia\View_Util::exec( 'digirisk', 'setting', 'accronym/item-prefix', array(
						'key'     => $key,
						'element' => $element,
					) );
				endforeach;
			endif;
			?>
		</ul>
	</tbody>
</table>

<a href="#" class="margin wpeo-button button-disable action-input save-prefix"
data-action="update_accronym"
data-nonce="<?php echo esc_attr( wp_create_nonce( 'update_accronym' ) ); ?>"
data-parent="tab-content"
style="float: right; margin-top: 10px;">
	<?php esc_html_e( 'Enregistrer', 'digirisk' ); ?>
</a>

<div class="wpeo-notification notification-green prefix-response-success"
style="opacity:1; display:none; bottom:auto; cursor : pointer; pointer-events : auto;position: inherit; margin-top: 1em; max-width: 250px;">
	<i class="notification-icon fas fa-check"></i>
	<div class="notification-title"></div>
	<div class="notification-close"><i class="fas fa-times"></i></div>
</div>
