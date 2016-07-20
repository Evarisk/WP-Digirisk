<?php
/**
* La popup qui contient les données de l'évaluation complexe de digirisk
*
* @author Jimmy Latour <jimmy.latour@gmail.com>
* @version 0.1
* @copyright 2015-2016 Eoxia
* @package evaluation_method
* @subpackage view
*/

if ( !defined( 'ABSPATH' ) ) exit; ?>

<div class="wpdigi-method-evaluation-render digi-popup hidden">
  <!-- Utile pour retenir la méthode d'evaluation utilisée -->
  <input type="hidden" class="digi-method-evaluation-id" value="<?php echo !empty( $term_evarisk->term_id ) ? $term_evarisk->term_id : 0; ?>" />

  <section class="wp-digi-eval-evarisk">
    <div>
			<a href="#" class="close"><i class="dashicons dashicons-no-alt"></i></a>
			<div class="wp-digi-eval-table">
				<?php if ( !empty( $list_evaluation_method_variable ) ): ?>
					<?php require( EVALUATION_METHOD_VIEW . 'popup/header.view.php' ); ?>

					<?php for( $i = 0; $i < count( $list_evaluation_method_variable ); $i++ ): ?>
						<?php require( EVALUATION_METHOD_VIEW . 'popup/row.view.php' ); ?>
					<?php endfor; ?>
				<?php endif;?>
				<button type="button" data-nonce="<?php echo wp_create_nonce( 'get_scale' ); ?>" class="float right wp-digi-bton-fourth"><?php _e( 'Evaluate risk', 'digirisk' ); ?></button>
			</div>
    </div>
  </section>
</div>
