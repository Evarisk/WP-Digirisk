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

 <tr>

	 <?php if( ! isset( $element['element' ] ) ): ?>
		 <td class="padding">
			 <span for="accronym-<?php echo $key; ?>"><?php echo esc_attr( $element['description'] ); ?></span>
		 </td>
		 <td class="padding">
			 <input type="text" id="accronym-<?php echo $key; ?>" name="list_accronym[<?php echo $key; ?>][to]" value="<?php echo $element['to']; ?>" />
			 <input type="hidden" name="list_accronym[<?php echo $key; ?>][description]" value="<?php echo $element['description']; ?>" />
		 </td>
		 <?php if( isset( $element[ 'page' ] ) ): ?>
			 <td class="w100 padding wpeo-tooltip-event" aria-label="<?php esc_html_e( 'Accéder à la page', 'digirisk' ); ?>" style="text-align: center;">
				 <a href="<?php echo esc_attr( $element[ 'page' ] ); ?>">
					 <div class="wpeo-button button-blue">
						 <i class="fas fa-share"></i>
					 </div>
				 </a>
			 </td>
		 <?php else: ?>
			<td></td>
		 <?php endif; ?>
	 <?php else: ?>
		 <td class="padding">
			 <span for="accronym-<?php echo $key; ?>"><?php echo esc_attr( $element['description'] ); ?></span>
		 </td>
		 <td class="padding">
			 <input type="text" id="accronym-<?php echo $key; ?>" name="list_prefix[<?php echo $element['element' ]; ?>][to]" value="<?php echo $element['to']; ?>" />
 			 <input type="hidden" name="list_prefix[<?php echo $key; ?>][description]" value="<?php echo $element['description']; ?>" />
		 </td>
		 <?php if( isset( $element[ 'page' ] ) ): ?>
			 <td class="w100 padding wpeo-tooltip-event" aria-label="<?php esc_html_e( 'Accéder à la page', 'digirisk' ); ?>" style="text-align: center;">
				 <a href="<?php echo esc_attr( $element[ 'page' ] ); ?>">
					 <div class="wpeo-button button-blue">
						 <i class="fas fa-share"></i>
					 </div>
				 </a>
			 </td>
		 <?php else: ?>
			<td></td>
		 <?php endif; ?>
	 <?php endif; ?>
 </tr>
