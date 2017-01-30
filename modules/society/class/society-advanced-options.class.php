<?php
/**
 * Classe gérant les options avancées des sociétés.
 *
 * @author Jimmy Latour <jimmy@evarisk.com>
 * @since 6.2.5.0
 * @version 6.2.5.0
 * @copyright 2015-2017 Evarisk
 * @package society
 * @subpackage class
 */

namespace digi;

if ( ! defined( 'ABSPATH' ) ) { exit; }

/**
 * Classe gérant les options avancées des sociétés.
 */
class Society_Advanced_Options_Class extends Singleton_Util {

	/**
	 * Le constructeur
	 *
	 * @return void
	 *
	 * @since 6.2.5.0
	 * @version 6.2.5.0
	 */
	protected function construct() {}

	/**
	 * Charges tous les groupements de l'application, et enlèves le groupement courant.
	 * Charges la vue affichant le select permettant de déplacer une société vers une autre.
	 *
	 * @param  Society_Model $selected_society L'objet société.
	 * @return void
	 *
	 * @since 6.2.5.0
	 * @version 6.2.5.0
	 */
	public function display( $selected_society ) {
		$groupments = Group_Class::g()->get( array( 'status' => 'publish' ) );

		View_Util::exec( 'society', 'advanced-options/main', array( 'selected_society' => $selected_society, 'groupments' => $groupments ) );
	}
}

Society_Advanced_Options_Class::g();
