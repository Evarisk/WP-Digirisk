<?php
/**
 * Evaluation d'une causerie: étape 2, permet d'afficher les images associées à la causerie dans un format "slider".
 *
 * @author    Evarisk <dev@evarisk.com>
 * @since     6.6.0
 * @version   6.6.0
 * @copyright 2018 Evarisk.
 * @package   DigiRisk
 */

namespace digi;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
?>

<div class="" style="background-color: #fff; padding: 1em;">

	<h2 style="text-align : center">
		<?php esc_html_e( 'Informations sur le plan de prévention', 'digirisk' ); ?>
		<span class="wpeo-tooltip-event"
		aria-label="<?php esc_html_e( 'Information primaire du plan de prévention', 'task-manager' ); ?>"
		style="color : dodgerblue; cursor : pointer">
			<i class="fas fa-info-circle"></i>
		</span></h2>
	<section class="wpeo-gridlayout padding grid-2">
		<div class="wpeo-gridlayout padding grid-1">
			<div class="wpeo-form">
				<div class="form-element">
					<span style="display : flex">
						<span class="form-label">
							<?php esc_html_e( 'Titre', 'digirisk' ); ?>
						</span>
						<div class="title-information-option" style="margin-left: 2%; display: flex;">
							<input type="hidden" name="more_than_400_hours" value="<?php echo esc_attr( $prevention->data[ 'more_than_400_hours' ] ); ?>">
							<input type="hidden" name="imminent_danger" value="<?php echo esc_attr( $prevention->data[ 'imminent_danger' ] ); ?>">
							<?php if( $prevention->data[ 'more_than_400_hours' ] ): ?>
								<div class="wpeo-button button-blue action-button-title button-radius-3 button-prevention-title" data-type="more_than_400_hours">
									<span>
										<i class="button-icon fas fa-check-square"></i>
										<?php esc_html_e( 'Plus de 400 heures', 'digirisk' ); ?>
									</span>
								</div>
							<?php else: ?>
								<div class="wpeo-button button-grey action-button-title button-radius-3 button-prevention-title" data-type="more_than_400_hours">
									<span>
										<i class="button-icon fas fa-square"></i>
										<?php esc_html_e( 'Plus de 400 heures', 'digirisk' ); ?>
									</span>
								</div>
							<?php endif; ?>
							<?php if( $prevention->data[ 'imminent_danger' ] ): ?>
								<div class="wpeo-button button-blue action-button-title button-radius-3 button-prevention-title" data-type="imminent_danger" style="margin-left : 5px">
									<span>
										<i class="button-icon fas fa-check-square"></i>
										<?php esc_html_e( 'Danger grave et imminent', 'digirisk' ); ?>
									</span>
								</div>
							<?php else: ?>
								<div class="wpeo-button button-grey action-button-title button-radius-3 button-prevention-title" data-type="imminent_danger" style="margin-left : 5px">
									<span>
										<i class="button-icon fas fa-square"></i>
										<?php esc_html_e( 'Danger grave et imminent', 'digirisk' ); ?>
									</span>
								</div>
							<?php endif; ?>
						</div>
					</span>
					<label class="form-field-container">
						<input type="text" name="prevention-title" class="form-field" value="<?php echo esc_attr( $prevention->data[ 'title' ] ); ?>">
					</label>
				</div>
			</div>
		</div>
		<div class="wpeo-gridlayout padding grid-2">
			<div class="wpeo-form">
				<div class="form-element group-date">
					<span class="form-label"><?php esc_html_e( 'Début d\'intervention', 'digirisk' ); ?></span>
					<label class="form-field-container">
						<span class="form-field-icon-prev"><i class="fas fa-calendar-alt"></i></span>
						<input type="text" class="mysql-date" name="start_date"
						value="<?php echo esc_attr( date( 'Y-m-d', strtotime( $prevention->data[ 'date_start' ][ 'raw' ] ) ) ); ?>">
						<input type="text" class="form-field date"
						value="<?php echo esc_attr( date( 'd/m/Y', strtotime( $prevention->data[ 'date_start' ][ 'raw' ] ) ) ); ?>">
					</label>
				</div>
			</div>

			<div class="wpeo-form end-date-element">
				<input type="hidden" name="date_end__is_define" value="defined">
				<?php if( $prevention->data[ 'date_end__is_define' ] == "define" ): ?>
					<div class="form-element group-date">
				<?php else: ?>
					<div class="form-element group-date form-element-disable">
				<?php endif; ?>
					<span style="display : flex">
						<span class="form-label">
							<?php esc_html_e( 'Fin d\'intervention', 'digirisk' ); ?>
						</span>
						<div class="" style="margin-left: 2%; display: flex;">
							<?php if( $prevention->data[ 'date_end__is_define' ] == "define" ): ?>
								<div class="wpeo-button button-blue action-button-end-date button-radius-3 button-prevention-title" data-action="defined">
									<span><?php esc_html_e( 'Défini', 'digirisk' ); ?></span>
								</div>
								<div class="wpeo-button button-grey action-button-end-date button-radius-3 button-prevention-title" style="margin-left: 5px;" data-action="undefined">
									<span><?php esc_html_e( 'En cours', 'digirisk' ); ?></span>
								</div>
							<?php else: ?>
								<div class="wpeo-button button-grey action-button-end-date button-radius-3 button-prevention-title" data-action="defined">
									<span><?php esc_html_e( 'Défini', 'digirisk' ); ?></span>
								</div>
								<div class="wpeo-button button-blue action-button-end-date button-radius-3 button-prevention-title" style="margin-left: 5px;" data-action="undefined">
									<span><?php esc_html_e( 'En cours', 'digirisk' ); ?></span>
								</div>
							<?php endif; ?>
						</div>
					</span>

					<label class="form-field-container">
							<span class="form-field-icon-prev"><i class="fas fa-calendar-alt"></i></span>
							<input type="text" class="mysql-date" name="end_date" value="<?php echo esc_attr( date( 'Y-m-d', strtotime( $prevention->data[ 'date_start' ][ 'raw' ] ) + 86400 ) ); ?>">
							<input type="text" class="form-field date" value="<?php echo esc_attr( date( 'd/m/Y', strtotime( $prevention->data[ 'date_start' ][ 'raw' ] ) + 86400 ) ); ?>">
					</label>
				</div>
			</div>
		</div>
	</section>
	<div class="intervention-table" style="margin-top: 20px">
		<?php
			Prevention_Intervention_Class::g()->display_table( $prevention->data[ 'id' ] );
		?>
	</div>

</div>

<div class="wpeo-button button-blue action-input"
	data-action="next_step_prevention"
	data-nonce="<?php echo esc_attr( wp_create_nonce( 'next_step_prevention' ) ); ?>"
	data-id="<?php echo esc_attr( $prevention->data['id'] ); ?>"
	data-parent="digi-prevention-parent"
	style="float:right; margin-top: 10px">
	<span>
		<?php esc_html_e( 'Valider', 'digirisk' ); ?>
		<i class="fas fa-long-arrow-alt-right"></i>
	</span>
</div>

<style>
.button-prevention-title{
	padding-top: 2px;
	margin-bottom: 2px;
	padding-bottom: 2px;
}

.button-icon{
	color: white;
}
</style>
