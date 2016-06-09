<?php if ( !defined( 'ABSPATH' ) ) exit; ?>

<div class="wrap">
  <h1><?php _e( 'Digirisk tools', 'wpdigi-i18n' ); ?></h1>

  <p><?php _e( 'Cliquer sur ce bouton pour que Digirisk réintialise les anciennes variables de la méthode d\'évaluation d\'Evarisk.', 'wpdigi-i18n' ); ?></p>
  <p><button class="wp-digi-bton-fourth reset-method-evaluation" data-nonce="<?php echo wp_create_nonce( 'reset_method_evaluation' ); ?>" type="button"><?php _e( 'Réintialiser', 'wpdigi-i18n' ); ?></button>
  <ul>
    
  </ul>
</div>
