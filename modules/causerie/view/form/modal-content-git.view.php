<?php
/**
 * La vue d'une tâche dans le backend.
 *
 * @author Eoxia <dev@eoxia.com>
 * @since 1.7.0
 * @version 1.7.0
 * @copyright 2015-2018 Eoxia
 * @package Task_Manager\Import
 */

namespace digi;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
} ?>
<?php if( isset( $args ) && ! empty( $args ) ): ?>
	<div class="digi-import-git-success" style="display : flex; float:left; margin-bottom:8px">
		<?php if( isset( $args[ 'txt' ] ) && count( $args[ 'txt' ] ) > 0 ): ?>
			<div class="wpeo-button button-blue wpeo-tooltip-event action-input"
			aria-label="<?php esc_html_e( sprintf( 'Préparer le fichier => %1$s', $args[ 'txt' ][ 0 ][ 'name' ] ), 'digirisk' ); ?>"
			 data-url="<?php echo esc_attr( $args[ 'txt' ][ 0 ][ 'url' ] ); ?>"
			 data-parent="action-input"
			 data-action="execute_this_txt_totextarea"
			 style="margin-right: 8px;">
				<i class="fas fa-play"></i>
				<span><?php esc_html_e( 'Préparer', 'digirisk' ); ?></span>
				<?php foreach( $data as $key => $element ): ?>
					<input type="hidden" name="git[<?php echo esc_attr( $key ); ?>][name]" value="<?php echo esc_attr( $element[ 'name' ] ); ?>">
					<input type="hidden" name="git[<?php echo esc_attr( $key ); ?>][url]" value="<?php echo esc_attr( $element[ 'download_url' ] ); ?>">
				<?php endforeach;?>
			</div>
		<?php else: ?>
			<div class="wpeo-button button-red wpeo-tooltip-event"
			aria-label="<?php esc_html_e( 'Aucun fichier TXT', 'digirisk' ); ?>"
			style="margin-right: 8px;">
				<i class="fas fa-times"></i>
				<span><?php esc_html_e( 'Aucun fichier TXT', 'digirisk' ); ?></span>
			</div>
		<?php endif; ?>

		<?php if( isset( $args[ 'picture' ] ) && count( $args[ 'picture' ] ) > 0 ): ?>
			<div class="wpeo-button button-blue wpeo-tooltip-event digi-picture-download"
				aria-label="<?php esc_html_e( 'Importe toutes les photos dans les médias', 'digirisk' ); ?>"
				style="margin-right: 8px;">
				<i class="far fa-image"></i>
				<span><?php esc_html_e( 'Télécharger photos', 'digirisk' ); ?>
					(<span class="digi-number-picture"><?php echo esc_attr( count( $args[ 'picture' ] ) ); ?></span>)
				</span>
			</div>
		<?php else: ?>
			<div class="wpeo-button button-red wpeo-tooltip-event"
			aria-label="<?php esc_html_e( 'Aucune photo', 'digirisk' ); ?>"
			style="margin-right: 8px;">
				<i class="fas fa-play"></i>
				<span><?php esc_html_e( 'Aucune photo', 'digirisk' ); ?></span>
			</div>
		<?php endif; ?>
	</div>
<?php endif; ?>

<div class="digi-import-display-view" style="float : right; cursor : pointer; margin-right : 5px;">
	<span>
		<i class="fas fa-pencil-alt fa-2x" data-display="textarea"></i>
	</span>
</div>

<div class="digi-display-response-git">
	<?php if( ! empty( $data ) ): ?>
		<?php \eoxia\View_Util::exec( 'digirisk', 'causerie', 'form/modal-content-git-foreach', array(
				'data' => $data,
			) ); ?>
	<?php endif; ?>
</div>
