<?php
/**
 * Les établissements dans la navigation.
 *
 * @author Evarisk <dev@evarisk.com>
 * @since 6.0.0
 * @version 7.0.0
 * @copyright 2015-2018 Evarisk
 * @package DigiRisk
 */

namespace digi;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
} ?>

<ul class="<?php echo esc_attr( $class ); ?>">
	<?php
	\eoxia\View_Util::exec( 'digirisk', 'navigation', 'item-new', array(
		'id' => $id,
	) );

	if ( ! empty( $societies ) ) :
		foreach ( $societies as $society ) :
			\eoxia\View_Util::exec( 'digirisk', 'navigation', 'item', array(
				'selected_society_id' => $selected_society_id,
				'society'             => $society,
			) );
		endforeach;
	endif;
	?>
</ul>
