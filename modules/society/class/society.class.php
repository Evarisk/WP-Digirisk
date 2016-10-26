<?php namespace digi;

if ( !defined( 'ABSPATH' ) ) exit;
/**
 * Fichier du controlleur principal de l'extension digirisk pour wordpress / Main controller file for digirisk plugin
 *
 * @author Evarisk development team <dev@evarisk.com>
 * @version 6.0
 */

/**
 * Classe du controlleur principal de l'extension digirisk pour wordpress / Main controller class for digirisk plugin
 *
 * @author Evarisk development team <dev@evarisk.com>
 * @version 6.0
 */
class society_class extends singleton_util {

	/**
	 * Instanciation principale de l'extension / Plugin instanciation
	 */
	protected function construct() {
	}



	/**
	 * AFFICHAGE/DISPLAY - Affichage de l'écran principal pour la gestion de la structure de la société et l'évaluation des risques / Display main screen for society management and risk evaluation
	 */
	public function display_dashboard() {
		\digi\log_class::g()->start_ms( 'display_dashboard' );

		$group_list = group_class::g()->get(
			array(
				'posts_per_page' => -1,
				'post_parent' => 0,
				'post_status' => array( 'publish', 'draft', ),
				'order' => 'ASC'
			), array( 'list_group' ) );

		if ( !empty( $group_list ) ) {
			if ( !empty( $_GET['society_id'] ) ) {
				$society = society_class::g()->show_by_type( $_GET['society_id'], array( 'list_group', 'list_workunit' ) );
				$society_parent = society_class::g()->show_by_type( $society->parent_id, array( 'list_group', 'list_workunit' ) );
			}
			else {
				$society = $group_list[0];
				$society_parent = $group_list[0];
				$tmp_group = group_class::g()->get( array( 'include' => $group_list[0]->id ), array( 'list_group', 'list_workunit' ) );
				$group_list[0] = $tmp_group[0];
			}
		}

		view_util::exec( 'society', 'dashboard', array( 'society_parent' => $society_parent, 'society' => $society, 'group_list' => $group_list ) );
		\digi\log_class::g()->exec( 'digi_callback_admin_menu', 'display_dashboard', 'Réponse callback_admin_menu' );
	}

	/**
	* Récupères l'objet par rapport à son post type
	*
	* @param int $id L'ID de l'objet
	* @param bool $cropped (Optional) Récupères toutes les données si false
	*
	* @return object L'objet
	*/
	public function show_by_type( $id, $child_wanted = array() ) {
		$id = (int) $id;

		if ( !is_int( (int)$id ) ) {
			return false;
		}

    $post_type = get_post_type( $id );

		if ( !$post_type ) {
			return false;
		}

    $model_name = '\digi\\' . str_replace( 'digi-', '', $post_type ) . '_class';
    $establishment = $model_name::g()->get( array( 'id' => $id ), $child_wanted );

    return $establishment[0];
  }

	/**
	* Met à jour par rapport au post type de l'objet
	*
	* @param object $establishment L'objet à mêttre à jour
	*
	* @return object L'objet mis à jour
	*/
	public function update_by_type( $establishment ) {
		if ( !is_object( $establishment ) && !is_array( $establishment ) ) {
			return false;
		}

		$type = ( is_object( $establishment ) && isset( $establishment->type ) ) ? $establishment->type : '';

		if ( empty( $type ) ) {
			$type = ( is_array( $establishment ) && !empty( $establishment['type'] ) ) ? $establishment['type'] : '';
		}

		if ( empty( $type ) ) {
			return false;
		}

		$model_name = '\digi\\' . str_replace( 'digi-', '', $type ) . '_class';

		if ( $model_name === '\digi\_class' ) {
			return false;
		}

		$establishment = $model_name::g()->update( $establishment );
		return $establishment;
	}
}

society_class::g();
