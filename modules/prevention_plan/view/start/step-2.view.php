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

	<h2 style="text-align : center"><?php esc_html_e( 'Informations sur le plan de prévention', 'digirisk' ); ?></h2>
	<section class="wpeo-gridlayout padding grid-2">
		<div class="wpeo-gridlayout padding grid-1">
			<div class="wpeo-form">
				<div class="form-element">
					<span class="form-label"><?php esc_html_e( 'Titre', 'digirisk' ); ?></span>
					<label class="form-field-container">
						<input type="text" name="prevention-title" class="form-field" value="<?php echo esc_attr( $prevention->data[ 'title' ] ); ?>">
					</label>
				</div>
			</div>
		</div>
		<div class="wpeo-gridlayout padding grid-2">
			<div class="wpeo-form">
				<div class="form-element group-date">
					<span class="form-label"><?php esc_html_e( 'Date début', 'digirisk' ); ?></span>
					<label class="form-field-container">
						<span class="form-field-icon-prev"><i class="fas fa-calendar-alt"></i></span>
						<input type="text" class="mysql-date" name="start_date"
						value="<?php echo esc_attr( date( 'Y-m-d', strtotime( $prevention->data[ 'date_start' ][ 'raw' ] ) ) ); ?>">
						<input type="text" class="form-field date"
						value="<?php echo esc_attr( date( 'd/m/Y', strtotime( $prevention->data[ 'date_start' ][ 'raw' ] ) ) ); ?>" disabled>
					</label>
				</div>
			</div>

			<div class="wpeo-form">
				<div class="form-element group-date">
					<span class="form-label"><?php esc_html_e( 'Date fin', 'digirisk' ); ?></span>
					<label class="form-field-container">
						<?php if( $prevention->data[ 'date_end_exist' ] ): ?>
							<span class="form-field-icon-prev"><i class="fas fa-calendar-alt"></i></span>
							<input type="text" class="mysql-date" name="end_date"
							value="<?php echo esc_attr( date( 'd-m-Y', strtotime( $prevention->data[ 'date_end' ][ 'raw' ] ) ) ); ?>">
							<input type="text" class="form-field date"
							value="<?php echo esc_attr( date( 'd/m/Y', strtotime( $prevention->data[ 'date_end' ][ 'raw' ] ) ) ); ?>">
						<?php else: ?>
							<span class="form-field-icon-prev"><i class="fas fa-calendar-alt"></i></span>
							<input type="text" class="mysql-date" name="end_date">
							<input type="text" class="form-field date">
						<?php endif; ?>
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
	data-parent="digi-prenvention-parent"
	style="float:right; margin-top: 10px">
	<span>
		<?php esc_html_e( 'Valider', 'digirisk' ); ?>
		<i class="fas fa-long-arrow-alt-right"></i>
	</span>
</div>
