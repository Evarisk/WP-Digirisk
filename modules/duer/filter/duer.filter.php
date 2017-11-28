<?php
/**
 * Les filtres relatives au DUER
 *
 * @author Jimmy Latour <jimmy@evarisk.com>
 * @since 6.2.5
 * @version 6.4.0
 * @copyright 2015-2017 Evarisk
 * @package DigiRisk
 */

namespace digi;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Les filtres relatives au DUER
 */
class DUER_Filter {

	/**
	 * Le constructeur ajoute le filtre society_header_end
	 *
	 * @since 6.2.5
	 * @version 6.2.5
	 */
	public function __construct() {
		add_filter( 'society_header_end', array( $this, 'callback_society_header_end' ), 10, 1 );
	}

	/**
	 * Appelle la vue button-generate-duer.view.php avec le groupement en paramètre.
	 *
	 * @since 6.2.5
	 * @version 6.4.0
	 *
	 * @param  Society_Model $element Les données du groupement.
	 * @return void
	 */
	public function callback_society_header_end( $element ) {
		if ( 'digi-society' === $element->type ) {
			\eoxia\View_Util::exec( 'digirisk', 'duer', 'button-generate-duer', array(
				'element' => $element,
			) );
		}
	}
}

new DUER_Filter();
