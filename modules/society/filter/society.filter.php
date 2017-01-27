<?php
/**
 * Les filtres pour les sociétés
 *
 * @author Jimmy Latour <jimmy@evarisk.com>
 * @since 6.2.2.0
 * @version 6.2.5.0
 * @copyright 2015-2017 Evarisk
 * @package society
 * @subpackage filter
 */

namespace digi;

if ( ! defined( 'ABSPATH' ) ) { exit; }

/**
 * Les filtres pour les sociétés
 */
class Society_Filter {

	/**
	 * Le constructeur
	 *
	 * @since 6.2.2.0
	 * @version 6.2.5.0
	 */
	public function __construct() {
		add_filter( 'society_identity', array( $this, 'callback_society_identity' ), 10, 2 );
	}

	/**
	 * Affiches l'identité en haut de la vue principale d'une société.
	 *
	 * @param  Society_Model $element           Les données de la société.
	 * @param  boolean       $editable_identity Si le titre est modifiable ou pas.
	 *
	 * @return void
	 *
	 * @since 6.2.2.0
	 * @version 6.2.5.0
	 */
	public function callback_society_identity( $element, $editable_identity = false ) {
		View_Util::exec( 'society', 'identity', array( 'element' => $element, 'editable_identity' => $editable_identity ), false );
	}
}

new Society_Filter();
