<?php
/**
 * Classe gérant les utilisateurs dans la page "utilisateur" de WordPress.
 *
 * @author Dev <dev@evarisk.com>
 * @since 6.2.3
 * @version 6.5.0
 * @copyright 2015-2018 Evarisk
 * @package DigiRisk
 */

namespace digi;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Classe gérant les utilisateurs dans la page "utilisateur" de WordPress.
 */
class User_Dashboard_Class extends \eoxia\Singleton_Util {

	/**
	 * Le constructeur
	 *
	 * @since 6.0.0
	 * @version 6.2.4
	 */
	protected function construct() {}

		/**
		 * Charges la liste des utilisateurs de DigiRisk excepté celui dont l'ID correspond à 1.
		 * Appel ensuite la vue user_dashboard/view/list.view.php
		 *
		 * @return void
		 *
		 * @since 6.0.0
		 * @version 6.5.0
		 */
	public function display_list_user() {
		$list_user   = User_Digi_Class::g()->get( array( 'exclude' => array( 1 ) ) );
		$user_schema = User_Digi_Class::g()->get( array( 'schema' => true ), true );

		\eoxia\View_Util::exec( 'digirisk', 'user_dashboard', 'list', array(
			'list_user'   => $list_user,
			'user_schema' => $user_schema,
		) );
	}
}

new User_Dashboard_Class();
