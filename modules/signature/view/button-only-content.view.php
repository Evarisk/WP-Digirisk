
<input type="hidden" name="user_signature" value="<?php echo wp_get_attachment_url( $signature_id ); ?>" />
<img class="signature" src="<?php echo esc_attr( wp_get_attachment_url( $signature_id ) ); ?>">
<span class="button-float-icon animated wpeo-tooltip-event" aria-label="Modifier la signature"><i class="fas fa-pencil-alt"></i></span>
