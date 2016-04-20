<?php if ( !defined( 'ABSPATH' ) ) exit;
global $wpdigi_risk_evaluation_ctr;
if ( !empty( $risk_definition ) ):
	$risk_evaluation = $wpdigi_risk_evaluation_ctr->show( $risk_definition->option['current_evaluation_id'] );
endif;
?>

<section class="wp-digi-eval-evarisk hidden">
	<input type="hidden" class="digi-method-evaluation-id" value="<?php echo $term_evarisk->term_id; ?>" />
	<div class="hidden ">
		<div class="wp-digi-eval-header">
			<h2><?php _e( 'Evaluation method Evarisk', 'wpdigi-i18n' ); ?></h2>
			<i class="dashicons dashicons-no-alt"></i>
		</div>

		<div class="wp-digi-eval-table">
			<?php if ( !empty( $list_evaluation_method_variable ) ): ?>
				<ul class="header">
					<li></li>
					<?php foreach( $list_evaluation_method_variable as $key => $value ): ?>
						<li>
							<?php
								echo $list_evaluation_method_variable[$key]->name;
								$value = '';
								if ( !empty( $risk_evaluation ) ):
									foreach( $risk_evaluation->option['quotation_detail'] as $detail ) {
										if ( $detail['variable_id'] == $list_evaluation_method_variable[$key]->id )
											$value = $detail['value'];
									}
								endif;

							?>

							<input type="hidden" variable-id="<?php echo $list_evaluation_method_variable[$key]->id; ?>" name="variable[<?php echo $list_evaluation_method_variable[$key]->id; ?>]" value="<?php echo !empty( $value ) ? $value : ''; ?>" />
						</li>
					 <?php endforeach; ?>
				</ul>

				<?php for( $i = 0; $i < count( $list_evaluation_method_variable ); $i++ ): ?>
					<ul class="row">
						<li><?php echo $i; ?></li>
						<?php for ( $x = 0; $x < count( $list_evaluation_method_variable ); $x++ ): ?>
							<?php
							$active = '';

							if ( !empty( $risk_evaluation ) ):
								foreach( $risk_evaluation->option['quotation_detail'] as $detail ) {
									if( $detail['variable_id'] == $list_evaluation_method_variable[$x]->id && $detail['value'] == $list_evaluation_method_variable[$x]->option['survey']['request'][$i]['seuil'] )
										$active = 'active';
								}
							endif;
							?>

							<li data-variable-id="<?php echo $list_evaluation_method_variable[$x]->id; ?>" data-seuil-id="<?php echo $list_evaluation_method_variable[$x]->option['survey']['request'][$i]['seuil'] == null ? 'undefined' : $list_evaluation_method_variable[$x]->option['survey']['request'][$i]['seuil']; ?>" class="cell <?php echo $active; ?>">
								<?php echo !empty( $list_evaluation_method_variable[$x]->option['survey']['request'][$i] ) ? $list_evaluation_method_variable[$x]->option['survey']['request'][$i]['question'] : ''; ?>
							</li>
						<?php endfor; ?>
					</ul>
				<?php endfor; ?>
			<?php endif;?>
			<a href="#" class="float right wp-digi-bton-fourth"><?php _e( 'Evaluate risk', 'wpdigi-i18n' ); ?></a>
		</div>
	</div>

</section>
