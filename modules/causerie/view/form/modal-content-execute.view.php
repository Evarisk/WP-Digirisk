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
<div class="digi-modal-import">
	<?php foreach( $lines as $key => $line ): ?>
		<?php if( $line[ 'error' ] == "" ): ?>
			<div class="digi-import-execute-success" style="color : green; line-height: 2em; cursor: pointer">
				<span class="wpeo-tooltip-event" aria-label="<?php echo esc_attr( $line[ 'info' ] ); ?>">
					<?php echo esc_attr( $line[ 'line' ] ); ?>
				</span>
				<span><i class="fas fa-check"></i></span>
			</div>
		<?php else: ?>
			<div class="digi-import-execute-error" style="display: flex; color : red; line-height: 2em; cursor: pointer">
				<span class="wpeo-tooltip-event" aria-label="<?php echo esc_attr( $line[ 'error' ] ); ?>">
					<?php echo esc_attr( $line[ 'line' ] ); ?>
				</span>
				<span style="margin-left: 4px;"><i class="fas fa-times"></i></span>
			</div>
		<?php endif; ?>
	<?php endforeach; ?>
</div>
