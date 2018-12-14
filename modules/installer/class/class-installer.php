<?php
/**
 * Classe gérant l'installation de DigiRisk.
 *
 * @author    Evarisk <dev@evarisk.com>
 * @copyright (c) 2006-2018 Evarisk <dev@evarisk.com>.
 *
 * @license   AGPLv3 <https://spdx.org/licenses/AGPL-3.0-or-later.html>
 *
 * @package   DigiRisk\Classes
 *
 * @since     6.0.0
 */

namespace digi;

defined( 'ABSPATH' ) || exit;

/**
 * Installer class.
 */
class Installer_Class extends \eoxia\Singleton_Util {

	/**
	 * Constructor.
	 *
	 * @since 7.0.0
	 */
	protected function construct() {}

	/**
	 * Appelle la vue pour la page installeur
	 *
	 * @since 6.0.0
	 */
	public function setup_page() {
		$data = $this->get_installer_default_data();

		\eoxia\View_Util::exec( 'digirisk', 'installer', 'installer', array(
			'default_data' => $data,
		) );
	}

	public function create_install_society( $title ) {
		if ( empty( $title ) ) {
			return false;
		}

		$society = Society_Class::g()->create( array(
			'title'  => $title,
			'status' => 'publish',
		) );

		\eoxia\LOG_Util::log( sprintf( 'Installeur - Création de la société %s -> success.', $society->data['title'] ), 'digirisk' );

		return $society;
	}

	public function create_default_data( $society_id ) {
		$society_id = (int) $society_id;

		if ( empty( $society_id ) ) {
			return false;
		}

		$data = $this->get_installer_default_data();

		if ( ! $data ) {
			return false;
		}

		if ( ! empty( $data ) ) {
			foreach ( $data as $group_object ) {
				$group = Group_Class::g()->update( array(
					'title'       => $group_object->title,
					'post_parent' => $society_id,
					'status'      => 'inherit',
				) );

				if ( ! empty( $group_object->workunits ) ) {
					foreach ( $group_object->workunits as $workunit_object ) {
						$workunit = Workunit_Class::g()->update( array(
							'title'       => $workunit_object->title,
							'post_parent' => $group->data['id'],
							'status'      => 'inherit',
						) );
					}
				}
			}
		}

		return true;
	}

	public function get_installer_default_data() {
		$file_content = @file_get_contents( \eoxia\Config_Util::$init['digirisk']->installer->path . 'asset/json/default.json' );
		$data         = json_decode( $file_content );

		return $data;
	}
}

new Installer_Class();
