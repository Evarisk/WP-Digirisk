<?php
/**
 * Affichage principale pour définir les préfix des odt Causeries / Plan de prévention / Permis de feu
 *
 * @author Evarisk <dev@evarisk.com>
 * @since 7.3.5
 * @copyright 2019 Evarisk
 */


 namespace digi;

 if ( ! defined( 'ABSPATH' ) ) {
 	exit;
 } ?>

<div class="table-row">
	<?php   if ( ! isset( $element['element'] ) ) : ?>
		<div class="table-cell">
			<span for="accronym-<?php echo $key; ?>"><?php echo esc_attr( $element['description'] ); ?></span>
		</div>
		<div class="table-cell table-150">
			<input type="text" id="accronym-<?php echo $key; ?>" name="list_accronym[<?php echo $key; ?>][to]" value="<?php echo $element['to']; ?>" />
			<input type="hidden" name="list_accronym[<?php echo $key; ?>][description]" value="<?php echo $element['description']; ?>" />
		</div>
		<?php if ( isset( $element['page'] ) ) : ?>
			<div class="tabl-cell table-50 table-end wpeo-tooltip-event" aria-label="<?php esc_html_e( 'Accéder à la page', 'digirisk' ); ?>" style="text-align: center;">
				<a href="<?php echo esc_attr( $element['page'] ); ?>">
					<div class="wpeo-button button-square-50 button-blue">
						<i class="fas fa-share"></i>
					</div>
				</a>
			</div>
		<?php else : ?>
			<div class="table-cell table-50 table-end"></div>
		<?php endif; ?>
	<?php else : ?>
		<div class="table-cell">
			<span for="accronym-<?php echo $key; ?>"><?php echo esc_attr( $element['description'] ); ?></span>
		</div>
		<div class="table-cell table-150">
			<input type="text" id="accronym-<?php echo $key; ?>" name="list_prefix[<?php echo $element['element']; ?>][to]" value="<?php echo $element['to']; ?>" />
			<input type="hidden" name="list_prefix[<?php echo $key; ?>][description]" value="<?php echo $element['description']; ?>" />
		</div>
		<?php if ( isset( $element['page'] ) ) : ?>
			<div class="table-cell table-50 table-end wpeo-tooltip-event" aria-label="<?php esc_html_e( 'Accéder à la page', 'digirisk' ); ?>" style="text-align: center;">
				<a href="<?php echo esc_attr( $element['page'] ); ?>">
					<div class="wpeo-button button-blue button-square-50">
						<i class="fas fa-share"></i>
					</div>
				</a>
			</div>
		<?php else : ?>
			<div class="table-cell table-50 table-end"></div>
		<?php endif; ?>
	<?php endif; ?>
</div>
