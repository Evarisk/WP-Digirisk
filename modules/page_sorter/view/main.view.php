<?php
/**
 * Vue contenant l'affichage de la liste des sociétées
 *
 * @package Evarisk\Plugin
 */

namespace digi;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

?>

<div class="wrap sorter-page">
	<?php wp_nonce_field( 'callback_sorter_parent' ); ?>
	<h1><?php esc_html_e( 'Structure des groupements', 'digirisk' ); ?></h1>
	<div class="updated settings-error notice hidden">
		<p>
			<strong><?php esc_html_e( 'Organisation enregistrées.', 'digirisk' ); ?></strong>
		</p>
	</div>

	<ul class="menu" id="menu-to-edit">
		<?php
		view_util::exec( 'page_sorter', 'list', array( 'i' => 0, 'groupments' => $groupments ) );
		?>
	</ul>
</div>
