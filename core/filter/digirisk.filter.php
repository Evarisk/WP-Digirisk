<?php
/**
 * Gestion des filtres principaux de l'application.
 *
 * @author Jimmy Latour <jimmy@evarisk.com>
 * @since 6.2.5
 * @version 6.4.5
 * @copyright 2015-2018 Evarisk
 * @package DigiRisk
 */

namespace digi;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Gestion des filtres principaux de l'application.
 */
class Digirisk_Filter {

	/**
	 * Le constructeur
	 *
	 * @since 6.2.5
	 * @version 6.4.5
	 */
	public function __construct() {
		add_filter( 'upload_size_limit', array( $this, 'callback_upload_size_limit' ) );
		add_filter( 'task_manager_get_tasks_args', array( $this, 'callback_task_manager_get_tasks_args' ) );

		add_filter( 'site_transient_update_plugins', array( $this, 'stop_plugin_update' ) );
	}

	/**
	 * Modifie la valeur max pour upload un fichier.
	 *
	 * @param integer $size La valeur courante.
	 *
	 * @return integer La nouvelle valeur.
	 *
	 * @since 6.2.5.0
	 * @version 6.2.5.0
	 */
	public function callback_upload_size_limit( $size ) {
		return 1024 * 10000;
	}

	/**
	* Supprimes le paramètre 'post_parent' de la requête de récupération des tâches.
	*
	* @since 6.3.1
	* @version 6.3.1
	*/
	public function callback_task_manager_get_tasks_args( $param ) {
		$page = ( ! empty( $_REQUEST['page'] ) ) ? sanitize_text_field( $_REQUEST['page'] ) : '';
		if ( in_array( $page, array( 'wpeomtm-dashboard', '' ), true ) ) {
			unset( $param['post_parent'] );
		}

		return $param;
	}

	/**
	 * Empèches les mises à jour pour les plugins défini dans bloc_updates.
	 *
	 * @since 6.4.5
	 * @version 6.4.5
	 *
	 * @param  array $value La liste des plugins.
	 *
	 * @return array        La liste des plugins modifiée.
	 */
	public function stop_plugin_update( $value ) {

		if ( ! empty( \eoxia\Config_Util::$init['digirisk']->block_updates ) ) {
			foreach ( \eoxia\Config_Util::$init['digirisk']->block_updates as $plugin_slug ) {
				if ( ! empty( $value->response ) ) {
					foreach ( $value->response as $update_plugin_slug => $element ) {
						if ( strpos( $update_plugin_slug, $plugin_slug ) != false ) {
							unset( $value->response[ $update_plugin_slug ] );
							break;
						}
					}
				}
			}
		}

		return $value;
	}
}

new Digirisk_Filter();
