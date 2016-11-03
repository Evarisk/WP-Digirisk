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
	<span class="padded">test... <span data-parent="wp-digi-risk-item" data-target="digi-popup" class="open-popup dashicons dashicons-media-default"></span></span>
	<span class="padded">Sources <span class="dashicons dashicons-media-default"></span></span>
	<span class="padded">Notes importantes <span class="dashicons dashicons-media-default"></span></span>
	<span class="padded"><input type="text" /></span>
	<span class="padded">Créer</span>
	<?php
	view_util::exec( 'document', 'DUER/popup' );
	?>
</li>
