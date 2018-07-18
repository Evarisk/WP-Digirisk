<?php
/**
 * Les filtres relatives aux utilisateurs
 *
 * @author Jimmy Latour <jimmy@evarisk.com>
 * @since 0.1
 * @version 6.2.5.0
 * @copyright 2015-2017 Evarisk
 * @package user
 * @subpackage filter
 */

namespace digi;

if ( ! defined( 'ABSPATH' ) ) { exit; }

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
		add_filter( 'eo_search_results_society_information_owner', array( $this, 'callback_eo_search' ) );
	}

	public function callback_eo_search( $results ) {
		if ( ! empty( $results ) ) {
			foreach ( $results as &$result ) {
				$result->data['displayname'] = User_Digi_Class::g()->element_prefix . $result->data['id'] . ' - ' . $result->data['displayname'];
			}
		}
		return $results;
	}
}

new User_Filter();
