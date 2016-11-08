<?php
/**
 * Gestion de l'affichage d'un DUER
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
	<span><?php echo $element->unique_identifier; ?></span>
	<span class="padded"><?php echo esc_html( mysql2date( 'd/m/Y', $element->date, true ) ); ?></span>
	<span class="padded"><?php echo esc_html( mysql2date( 'd/m/Y', $element->date, true ) ); ?></span>
	<span class="padded"><?php echo esc_html( $element->document_meta['destinataireDUER'] ); ?></span>

	<span class="padded">
		<span data-parent="wp-digi-societytree-right-container"
					data-target="popup"
					data-cb-object="DUER"
					data-cb-func="view_in_popup"
					data-title="Méthodologie"
					data-src="methodology"
					class="open-popup span-content-methodology"><?php echo esc_html( $element->document_meta['methodologie'] ); ?></span>
	</span>

	<span class="padded">
		<span data-parent="wp-digi-societytree-right-container"
					data-target="popup"
					data-cb-object="DUER"
					data-cb-func="view_in_popup"
					data-title="Source"
					data-src="sources"
					class="open-popup span-content-sources"><?php echo esc_html( $element->document_meta['sources'] ); ?></span>
		</span>

	<span class="padded">
		<span data-parent="wp-digi-societytree-right-container"
					data-target="popup"
					data-cb-object="DUER"
					data-cb-func="view_in_popup"
					data-title="Note importante"
					data-src="notes-importantes"
					class="open-popup span-content-notes-importantes"><?php echo esc_html( $element->document_meta['remarqueImportante'] ); ?></span>
	</span>

	<span class="padded"><?php echo esc_html( $element->document_meta['dispoDesPlans'] ); ?></span>
	<span class="padded flex-tmp">
		<a href="<?php echo document_class::g()->get_document_path( $element ); ?>" class="wp-digi-bton-fifth" ><?php _e( 'Download', 'digirisk' ); ?></a>
	</span>
</li>
