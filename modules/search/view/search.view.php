<?php
/**
 * Affiches le champ de recherche
 *
 * @author Jimmy Latour <jimmy@evarisk.com>
 * @since 0.1
 * @version 6.2.4.0
 * @copyright 2015-2017 Evarisk
 * @package search
 * @subpackage view
 */

namespace digi;

if ( ! defined( 'ABSPATH' ) ) { exit; } ?>

<label class="search">

	<?php if ( ! empty( $icon ) ) : ?>
		<i class="<?php echo esc_attr( $icon ); ?>"></i>
	<?php endif; ?>

	<input type="text"
		placeholder="<?php echo esc_attr( $text ); ?>"
		data-target="<?php echo esc_attr( $target ); ?>"
		data-type="<?php echo esc_attr( $type ); ?>"
		data-field="<?php echo esc_attr( $field ); ?>"
		data-class="<?php echo esc_attr( $class ); ?>"
		data-next-action="<?php echo esc_attr( $next_action ); ?>"
		data-id="<?php echo esc_attr( $element_id ); ?>"
		autocomplete="off">

</label>

<?php if ( ! empty( $field ) ) : ?>
	<input type="hidden" name="<?php echo esc_attr( $field ); ?>" value="0" />
<?php endif; ?>
