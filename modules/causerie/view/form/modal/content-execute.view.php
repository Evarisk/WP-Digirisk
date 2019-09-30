<?php
/**
 * Affichage du contenu d'un modal en mode 'Execute'
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

<input type="hidden" name="content" value="<?php echo esc_attr( $content ); ?>">
<table class="table closed-prevention">
	<thead>
		<tr>
			<td class="padding"><?php esc_html_e( 'Import', 'digirisk' ); ?></td>
			<td class="padding"><?php esc_html_e( 'Note', 'digirisk' ); ?></td>
			<td class="w50 padding"><?php esc_html_e( 'Etat', 'digirisk' ); ?></td>
		</tr>
	</thead>

	<tbody>
		<?php foreach( $lines as $key => $line ): ?>
			<?php if( $line[ 'success' ] === true ): ?>
				<tr class="item" style="color : green">
					<?php if( $line[ 'url' ] != "" ): ?>
						<input type="hidden"
						name="downloadjpg[<?php echo esc_attr( $key ); ?>][url]"
						value="<?php echo esc_attr( $line[ 'url' ] ); ?>">
						<input type="hidden"
						name="downloadjpg[<?php echo esc_attr( $key ); ?>][filename]"
						value="<?php echo esc_attr( $line[ 'filename' ] ); ?>">
					<?php endif; ?>
					<td class="padding">
						<?php echo esc_attr( $line[ 'line' ] ); ?>
					</td>
					<td>
						<?php echo esc_attr( $line[ 'info' ] ); ?>
					</td>
					<td>
						<i class="fas fa-2x fa-check"></i>
					</td>
				</tr>

			<?php else: ?>
				<tr class="item" style="color : red">
					<td class="padding">
						<?php echo esc_attr( $line[ 'line' ] ); ?>
					</td>
					<td>
						<?php echo esc_attr( $line[ 'info' ] ); ?>
					</td>
					<td>
						<i class="fas fa-2x fa-times"></i>
					</td>
				</tr>
			<?php endif; ?>
		<?php endforeach; ?>

	</tbody>
</table>

<?php /*

<div class="digi-import-execute-error" style="display: flex; color : red; line-height: 2em; cursor: pointer">
	<span class="wpeo-tooltip-event" aria-label="<?php echo esc_attr( $line[ 'error' ] ); ?>">
		<?php echo esc_attr( $line[ 'line' ] ); ?>
	</span>
	<span style="margin-left: 4px;"><i class="fas fa-2x fa-times"></i></span>
</div>

*/ ?>
