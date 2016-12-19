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

if ( ! defined( 'ABSPATH' ) ) { exit; }

if ( ! empty( $societies ) ) :
	foreach ( $societies as $key => $society ) :
		?>
		<li data-id="<?php echo esc_attr( $society->id ); ?>"><?php echo esc_html( $society->unique_identifier . ' - ' . $society->title ); ?></li>
		<?php DUER_Class::g()->display_group_tree( $society->id ); ?>
		<?php DUER_Class::g()->display_workunit_tree( $society->id ); ?>
		<?php
	endforeach;
endif;
