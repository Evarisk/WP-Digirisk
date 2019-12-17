<?php
/**
 * Affichage pour gérer les capacités des utilisateurs.
 *
 * @author Evarisk <dev@evarisk.com>
 * @since 6.4.0
 * @version 6.4.0
 * @copyright 2015-2017 Evarisk
 * @package DigiRisk
 */

namespace digi;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

global $eo_search; ?>

<div class="section-capability">
	<input type="hidden" name="action" value="save_capability" />
	<?php wp_nonce_field( 'save_capability' ); ?>

	<h3><?php esc_html_e( 'Gestion des droits de DigiRisk', 'digirisk' ); ?></h3>

	<p><?php esc_html_e( 'Définissez les droits d\'accés à l\'application DigiRisk', 'digirisk' ); ?></p>

	<?php $eo_search->display( 'user_list_capacity' ); ?>

	<div class="list-users">
		<?php Setting_Class::g()->display_user_list_capacity(); ?>
	</div>

	<div class="alignright action-input wpeo-button button-blue button-disable" data-parent="section-capability"><span><?php esc_html_e( 'Enregistrer', 'digirisk' ); ?></span></div>
</div>
