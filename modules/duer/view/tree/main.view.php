<?php
/**
 * Affichage en mode "arbre" des sociétés pour la popup de la génération du DUER
 *
 * @author Jimmy Latour <jimmy@evarisk.com>
 * @version 6.2.3.0
 * @copyright 2015-2016 Eoxia
 * @package duer
 * @subpackage view
 */

namespace digi;

if ( ! defined( 'ABSPATH' ) ) { exit; } ?>

<ul>
	<li data-duer="true"><?php esc_html_e( 'Génération du DUER', 'digirisk' ); ?></li>
	<?php DUER_Class::g()->display_group_tree(); ?>
	<li data-zip="true"><?php esc_html_e( 'Génération du ZIP', 'digirisk' ); ?></li>
</ul>
