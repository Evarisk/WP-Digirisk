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
	<div class="table-row">
		<div class="table-cell table-50">
			<?php echo esc_attr( $key + 1 ); ?>
		</div>
		<div class="table-cell table-300">
			<?php echo esc_attr( $element[ 'name' ] ); ?>
		</div>
		<div class="table-cell table-100">
			<div><?php echo esc_attr( $element[ 'size' ] ); ?></div>
		</div>
		<div class="table-cell table-100" data-title="<?php esc_html_e( 'Type', 'task-manager' ); ?>">
			<?php echo esc_attr( Causerie_Class::g()->trad_this_gittype( $element[ 'type' ], $element[ 'name' ] ) ); ?>
		</div>
		<div class="table-cell table-cell table-200 table-end" data-title="<?php esc_html_e( 'Action', 'task-manager' ); ?>">
			<a class="wpeo-button button-blue wpeo-tooltip-event"
			href="<?php echo esc_attr( $element[ 'html_url' ] ); ?>" target="_blank"
			style="margin-right: 5px"
			aria-label="<?php esc_html_e( 'Lien GitHub', 'task-manager' ); ?>">
				<i class="fab fa-chrome"></i>
			</a>

			<a class="wpeo-button button-main wpeo-tooltip-event"
			href="<?php echo esc_attr( $element[ 'download_url' ] ); ?>" target="_blank"
			style="margin-right: 5px"
			aria-label="<?php esc_html_e( 'Affichage du contenu', 'task-manager' ); ?>">
				<i class="fas fa-search-plus"></i>
			</a>
			<?php if( $element[ 'type' ] == "file" ): ?>
				<?php $extension = pathinfo( $element[ 'name' ] )[ 'extension' ]; ?>
				<?php if( $extension == "png" || $extension == "jpg" ): ?>
					<div class="wpeo-button button-green wpeo-tooltip-event action-attribute digi-this-is-a-picture"
						data-alreadydl="false"
						aria-label="<?php esc_html_e( 'Importer dans les médias wordpress', 'task-manager' ); ?>"
						data-filename="<?php echo esc_attr( pathinfo( $element[ 'path' ] )[ 'filename' ] ); ?>"
						data-url="<?php echo esc_attr( $element[ 'download_url' ] ); ?>"
						data-action="import_this_picture_tomedia"
						data-nonce="<?php echo esc_attr( wp_create_nonce( 'import_this_picture_tomedia' ) ); ?>"
						data-loader='table-row'
						style="margin-right: 5px">
						<i class="fas fa-download"></i>
					</div>
				<?php elseif( $extension == "txt" ): ?>
					<div class="wpeo-button button-green wpeo-tooltip-event action-attribute"
						aria-label="<?php esc_html_e( 'Importer le text', 'task-manager' ); ?>"
						data-action="import_this_txt_totextarea"
						data-url="<?php echo esc_attr( $element[ 'download_url' ] ); ?>"
						data-nonce="<?php echo esc_attr( wp_create_nonce( 'import_this_txt_totextarea' ) ); ?>"
						data-loader='table-row'
						style="margin-right: 5px">
						<i class="fas fa-font"></i>
					</div>
				<?php endif; ?>
			<?php endif; ?>

		</div>
	</div>
