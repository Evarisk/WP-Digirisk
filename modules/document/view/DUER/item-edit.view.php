<?php
/**
 * Gestion du formulaire pour générer un DUER
 *
 * @author Jimmy Latour <jimmy@evarisk.com>
 * @version 6.1.9.0
 * @copyright 2015-2016 Evarisk
 * @package document
 * @subpackage view
 */

namespace digi;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

?>

<li class='wp-digi-list-item wp-digi-risk-item'>
	<span></span>
	<span class="padded"><input type="text" class="eva-date" value="" /></span>
	<span class="padded"><input type="text" class="eva-date" value="" /></span>
	<span class="padded"><input type="text" /></span>

	<span class="padded">
		<span class="content-methodology">test</span>
		<span data-parent="wp-digi-risk-item"
					data-target="popup"
					data-cb-object="DUER"
					data-cb-func="fill_textarea_in_popup"
					data-title="Édition de la méthodologie"
					data-src="methodology"
					class="open-popup dashicons dashicons-media-default"></span>
	</span>

	<span class="padded">
		<span class="content-sources">sources</span>
		<span data-parent="wp-digi-risk-item"
					data-target="popup"
					data-cb-object="DUER"
					data-cb-func="fill_textarea_in_popup"
					data-title="Édition de la source"
					data-src="sources"
					class="open-popup dashicons dashicons-media-default"></span>
		</span>

	<span class="padded">
		<span class="content-notes-importantes">Notes importantes</span>
		<span data-parent="wp-digi-risk-item"
					data-target="popup"
					data-cb-object="DUER"
					data-cb-func="fill_textarea_in_popup"
					data-title="Édition de la note importante"
					data-src="notes-importantes"
					class="open-popup dashicons dashicons-media-default"></span>
	</span>

	<span class="padded"><input type="text" /></span>
	<span class="padded">Créer</span>
	<?php
	view_util::exec( 'document', 'DUER/popup' );
	?>
</li>
