<?php
/**
 * Gestion des réglages générales de DigiRisk.
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
	<input type="hidden" name="action" value="save_general_settings_digirisk" />
	<?php wp_nonce_field( 'save_general_settings_digirisk' ); ?>

	<div class="form-element">
		<span class="form-label"><?php esc_html_e( 'Domaine de l\'email', 'digirisk' ); ?></span>

		<label class="form-field-container">
			<input type="text" name="domain_mail" class="form-field" value="<?php echo esc_attr( get_option( 'digirisk_domain_mail', 'demo.com' ) ); ?>" />
		</label>
	</div>

	<div class="form-element">
		<span class="form-label"><?php esc_html_e( 'Nombre de jour obligatoire pour le DUER', 'digirisk' ); ?></span>

		<label class="form-field-container">
			<input type="text" name="general_options[required_duer_day]" class="form-field" value="<?php echo esc_attr( $general_options['required_duer_day'] ); ?>" />
		</label>
	</div>


	<div class="form-element">
		<label class="form-field-container">
			<div class="form-field-inline">
				<input type="checkbox" id="edit_risk_category" class="form-field" name="edit_risk_category" <?php echo $can_edit_risk_category ? 'checked' : ''; ?> />
				<label for="edit_risk_category"><?php esc_html_e( 'Autoriser la modification des catégories de risques', 'digirisk' ); ?></label>
			</div>
		</label>
	</div>

	<div class="form-element">
		<label class="form-field-container">
			<div class="form-field-inline">
				<input type="checkbox" id="edit_type_cotation" class="form-field" name="edit_type_cotation" <?php echo $can_edit_type_cotation ? 'checked' : ''; ?> />
				<label for="edit_type_cotation"><?php esc_html_e( 'Autoriser la modification des types de cotation', 'digirisk' ); ?></label>
			</div>
		</label>
	</div>

	<div class="form-element">
		<label class="form-field-container">
			<div class="form-field-inline">
				<input type="checkbox" id="require_unique_security_id" class="form-field" name="require_unique_security_id" <?php echo $require_unique_security_id ? 'checked' : ''; ?> />
				<label for="require_unique_security_id"><?php esc_html_e( 'Exiger un ID de sécurité unique', 'digirisk' ); ?></label>
			</div>
		</label>
	</div>

	<?php if ( $require_unique_security_id ) : ?>
		<h3>
			<ul>
				<li>
					<?php esc_html_e( 'Votre URL', 'digirisk' ); ?>
					<span><?php echo get_site_url(); ?></span>
				</li>

				<li>
					<?php esc_html_e( 'Votre ID de sécurité unique est : ', 'digirisk' ); ?>
					<span><?php echo esc_html( $unique_security_id['security_id'] ); ?></span>
				</li>
			</ul>
		</h3>
	<?php endif; ?>

	<?php
	if ( ! empty( $sites ) ) :
		?>
		<h4>Mes sites parents</h4>

		<ul>
			<?php
			foreach ( $sites as $site ) :
				?>
				<li><?php echo esc_html( $site['url_parent'] ); ?></li>
				<?php
			endforeach;
			?>
		</ul>
		<?php
	endif;
	?>

	<div class="wpeo-button button-main action-input" data-parent="wpeo-form">
		<span><?php esc_html_e( 'Enregistrer les modifications', 'digirisk' ); ?></span>
	</div>
</div>
