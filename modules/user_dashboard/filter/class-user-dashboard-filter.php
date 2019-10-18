<?php
/**
 * Les filtres relatives aux utilisateurs
 *
 * @author Evarisk <dev@evarisk.com>
 * @since 7.5.0
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
class User_Dashboard_Filter {

	/**
	 * Le constructeur ajoute le filtre digi_tab
	 *
	 * @since 7.5.0
	 */
	public function __construct() {
		add_filter( 'digi_user_dashboard_item_email_after', array( $this, 'add_user_switch' ) );
	}

	public function add_user_switch( $user ) {
		if ( class_exists( '\user_switching' ) ) {
			$user = get_user_by( 'id', $user->data['id'] );
			$link = \user_switching::maybe_switch_url( $user );
			?>
			<a href="<?php echo esc_attr( $link ); ?>"><i class="fas fa-random"></i></a>
			<?php
		}
	}


}

new User_Dashboard_Filter();
