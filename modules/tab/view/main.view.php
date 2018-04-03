<?php
/**
 * Affiches les onglets et le contenu principale
 *
 * @author Evarisk <dev@evarisk.com>
 * @since 7.0.0
 * @version 7.0.0
 * @copyright 2015-2018 Evarisk
 * @package DigiRisk
 */

namespace digi;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
} ?>

<ul class="tab-list">
	<?php
	if ( ! empty( $list_tab[ $type ] ) ) :
		foreach ( $list_tab[ $type ] as $key => $element ) :
			\eoxia\View_Util::exec( 'digirisk', 'tab', 'item-' . $element['type'], array(
				'tab'     => $tab,
				'id'      => $id,
				'key'     => $key,
				'element' => $element,
			) );
		endforeach;
	endif;
	?>
</ul>

<div class="tab-container">
	<div class="tab-content tab-active">
		<?php
		\eoxia\View_Util::exec( 'digirisk', 'tab', 'content', array(
			'tab' => $tab,
			'id'  => $id,
		), false );
		?>
	</div>
</div>
