<?php
/**
 * Classe gérant les utilisateurs dans la page "utilisateur" de WordPress.
 *
 * @author Jimmy Latour <jimmy@evarisk.com>
 * @since 6.2.3.0
 * @version 6.2.4.0
 * @copyright 2015-2017 Evarisk
 * @package user_dashboard
 * @subpackage class
 */

namespace digi;

if ( ! defined( 'ABSPATH' ) ) { exit; }

/**
 * Classe gérant les utilisateurs dans la page "utilisateur" de WordPress.
 */
class User_Dashboard_Class extends Singleton_Util {

	/**
	 * Le constructeur
	 *
	 * @since 0.1
	 * @version 6.2.4.0
	 */
	protected function construct() {}

		/**
		 * Charges la liste des utilisateurs de DigiRisk excepté celui dont l'ID correspond à 1.
		 * Appel ensuite la vue user_dashboard/view/list.view.php
		 *
		 * @return void
		 *
		 * @since 0.1
		 * @version 6.2.4.0
		 */
	public function display_list_user() {
		$list_user = User_Digi_Class::g()->get( array( 'exclude' => array( 1 ) ) );
		$user_schema = User_Digi_Class::g()->get( array( 'schema' => true ) );
		$user_schema = $user_schema[0];
		View_Util::exec( 'user_dashboard', 'list', array( 'list_user' => $list_user, 'user_schema' => $user_schema ) );
	}
}

new User_Dashboard_Class();
