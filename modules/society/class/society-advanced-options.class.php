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
	 * Charges la vue affichant le champ pour déplacer une société vers une autre.
	 *
	 * @param  Society_Model $element L'objet société.
	 * @return void
	 *
	 * @since 6.2.5.0
	 * @version 6.2.5.0
	 */
	public function display( $element ) {
		View_Util::exec( 'society', 'advanced-options/main', array( 'element' => $element ) );
	}
}

Society_Advanced_Options_Class::g();
