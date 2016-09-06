<?php if ( !defined( 'ABSPATH' ) ) exit; ?>
<div class="wrap">
	<h1><?php _e( 'Digirisk tools', 'digirisk' ); ?></h1>

	<div class="digi-tools-main-container" >
		<h2 class="nav-tab-wrapper">
			<a class="nav-tab nav-tab-active" href="#" data-id="digi-data-export" ><?php _e( 'Export digirisk datas', 'digirisk' ); ?></a>
			<a class="nav-tab" href="#" data-id="digi-method-fixer" ><?php _e( 'Correction de la méthode d\'évaluation Evarisk', 'digirisk' ); ?></a>
			<a class="nav-tab" href="#" data-id="digi-risk-fixer" ><?php _e( 'Recompilation des identifiants de risques', 'digirisk' ); ?></a>
		</h2>

		<div id="digi-data-export" class="wp-digi-bloc-loader gridwrapper2" >
			<div class="block">
				<?php echo do_shortcode( '[digi-export]' ); ?>
			</div>
			<div class="block">
				<?php echo do_shortcode( '[digi-import]' ); ?>
			</div>
		</div>

		<div id="digi-method-fixer" class="hidden" >
			<p><?php _e( 'Cliquer sur ce bouton pour que Digirisk réintialise les anciennes variables de la méthode d\'évaluation d\'Evarisk.', 'digirisk' ); ?></p>
			<p><button class="wp-digi-bton-fourth reset-method-evaluation" data-nonce="<?php echo wp_create_nonce( 'reset_method_evaluation' ); ?>" type="button"><?php _e( 'Réintialiser', 'digirisk' ); ?></button>
			<ul></ul>
		</div>

		<div id="digi-risk-fixer" class="hidden" >
			<p><?php _e( 'Cliquer sur ce bouton pour que recompiler les risques, si vous rencontrez des problèmes d\'affichage', 'digirisk' ); ?></p>
			<p><button class="wp-digi-bton-fourth element-risk-compilation" data-nonce="<?php echo wp_create_nonce( 'risk_list_compil' ); ?>" type="button" ><?php _e( 'Recompiler', 'digirisk' ); ?></button>
			<ul></ul>
		</div>
  </div>
</div>
