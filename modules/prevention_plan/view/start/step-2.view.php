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

	<h2>
		<?php esc_html_e( 'Informations sur le plan de prévention', 'digirisk' ); ?>
		<span class="wpeo-tooltip-event"
		aria-label="<?php esc_html_e( 'Information primaire du plan de prévention', 'digirisk' ); ?>"
		style="color : dodgerblue; cursor : pointer">
			<i class="fas fa-info-circle"></i>
		</span>
	</h2>
	<section class="wpeo-gridlayout padding grid-3">
		<div class="wpeo-form">
			<div class="form-element">
				<span style="display : flex">
					<span class="form-label">
						<?php esc_html_e( 'Titre', 'digirisk' ); ?>
					</span>
				</span>
				<label class="form-field-container">
					<input type="text" name="prevention-title" class="form-field" value="<?php echo esc_attr( $prevention->data[ 'title' ] ); ?>">
				</label>
			</div>
		</div>
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
				<input type="hidden" name="date_end__is_define" value="<?php echo esc_attr( $prevention->data[ 'date_end__is_define' ] ); ?>">
				<?php if( $prevention->data[ 'date_end__is_define' ] == "defined" ): ?>
					<div class="form-element group-date">
				<?php else: ?>
					<div class="form-element group-date form-element-disable">
				<?php endif; ?>
					<span style="display : flex">
						<span class="form-label">
							<?php esc_html_e( 'Fin d\'intervention', 'digirisk' ); ?>
						</span>
						<div class="" style="margin-left: 2%; display: flex;">
							<?php if( $prevention->data[ 'date_end__is_define' ] == "defined" ): ?>
								<div class="wpeo-button button-blue action-button-end-date button-radius-3 button-prevention-title" data-action="defined">
									<span><?php esc_html_e( 'Défini', 'digirisk' ); ?></span>
								</div>
								<div class="wpeo-button button-grey action-button-end-date button-radius-3 button-prevention-title" style="margin-left: 5px;" data-action="undefined">
									<span><?php esc_html_e( 'Sans limite', 'digirisk' ); ?></span>
								</div>
							<?php else: ?>
								<div class="wpeo-button button-grey action-button-end-date button-radius-3 button-prevention-title" data-action="defined">
									<span><?php esc_html_e( 'Défini', 'digirisk' ); ?></span>
								</div>
								<div class="wpeo-button button-blue action-button-end-date button-radius-3 button-prevention-title" style="margin-left: 5px;" data-action="undefined">
									<span><?php esc_html_e( 'Sans limite', 'digirisk' ); ?></span>
								</div>
							<?php endif; ?>
						</div>
					</span>

					<?php if( $prevention->data[ 'date_end__is_define' ] == "defined" ): ?>
						<label class="form-field-container">
							<span class="form-field-icon-prev"><i class="fas fa-calendar-alt"></i></span>
							<input type="text" class="mysql-date" name="end_date" value="<?php echo esc_attr( date( 'Y-m-d', strtotime( $prevention->data[ 'date_end' ][ 'raw' ] ) ) ); ?>">
							<input type="text" class="form-field date" value="<?php echo esc_attr( date( 'd/m/Y', strtotime( $prevention->data[ 'date_end' ][ 'raw' ] ) ) ); ?>">
						</label>
					<?php else: ?>
						<label class="form-field-container">
							<span class="form-field-icon-prev"><i class="fas fa-calendar-alt"></i></span>
							<input type="text" class="mysql-date" name="end_date" value="<?php echo esc_attr( date( 'Y-m-d', strtotime( $prevention->data[ 'date_start' ][ 'raw' ] ) + 86400 ) ); ?>">
							<input type="text" class="form-field date" value="<?php echo esc_attr( date( 'd/m/Y', strtotime( $prevention->data[ 'date_start' ][ 'raw' ] ) + 86400 ) ); ?>">
						</label>
					<?php endif; ?>
				</div>
			</div>
	</section>
	<div class="intervention-table" style="margin-top: 30px">
		<span>
			<h2>
				<?php esc_html_e( 'Intervention', 'digirisk' ); ?>
				<span class="wpeo-tooltip-event"
				aria-label="<?php esc_html_e( 'Listes des interventions associées aux risques', 'digirisk' ); ?>"
				style="color : dodgerblue; cursor : pointer">
					<i class="fas fa-info-circle"></i>
				</span>
				<a class="page-title-action wpeo-tooltip-event display-line-intervention"
				 aria-label="<?php esc_html_e( 'Ajouter une intervention', 'digirisk' ); ?>"
				 style="margin-left: 5px; height: 100%; margin-top: 24px;">
					<?php esc_html_e( 'Nouveau', 'digirisk' ); ?>
				</a>
			</h2>
		</span>

		<div class="title-information-option" style="display: flex;">
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

		<div class="intervention-content">

			<?php
				Prevention_Intervention_Class::g()->display_table( $prevention->data[ 'id' ] );
			?>
		</div>
	</div>
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
