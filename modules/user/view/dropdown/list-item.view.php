<?php namespace digi;

if ( !defined( 'ABSPATH' ) ) exit; ?>

<?php $selected = $user_id === $element->id ? "selected='selected'" : ''; ?>
<option <?php echo $selected; ?> value="<?php echo $element->id; ?>"><?php echo $element->displayname; ?></option>
