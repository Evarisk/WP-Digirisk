<?php
/**
 * Les filtres relatives aux utilisateurs
 *
 * @author Evarisk <dev@evarisk.com>
 * @since 6.2.5
 * @copyright 2015-2019 Evarisk
 * @package user
 * @subpackage filter
 */

namespace digi;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Les filtres relatives aux utilisateurs
 */
class User_Filter {

	/**
	 * Le constructeur ajoute le filtre digi_tab
	 *
	 * @since 7.0.0
	 */
	public function __construct() {
		add_filter( 'eo_search_results_accident_user', array( $this, 'callback_eo_search' ) );
		add_filter( 'eo_search_results_evaluator', array( $this, 'callback_eo_search' ) );
		add_filter( 'eo_search_results_society_information_owner', array( $this, 'callback_eo_search' ) );
	}

	/**
	 * Ajoutes l'identifiant devant le displayname de chaque utilisateur
	 *
	 * @since 7.0.0
	 *
	 * @param  array $results La liste des utilisateurs.
	 * @return array          La liste des utilisateurs avec l'identifiant supplémentaire.
	 */
	public function callback_eo_search( $results ) {
		if ( ! empty( $results ) ) {
			foreach ( $results as &$result ) {
				$result->data['displayname'] = User_Class::g()->element_prefix . $result->data['id'] . ' - ' . $result->data['displayname'];
			}
		}
		return $results;
	}
}

new User_Filter();
