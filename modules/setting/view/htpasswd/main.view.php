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
} ?>

<div class="section-htpasswd">
	<input type="hidden" name="action" value="save_htpasswd" />
	<?php wp_nonce_field( 'save_htpasswd' ); ?>

	<h3><?php esc_html_e( 'Gestion des identifiants d\'accès à DigiRisk', 'digirisk' ); ?></h3>

	<div class="wpeo-notice notice-error">
		<div class="notice-content">
			<div class="notice-title"><?php esc_html_e( 'A lire avant de continuer', 'digirisk' ); ?></div>
			<div class="notice-subtitle">
				<ul>
				<?php
				if ( ! empty( $notices ) ) {
					foreach ( $notices as $notice ) {
						?>
						<li><?php echo esc_html( $notice ); ?></li>
						<?php
					}
				}
				?>
			</ul>
			</div>
		</div>
		<div class="notice-close"><i class="fas fa-times"></i></div>
	</div>

	<?php
	if ( ! empty( $error_message ) ) :
		?>
		<div class="wpeo-notice notice-error">
			<div class="notice-content">
				<div class="notice-title"><?php esc_html_e( 'Erreur dans le formulaire', 'digirisk' ); ?></div>
				<div class="notice-subtitle"><?php echo esc_html( $error_message ); ?></div>
			</div>
			<div class="notice-close"><i class="fas fa-times"></i></div>
		</div>
		<?php
	endif;
	?>

	<div class="wpeo-form">
		<div class="form-element form-element-disable">
			<span class="form-label">Chemin passwd</span>
			<label class="form-field-container">
				<input type="text" class="form-field" value="<?php echo esc_attr( $htpasswd_path ); ?>" />
			</label>
		</div>

		<div class="form-element">
			<span class="form-label">Identifiant</span>
			<label class="form-field-container">
				<input type="text" name="login" class="form-field" value="<?php echo esc_attr( $login ); ?>" />
			</label>
		</div>

		<div class="form-element">
			<span class="form-label">Password</span>
			<label class="form-field-container">
				<input type="password" name="password" class="form-field" />
			</label>
		</div>

		<div class="form-element">
			<span class="form-label">Repeat Password</span>
			<label class="form-field-container">
				<input type="password" name="repeat_password" class="form-field" />
			</label>
		</div>
	</div>

	<div class="alignright action-input wpeo-button button-blue button-disable" data-parent="section-htpasswd"><span><?php esc_html_e( 'Enregistrer', 'digirisk' ); ?></span></div>
</div>
