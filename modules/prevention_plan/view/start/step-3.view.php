<?php
/**
 * Etape du liste des intervenants
 *
 * @author    Evarisk <dev@evarisk.com>
 * @since     6.6.0
 * @version   6.6.0
 * @copyright 2019 Evarisk.
 * @package   DigiRisk
 */

namespace digi;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
} ?>

<?php
	$legal_display = Legal_Display_Class::g()->get( array(
		'posts_per_page' => 1
	), true );

	if ( empty( $legal_display ) ) {
		$legal_display = Legal_Display_Class::g()->get( array(
			'schema' => true,
		), true );
	}
?>
<div class="information-society" style="background-color: #fff; padding: 1em;">
	<h2 style="text-align:center">
		<?php esc_html_e( 'Information société extérieur', 'digirisk' ); ?>
		<span class="wpeo-tooltip-event"
		aria-label="<?php esc_html_e( 'Information de la société intervenante', 'digirisk' ); ?>"
		style="color : dodgerblue; cursor : pointer">
			<i class="fas fa-info-circle"></i>
		</span>
	</h2>
	<section class="wpeo-gridlayout padding grid-2" style="margin-bottom: 10px;">
		<section class="wpeo-gridlayout padding grid-2" style="margin-bottom: 10px;">
			<div class="wpeo-form">
				<div class="form-element">
					<span class="form-label"><?php esc_html_e( 'Nom de l\'entreprise', 'digirisk' ); ?></span>
					<label class="form-field-container">
						<span class="form-field-icon-prev"><i class="far fa-building"></i></span>
						<input type="text" class="form-field" name="outisde_name" value="<?php echo esc_attr( $prevention->data[ 'society_outside_name' ] ); ?>">
					</label>
				</div>
			</div>

			<div class="wpeo-form">
				<div class="form-element">
					<span class="form-label"><?php esc_html_e( 'Numero Siret', 'digirisk' ); ?></span>
					<label class="form-field-container">
						<span class="form-field-icon-prev"><i class="fas fa-barcode"></i></span>
						<input type="text" class="form-field" name="outside_siret" value="<?php echo esc_attr( $prevention->data[ 'society_outside_siret' ] ); ?>">
					</label>
				</div>
			</div>
		</section>
	</section>

	<div class="information-intervenant-exterieur" style="">
		<input type="hidden" name="user-type" value="intervenant_exterieur">
		<h2 style="text-align:center">
			<?php esc_html_e( 'Responsable des intervenants extérieur', 'digirisk' ); ?>
			<span class="wpeo-tooltip-event"
			aria-label="<?php esc_html_e( 'Responsable de la société intervenante', 'digirisk' ); ?>"
			style="color : dodgerblue; cursor : pointer">
				<i class="fas fa-info-circle"></i>
			</span>
		</h2>
		<?php Prevention_Class::g()->display_intervenant_exterieur( array(), $prevention->data[ 'id' ] ); ?>
	</div>

	<h2 style="text-align:center">
		<?php esc_html_e( 'Informations complémentaires', 'digirisk' ); ?>
		<span class="wpeo-tooltip-event"
		aria-label="<?php esc_html_e( 'Ces informations ont été définies dans l\'affichage légal de Digirisk', 'digirisk' ); ?>"
		style="color : dodgerblue; cursor : pointer">
			<i class="fas fa-info-circle"></i>
		</span>
	</h2>
	<section class="wpeo-gridlayout padding grid-4 information-element-society" style="margin-bottom: 10px;">

		<div class="wpeo-form">
			<div class="form-element form-element-disable">
				<span class="form-label"><?php esc_html_e( 'Numéro SAMU', 'digirisk' ); ?></span>
				<label class="form-field-container">
					<span class="form-field-icon-prev"><i class="fas fa-mobile"></i></span>
					<?php if( ! empty( $society ) ): ?>
						<input type="text" class="form-field" value="<?php echo esc_attr( $legal_display->data[ 'emergency_service' ][ 'samu' ] ); ?>">
					<?php else: ?>
						<input type="text" class="form-field" value="">
					<?php endif; ?>
				</label>
			</div>
		</div>

		<div class="wpeo-form">
			<div class="form-element form-element-disable">
				<span class="form-label"><?php esc_html_e( 'Numéro Police', 'digirisk' ); ?></span>
				<label class="form-field-container">
					<span class="form-field-icon-prev"><i class="fas fa-car"></i></span>
					<?php if( ! empty( $society ) ): ?>
						<input type="text" class="form-field" value="<?php echo esc_attr( $legal_display->data[ 'emergency_service' ][ 'police' ] ); ?>">
					<?php else: ?>
						<input type="text" class="form-field" value="">
					<?php endif; ?>
				</label>
			</div>
		</div>

		<div class="wpeo-form">
			<div class="form-element form-element-disable">
				<span class="form-label"><?php esc_html_e( 'Numéro Pompier', 'digirisk' ); ?></span>
				<label class="form-field-container">
					<span class="form-field-icon-prev"><i class="fas fa-fire-extinguisher"></i></span>
					<?php if( ! empty( $society ) ): ?>
						<input type="text" class="form-field" value="<?php echo esc_attr( $legal_display->data[ 'emergency_service' ][ 'pompier' ] ); ?>">
					<?php else: ?>
						<input type="text" class="form-field" value="">
					<?php endif; ?>
				</label>
			</div>
		</div>

		<div class="wpeo-form">
			<div class="form-element form-element-disable">
				<span class="form-label"><?php esc_html_e( 'Numéro Urgence', 'digirisk' ); ?></span>
				<label class="form-field-container">
					<span class="form-field-icon-prev"><i class="fas fa-heartbeat"></i></span>
					<?php if( ! empty( $society ) ): ?>
						<input type="text" class="form-field" value="<?php echo esc_attr( $legal_display->data[ 'emergency_service' ][ 'emergency' ] ); ?>">
					<?php else: ?>
						<input type="text" class="form-field" value="">
					<?php endif; ?>
				</label>
			</div>
		</div>
	</section>
</div>

<?php if( Prevention_Class::g()->intervenant_is_valid( $prevention->data[ 'intervenant_exterieur' ] ) ): ?>
	<div class="wpeo-button button-blue action-input wpeo-tooltip-event go-to-last-step-prevention"
<?php else: ?>
	<div class="wpeo-button button-blue button-disable action-input wpeo-tooltip-event go-to-last-step-prevention"
<?php endif; ?>
		data-action="next_step_prevention"
		data-parent="digi-prevention-parent"
		data-nonce="<?php echo esc_attr( wp_create_nonce( 'next_step_prevention' ) ); ?>"
		data-id="<?php echo esc_attr( $prevention->data['id'] ); ?>"
		aria-label="<?php esc_html_e( 'Prochaine étape', 'digirisk' ); ?>"
		style="float:right; margin-top: 10px">
		<span>
			<?php esc_html_e( 'Continuer', 'digirisk' ); ?>
			<i class="fas fa-long-arrow-alt-right"></i>
		</span>
	</div>
