<?php
/**
 * Gestion de la connection entre les sites parents et enfant de DigiRisk.
 *
 * @author    Evarisk <dev@evarisk.com>
 * @copyright (c) 2006-2018 Evarisk <dev@evarisk.com>.
 *
 * @license   AGPLv3 <https://spdx.org/licenses/AGPL-3.0-or-later.html>
 *
 * @package   DigiRisk\Templates
 *
 * @since     7.0.0
 */

namespace digi;

defined( 'ABSPATH' ) || exit; ?>

<div class="wpeo-form">
	<input type="hidden" name="action" value="save_child_settings" />
	<?php wp_nonce_field( 'save_child_settings' ); ?>


	<div class="form-element">
		<label class="form-field-container">
			<div class="form-field-inline">
				<input type="checkbox" id="require_unique_security_id" class="form-field" name="require_unique_security_id" <?php echo $require_unique_security_id ? 'checked' : ''; ?> />
				<label for="require_unique_security_id"><?php esc_html_e( 'Exiger un ID de sécurité unique', 'digirisk' ); ?></label>
			</div>
		</label>
	</div>

	<?php if ( $require_unique_security_id ) : ?>
		<div class="form-element">
			<span class="form-label"><?php esc_html_e( 'Votre URL : ', 'digirisk' ); ?></span>
			<label class="form-field-container">
				<input type="text" class="form-field" readonly value="<?php echo get_site_url(); ?>" />
			</label>
		</div>
		<div class="form-element">
			<span class="form-label"><?php esc_html_e( 'Votre ID de sécurité unique est : ', 'digirisk' ); ?></span>
			<label class="form-field-container">
				<input type="text" class="form-field" readonly value="<?php echo esc_html( $unique_security_id['security_id'] ); ?>" />
			</label>
		</div>
	<?php endif; ?>

	<h4>Mes sites parents</h4>

	<div class="wpeo-table table-flex table-3">
		<div class="table-row table-header">
			<div class="table-cell">#</div>
			<div class="table-cell">URL</div>
			<div class="table-cell table-end">Action</div>
		</div>

		<?php
		if ( ! empty( $parent_sites ) ) :
			foreach ( $parent_sites as $key => $parent_site ) :
				?>
				<div class="table-row">
					<div class="table-cell"><?php echo esc_html( $key ); ?></div>
					<div class="table-cell"><?php echo esc_html( $parent_site['url_parent'] ); ?></div>
					<div class="table-cell table-end">
						<div class="wpeo-button button-square-40 button-transparent delete action-delete"
							data-id="<?php echo esc_attr( $key ); ?>"
							data-action="delete_child_parent"
							data-nonce="<?php echo wp_create_nonce( 'delete_child_parent' ); ?>"
							data-message-delete="Êtes-vous sûr(e) de vouloir supprimer ce site ?"><i class="button-icon fas fa-times"></i></div>
					</div>
				</div>
				<?php
			endforeach;
		endif;
		?>
	</div>


	<div class="wpeo-button button-main action-input" data-parent="wpeo-form">
		<span><?php esc_html_e( 'Enregistrer les modifications', 'digirisk' ); ?></span>
	</div>
</div>
