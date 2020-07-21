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

global $eo_search;
?>

<div class="" style="background-color: #fff; padding: 1em;">

	<h2 style="text-align : center">
		<?php esc_html_e( 'Informations sur le permis de feu', 'digirisk' ); ?>
		<span class="wpeo-tooltip-event"
		aria-label="<?php esc_html_e( 'Information primaire du permis de feu', 'digirisk' ); ?>"
		style="color : dodgerblue; cursor : pointer">
			<i class="fas fa-info-circle"></i>
		</span>
	</h2>
	<section class="wpeo-gridlayout padding grid-2">
		<div class="wpeo-gridlayout padding grid-1">
			<div class="wpeo-form">
				<div class="form-element">
					<span class="form-label"><?php esc_html_e( 'Titre', 'digirisk' ); ?></span>
					<label class="form-field-container">
						<span class="form-field-icon-prev"><i class="fas fa-globe-americas"></i></span>
						<input type="text" name="permis_feu-title" class="form-field" value="<?php echo esc_attr( $permis_feu->data[ 'title' ] ); ?>">
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
						value="<?php echo esc_attr( date( 'Y-m-d', strtotime( $permis_feu->data[ 'date_start' ][ 'raw' ] ) ) ); ?>">
						<input type="text" class="form-field date"
						value="<?php echo esc_attr( date( 'd/m/Y', strtotime( $permis_feu->data[ 'date_start' ][ 'raw' ] ) ) ); ?>">
					</label>
				</div>
			</div>

			<div class="wpeo-form end-date-element">
				<input type="hidden" name="date_end__is_define" value="<?php echo esc_attr( $permis_feu->data[ 'date_end__is_define' ] ); ?>">
				<?php if( $permis_feu->data[ 'date_end__is_define' ] == "defined" ): ?>
					<div class="form-element group-date">
				<?php else: ?>
					<div class="form-element group-date form-element-disable">
				<?php endif; ?>
					<span style="display : flex">
						<span class="form-label">
							<?php esc_html_e( 'Fin d\'intervention', 'digirisk' ); ?>
						</span>
						<div class="" style="margin-left: 2%; display: flex;">
							<?php if( $permis_feu->data[ 'date_end__is_define' ] == "defined" ): ?>
								<div class="wpeo-button button-blue action-button-end-date button-radius-3 button-permis-feu-title" data-action="defined">
									<span><?php esc_html_e( 'Défini', 'digirisk' ); ?></span>
								</div>
								<div class="wpeo-button button-grey action-button-end-date button-radius-3 button-permis-feu-title" style="margin-left: 5px;" data-action="undefined">
									<span><?php esc_html_e( 'Sans limite', 'digirisk' ); ?></span>
								</div>
							<?php else: ?>
								<div class="wpeo-button button-grey action-button-end-date button-radius-3 button-permis-feu-title" data-action="defined">
									<span><?php esc_html_e( 'Défini', 'digirisk' ); ?></span>
								</div>
								<div class="wpeo-button button-blue action-button-end-date button-radius-3 button-permis-feu-title" style="margin-left: 5px;" data-action="undefined">
									<span><?php esc_html_e( 'Sans limite', 'digirisk' ); ?></span>
								</div>
							<?php endif; ?>
						</div>
					</span>

					<?php if( $permis_feu->data[ 'date_end__is_define' ] == "defined" ): ?>
						<label class="form-field-container">
							<span class="form-field-icon-prev"><i class="fas fa-calendar-alt"></i></span>
							<input type="text" class="mysql-date" name="end_date" value="<?php echo esc_attr( date( 'Y-m-d', strtotime( $permis_feu->data[ 'date_end' ][ 'raw' ] ) ) ); ?>">
							<input type="text" class="form-field date" value="<?php echo esc_attr( date( 'd/m/Y', strtotime( $permis_feu->data[ 'date_end' ][ 'raw' ] ) ) ); ?>">
						</label>
					<?php else: ?>
						<label class="form-field-container">
							<span class="form-field-icon-prev"><i class="fas fa-calendar-alt"></i></span>
							<input type="text" class="mysql-date" name="end_date" value="<?php echo esc_attr( date( 'Y-m-d', strtotime( $permis_feu->data[ 'date_start' ][ 'raw' ] ) + 86400 ) ); ?>">
							<input type="text" class="form-field date" value="<?php echo esc_attr( date( 'd/m/Y', strtotime( $permis_feu->data[ 'date_start' ][ 'raw' ] ) + 86400 ) ); ?>">
						</label>
					<?php endif; ?>
				</div>
			</div>
		</div>
	</section>
	<section class="wpeo-gridlayout padding grid-2">
		<?php
			Permis_Feu_Class::g()->display_prevention( $permis_feu );
		?>
	</section>

	<div class="intervention-prevention-plan">
	<?php if( $permis_feu->data['prevention_id'] != 0 ):  ?>
			<?php
				\eoxia\View_Util::exec( 'digirisk', 'permis_feu', 'start/step-2-intervention-prevention-plan', array(
					'id' => $permis_feu->data['prevention_id'],
					'edit' => false
				) );
			 ?>
	<?php endif; ?>
	</div>


	<div class="intervention-table" style="margin-top: 30px">
		<span style="text-align : center">
			<h2>
				<?php esc_html_e( 'Intervention par points chauds', 'digirisk' ); ?>
				<span class="wpeo-tooltip-event"
				aria-label="<?php esc_html_e( 'Listes des interventions associées aux types de travaux', 'digirisk' ); ?>"
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
		<div class="intervention-content">
			<?php
				Permis_Feu_Intervention_Class::g()->display_intervention_table( $permis_feu->data[ 'id' ] );
			?>
		</div>
	</div>

</div>

<style>
.button-permis-feu-title{
	padding-top: 2px;
	margin-bottom: 2px;
	padding-bottom: 2px;
}

.button-icon{
	color: white;
}
</style>
