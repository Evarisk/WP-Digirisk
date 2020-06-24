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

<?php if( isset( $new_line ) && $new_line ): ?>
	<div class="table-row intervention-row edit unite-de-travail-class new-line-intervention" data-id="<?php echo esc_attr( $prevention->data['id'] ); ?>" style="display : none">
<?php else: ?>
	<div class="table-row intervention-row edit unite-de-travail-class" data-id="<?php echo esc_attr( $prevention->data['id'] ); ?>">
<?php endif; ?>
	<?php if ( isset( $intervention ) ) : ?>
		<input type="hidden" name="unite-travail-hidden" class="form-field" value="<?php echo esc_attr( $intervention->data[ 'unite_travail' ] ); ?>">
	<?php endif; ?>
	<div class="table-cell table-100" data-title="<?php esc_html_e( 'IdRPP', 'digirisk' ); ?>">
		<?php if ( isset( $intervention ) ) : ?>
			<?php echo esc_attr( $intervention->data['key_unique'] ); ?>
		<?php else: ?>
			-
		<?php endif; ?>
	</div>
	<div class="table-cell table-150 unite-de-travail-element" data-title="<?php esc_html_e( 'Unité de travail', 'digirisk' ); ?>">
		<div class="wpeo-form">
			<div class="form-element">
				<?php
				$name_unite = '';
				if ( ! empty( $intervention->data ) ) {
					$post       = get_post( $intervention->data['unite_travail'] );
					$unique     = get_post_meta( $intervention->data['unite_travail'], '_wpdigi_unique_identifier', true );
					$name_unite = $unique . ' - ' . $post->post_title;
				}
				$eo_search->display( 'accident_post', $name_unite );
				?>
			</div>
		</div>
	</div>
	<div class="table-cell" data-title="Description des actions">
		<div class="wpeo-form">
			<div class="form-element">
				<label class="form-field-container">
					<?php if( isset( $intervention ) ): ?>
						<input type="text" name="description-des-actions" class="form-field" value="<?php echo esc_attr( $intervention->data[ 'action_realise' ] ); ?>">
					<?php else: ?>
						<input type="text" name="description-des-actions" class="form-field">
					<?php endif; ?>
				</label>
			</div>
		</div>
	</div>
	<div class="table-cell table-50" data-title="Risque"> <!-- class="w50" -->
		<div class="wpeo-form risque-element">
			<div class="form-element">
				<div class="form-field-container">
					<?php if( isset( $intervention ) ): ?>
						<?php do_shortcode( '[digi_dropdown_categories_risk id="' . $intervention->data['id'] . '" type="causerie" display="edit" category_risk_id="' . $intervention->data[ 'risk' ] . '"]' ); ?>
					<?php else: ?>
						<?php do_shortcode( '[digi_dropdown_categories_risk id="0" type="causerie" display="edit" preset="0"]' ); ?>
					<?php endif; ?>
				</div>
			</div>
		</div>
	</div>
	<div class="table-cell table-200" data-title="Moyen de prévention">
		<div class="wpeo-form">
			<div class="form-element">
				<label class="form-field-container">
					<?php if( isset( $intervention ) ): ?>
						<input type="text" name="moyen-de-prevention" class="form-field" value="<?php echo esc_attr( $intervention->data[ 'moyen_prevention' ] ); ?>">
					<?php else: ?>
						<input type="text" name="moyen-de-prevention" class="form-field">
					<?php endif; ?>
				</label>
			</div>
		</div>
	</div>
	<div class="table-cell table-150 table-end" data-title="action">
		<div class="intervention-action">
			<div class="wpeo-button button-square-50 <?php echo ( isset( $intervention ) ) ? 'button-green' : ''; ?> button-add-row-intervention <?php echo ( ! empty( $intervention->data['id'] ) ) ? '' : 'button-disable'; ?>"
			data-parentid="<?php echo esc_attr( $prevention->data[ 'id' ] ); ?>"
			data-id="<?php echo esc_attr( isset( $intervention ) ? $intervention->data[ 'id' ] : 0 ); ?>"
			data-action="<?php echo esc_attr( 'add_intervention_line' ); ?>"
			data-nonce="<?php echo esc_attr( wp_create_nonce( 'add_intervention_line' ) ); ?>">
			<?php if( isset( $intervention ) ): ?>
				<span><i class="fas fa-save"></i></span>
			<?php else: ?>
				<span><i class="fas fa-plus"></i></span>
			<?php endif; ?>
			</div>
		</div>
	</div>
</div>
