<?php
/**
 * Classe gérant les utilisateurs dans la page "utilisateur" de WordPress.
 *
 * @author Evarisk <dev@evarisk.com>
 * @since 6.1.6
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
	 * @since 6.1.6
	 * @version 6.2.4
	 */
	protected function construct() {}

	/**
	 * Récupères et affiches la liste des utilisateurs.
	 *
	 * @since 6.1.6
	 * @version 6.1.6
	 *
	 * @return void
	 */
	public function display_list_user() {
		$list_user   = User_Class::g()->get( array( 'exclude' => array( 1 ) ) );
		$user_schema = User_Class::g()->get( array( 'schema' => true ), true );

		\eoxia\View_Util::exec( 'digirisk', 'user_dashboard', 'list', array(
			'list_user'   => $list_user,
			'user_schema' => $user_schema,
		) );
	}

	/**
	 * Sauvegardes le domaine de l'email dans la meta "digirisk_domain_mail".
	 *
	 * @see sanitize_text_field()
	 * @see update_option()
	 *
	 * @since 6.5.0
	 * @version 6.5.0
	 *
	 * @param string $domain_mail Le domaine de l'email à sauvegarder.
	 *
	 * @return boolean      True si tout s'est bien passé, sinon false.
	 */
	public function save_domain_mail( $domain_mail ) {
		$domain_mail = sanitize_text_field( $domain_mail );
		return update_option( 'digirisk_domain_mail', $domain_mail );
	}
}

new User_Dashboard_Class();
