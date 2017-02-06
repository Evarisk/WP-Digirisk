<?php
/**
 * Les filtres relatives au DUER
 *
 * @author Jimmy Latour <jimmy@evarisk.com>
 * @since 6.2.5.0
 * @version 6.2.5.0
 * @copyright 2015-2017 Evarisk
 * @package duer
 * @subpackage filter
 */

namespace digi;

if ( ! defined( 'ABSPATH' ) ) {	exit; }

/**
 * Les filtres relatives au DUER
 */
class DUER_Filter {

	/**
	 * Le constructeur ajoute le filtre society_header_end
	 *
	 * @since 6.2.5.0
	 * @version 6.2.5.0
	 */
	public function __construct() {
		add_filter( 'society_header_end', array( $this, 'callback_society_header_end' ), 10, 1 );
	}

	/**
	 * Appelle la vue button-generate-duer.view.php avec le groupement en paramètre.
	 *
	 * @param  Group_Model $element Les données du groupement.
	 *
	 * @return void
	 *
	 * @since 6.2.5.0
	 * @version 6.2.5.0
	 */
	public function callback_society_header_end( $element ) {
		if ( 'digi-group' === $element->type ) {
			View_Util::exec( 'duer', 'button-generate-duer', array( 'element' => $element ) );
		}
	}
}

new DUER_Filter();
