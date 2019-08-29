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
	<h2 style="text-align:center"><?php esc_html_e( 'Information société extérieur et sur les intervenants', 'digirisk' ); ?></h2>
	<section class="wpeo-gridlayout padding grid-2" style="margin-bottom: 10px;">
		<section class="wpeo-gridlayout padding grid-2" style="margin-bottom: 10px;">
			<div class="wpeo-form">
				<div class="form-element form-element-disable">
					<span class="form-label"><?php esc_html_e( 'Nom de l\'entreprise', 'digirisk' ); ?></span>
					<label class="form-field-container">
						<?php if( ! empty( $society ) ): ?>
							<input type="text" class="form-field" value="<?php echo esc_attr( $society->data[ 'title' ] ); ?>">
						<?php else: ?>
							<input type="text" class="form-field" value="">
						<?php endif; ?>
					</label>
				</div>
			</div>

			<div class="wpeo-form">
				<div class="form-element form-element-disable">
					<span class="form-label"><?php esc_html_e( 'Numero Siret', 'digirisk' ); ?></span>
					<label class="form-field-container">
						<span class="form-field-icon-prev"><i class="fas fa-users"></i></span>
						<?php if( ! empty( $society ) ): ?>
							<input type="text" class="form-field" value="<?php echo esc_attr( $society->data[ 'siret_id' ] ); ?>">
						<?php else: ?>
							<input type="text" class="form-field" value="">
						<?php endif; ?>
					</label>
				</div>
			</div>
		</section>

		<section class="wpeo-gridlayout padding grid-3" style="margin-bottom: 10px;">
			<div class="wpeo-form">
				<div class="form-element form-element-disable">
					<span class="form-label"><?php esc_html_e( 'Nom du Responsable', 'digirisk' ); ?></span>
					<label class="form-field-container">
						<?php if( ! empty( $society ) ): ?>
							<input type="text" class="form-field" value="<?php echo esc_attr( $legal_display->data[ 'safety_rule' ][ 'responsible_for_preventing' ] ); ?>">
						<?php else: ?>
							<input type="text" class="form-field" value="">
						<?php endif; ?>
					</label>
				</div>
			</div>

			<div class="wpeo-form">
				<div class="form-element form-element-disable">
					<span class="form-label"><?php esc_html_e( 'Téléphone du Responsable', 'digirisk' ); ?></span>
					<label class="form-field-container">
						<span class="form-field-icon-prev"><i class="fas fa-users"></i></span>
						<?php if( ! empty( $society ) ): ?>
							<input type="text" class="form-field" value="<?php echo esc_attr( $legal_display->data[ 'safety_rule' ][ 'phone' ] ); ?>">
						<?php else: ?>
							<input type="text" class="form-field" value="">
						<?php endif; ?>
					</label>
				</div>
			</div>
			<div class="button-save-information-society" style="display : block">
				<a href="<?php echo admin_url( 'admin.php?page=digirisk-simple-risk-evaluation&society_id=' . $society->data['id'] ); ?>" target="_blank">
					<div class="wpeo-button button-green wpeo-tooltip-event"  style="float : right" aria-label="<?php esc_html_e( 'Modifier les données', 'digirisk' ); ?>">
						<?php // esc_html_e( 'Modifier ces informations', 'digirisk' ); ?>
						<i class="fas fa-external-link-alt"></i>
					</div>
				</a>
			</div>
		</section>

	</section>
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
	<section class="wpeo-gridlayout padding grid-4" style="margin-bottom: 10px;">

		<div class="">
		</div>
		<div class="">
		</div>
		</section>

	 <?php Prevention_Class::g()->display_list_intervenant( $prevention->data['id'] ); ?>
</div>

	<div class="wpeo-button button-blue action-input wpeo-tooltip-event"
		data-action="next_step_prevention"
		data-nonce="<?php echo esc_attr( wp_create_nonce( 'next_step_prevention' ) ); ?>"
		data-id="<?php echo esc_attr( $prevention->data['id'] ); ?>"
		aria-label="<?php esc_html_e( 'Prochaine étape', 'digirisk' ); ?>"
		style="float:right; margin-top: 10px">
		<span><i class="fas fa-long-arrow-alt-right"></i></span>
	</div>
