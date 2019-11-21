<?php
/**
 * Fichiers principal pour la gestion des mises à jour des plugins.
 *
 * @author Eoxia <dev@eoxia.com>
 * @since 1.0.0
 * @version 1.0.0
 * @copyright 2015-2018 Eoxia
 * @package EO_Framework\EO_Update_Manager\Class
 */

namespace eoxia;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! class_exists( '\eoxia\Update_Manager_Class' ) ) {

	/**
	 * Classe principale pour le module de mise à jour des données suite aux différentes version de l'extension
	 */
	class Update_Manager_Class extends \eoxia\Singleton_Util {

		/**
		 * Fonction construct obligatoire pour l'extend de singleton_util
		 */
		function construct(){}

		/**
		 * Affichage de la popup indiquant la nécessité d'une mise à jour des données.
		 *
		 * @param string $namespace Le namespace du plugin pour récupérer les variables.
		 * @param string $title     Le titre de la popup indiquant la mise à jour.
		 */
		function display_say_to_update( $namespace, $title ) {
			\eoxia\View_Util::exec( 'eo-framework', 'wpeo_update_manager', 'say-to-update', array(
				'namespace' => $namespace,
				'title'     => $title,
			) );
		}

	}

}
