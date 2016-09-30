<?php namespace digi;

if ( !defined( 'ABSPATH' ) ) exit; ?>

<?php $selected = $risk_id === $element->id ? "selected='selected'" : ''; ?>
<option <?php echo $selected; ?> value="<?php echo $element->id; ?>"><?php _e( 'Risque', 'digirisk' ); echo ' ' . $element->unique_identifier . ' - ' . $element->evaluation[0]->unique_identifier; ?></option>
