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

<div class="wpeo-table table-flex table-5">
	<div class="table-row table-header">
		<div class="table-cell table-50" data-title="<?php esc_html_e( 'Key', 'digirisk' ); ?>" style="text-align: center">
			<?php esc_html_e( 'N°', 'digirisk' ); ?>
		</div>
		<div class="table-cell table-300" data-title="<?php esc_html_e( 'Titre', 'digirisk' ); ?>" style="text-align: center">
			<?php esc_html_e( 'Titre', 'digirisk' ); ?>
		</div>
		<div class="table-cell table-100" data-title="<?php esc_html_e( 'Taille', 'digirisk' ); ?>" style="text-align: center">
			<?php esc_html_e( 'Taille (octet)', 'digirisk' ); ?>
		</div>
		<div class="table-cell table-100" data-title="<?php esc_html_e( 'Type', 'digirisk' ); ?>" style="text-align: center">
			<?php esc_html_e( 'Type', 'digirisk' ); ?>
		</div>
		<div class="table-cell table-200" data-title="<?php esc_html_e( 'Action', 'digirisk' ); ?>" style="text-align: center">
			<span><?php esc_html_e( 'Action', 'digirisk' ); ?></span>
		</div>
	</div>

	<?php foreach( $data as $key => $element ): ?>
			<?php
				\eoxia\View_Util::exec( 'digirisk', 'causerie', 'form/modal-content-git-item', array(
					'element' => $element,
					'key'     => $key
				) );
			?>
	<?php endforeach; ?>
</div>
