<?php
/**
 * Les établissements dans la navigation.
 *
 * @author Jimmy Latour <jimmy@evarisk.com>
 * @since 0.1.0
 * @version 6.3.0
 * @copyright 2015-2017 Evarisk
 * @package DigiRisk
 */

namespace digi;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
} ?>

<ul class="<?php echo esc_attr( $class ); ?>">
	<?php
	\eoxia001\View_Util::exec( 'digirisk', 'navigation', 'item-new', array(
		'id' => $id,
	) );

	if ( ! empty( $establishments ) ) :
		foreach ( $establishments as $establishment ) :
			\eoxia001\View_Util::exec( 'digirisk', 'navigation', 'item', array(
				'selected_establishment_id' => $selected_establishment_id,
				'establishment' => $establishment,
			) );
		endforeach;
	endif;
	?>
</ul>
