<?php
/**
 * Classe gérant les configurations de DigiRisk.
 *
 * @author    Evarisk <dev@evarisk.com>
 * @since     6.0.0
 * @version   7.0.0
 * @copyright 2018 Evarisk.
 * @package   DigiRisk
 */

namespace digi;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Classe gérant les configurations de DigiRisk.
 *
 * @return void
 */
class Setting_Class extends \eoxia\Singleton_Util {

	/**
	 * La limite des utilisateurs de la page ="digirisk-setting"
	 *
	 * @var integer
	 */
	private $limit_user = 20;

	public $default_general_options = array(
		'required_duer_day' => 365,
	);
	/**
	 * Le constructeur
	 *
	 * @return void
	 *
	 * @since 6.0.0
	 * @version 6.2.9
	 */
	protected function construct() {
		add_action( 'admin_enqueue_scripts', array( $this, 'init_option' ) );
		add_action( 'admin_init', array( $this, 'init_preset_danger' ) );
	}

	/**
	 * Initialise les accronymes de DigiRisk.
	 *
	 * @since   6.0.0
	 * @version 7.0.0
	 *
	 * @return mixed
	 */
	public function init_option() {
		$list_accronym = get_option( \eoxia\Config_Util::$init['digirisk']->accronym_option, array() );

		if ( empty( $list_accronym ) ) {
			$request = wp_remote_get( \eoxia\Config_Util::$init['digirisk']->setting->url . 'asset/json/default.json' );

			if ( is_wp_error( $request ) ) {
				return false;
			}

			$request = wp_remote_retrieve_body( $request );
			$data    = json_decode( $request );

			update_option( \eoxia\Config_Util::$init['digirisk']->accronym_option, wp_json_encode( $data ) );
		}

		return true;
	}

	/**
	 * Si les "preset danger" n'existent pas dans la bdd, cette méthode à pour but de les initialiser.
	 *
	 * @since 6.2.9
	 * @version 6.5.0
	 */
	public function init_preset_danger() {
		$digirisk_core = get_option( \eoxia\Config_Util::$init['digirisk']->core_option );

		if ( ! empty( $digirisk_core['installed'] ) ) {
			$preset_danger_installed = get_option( \eoxia\Config_Util::$init['digirisk']->setting->key_preset_danger, false );

			if ( ! $preset_danger_installed ) {
				$danger_category_list = Risk_Category_Class::g()->get();

				if ( ! empty( $danger_category_list ) ) {
					foreach ( $danger_category_list as $element ) {
						if ( ! empty( $element->data['thumbnail_id'] ) ) {
							Risk_Class::g()->update( array(
								'title'    => $element->data['name'],
								'taxonomy' => array(
									'digi-category-risk' => array(
										$element->data['id'],
									),
								),
								'status'   => 'inherit',
								'preset'   => true,
							) );
						}
					}
				}

				\eoxia\LOG_Util::log( 'Création des templates de risque.', 'digirisk' );
				update_option( \eoxia\Config_Util::$init['digirisk']->setting->key_preset_danger, true );
			}
		}
	}

	/**
	 * Récupère le role "subscriber" et appel la vue "capability/has-cap".
	 *
	 * @since 6.4.0
	 * @version 6.4.0
	 *
	 * @return void
	 */
	public function display_role_has_cap() {
		$role_subscriber = get_role( 'subscriber' );

		\eoxia\View_Util::exec( 'digirisk', 'setting', 'capability/has-cap', array(
			'role_subscriber' => $role_subscriber,
		) );
	}

	/**
	 * Récupères la liste des utilisateurs pour les afficher dans la vue "capability/list".
	 *
	 * @since 6.4.0
	 *
	 * @param array $list_user_id La liste des utilisateurs à afficher. Peut être vide pour récupérer tous les utilisateurs.
	 */
	public function display_user_list_capacity( $list_user_id = array() ) {
		$current_page = ! empty( $_POST['next_page'] ) ? (int) $_POST['next_page'] : 1;
		$args_user    = array(
			'exclude' => array( 1 ),
			'offset'  => ( $current_page - 1 ) * $this->limit_user,
			'number'  => $this->limit_user,
		);

		if ( ! empty( $list_user_id ) ) {
			$args_user['include'] = $list_user_id;
		}

		$users = User_Class::g()->get( $args_user );

		unset( $args_user['offset'] );
		unset( $args_user['number'] );
		unset( $args_user['include'] );
		$args_user['fields'] = array( 'ID' );

		$count_user  = count( User_Class::g()->get( $args_user ) );
		$number_page = ceil( $count_user / $this->limit_user );

		$role_subscriber      = get_role( 'subscriber' );
		$has_capacity_in_role = ! empty( $role_subscriber->capabilities['manage_digirisk'] ) ? true : false;

		if ( ! empty( $users ) ) {
			foreach ( $users as &$user ) {
				$user->data['wordpress_user'] = new \WP_User( $user->data['id'] );
			}
		}

		\eoxia\View_Util::exec( 'digirisk', 'setting', 'capability/list', array(
			'users'                => $users,
			'has_capacity_in_role' => $has_capacity_in_role,
			'number_page'          => $number_page,
			'count_user'           => $count_user,
			'current_page'         => $current_page,
		) );
	}
}

Setting_Class::g();
