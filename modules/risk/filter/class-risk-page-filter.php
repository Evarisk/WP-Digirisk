<?php
/**
 * Les filtres relatives à la page des rsiques.
 *
 * @author Evarisk <dev@evarisk.com>
 * @since 6.2.7
 * @version 6.2.7
 * @copyright 2015-2017 Evarisk
 * @package risk
 * @subpackage filter
 */

namespace digi;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Les filtres relatives à la page des rsiques.
 */
class Risk_Page_Filter {

	/**
	 * Ajoutes le filtre pour enregistrer l'option "risk_per_page"
	 *
	 * @since 6.2.7
	 * @version 6.2.7
	 */
	public function __construct() {
		add_filter( 'set-screen-option', array( $this, 'callback_set_screen_option' ), 10, 3 );
	}

	/**
	 * Retournes la valeur de l'option.
	 *
	 * @since 6.2.7
	 *
	 * @param boolean $status Le status.
	 * @param string  $option Le nom de l'option.
	 * @param int     $value  La valeur de l'option.
	 */
	public function callback_set_screen_option( $status, $option, $value ) {
		if ( Risk_Page_Class::g()->option_name === $option ) {
			return $value;
		}

		return $status;
	}
}

new Risk_Page_Filter();
