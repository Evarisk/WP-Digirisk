<?php if ( !defined( 'ABSPATH' ) ) exit;
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
		/*	Création du menu dans l'administration pour le module digirisk / Create the administration menu for digirisk plugin */
		add_action( 'admin_menu', array( $this, 'callback_admin_menu' ), 12 );
	}

	/**
	 * Définition du menu dans l'administration de wordpress pour Digirisk / Define the menu for wordpress administration
	 */
	public function callback_admin_menu() {
		/**	Création du menu de gestion de la société et de l'évaluation des risques / Create the menu for society strcuture management and risk evaluation	*/
		$digirisk_core = get_option( WPDIGI_CORE_OPTION_NAME );

		if ( !empty( $digirisk_core['installed'] ) ) {
			add_menu_page( __( 'Digirisk : Risk evaluation', 'digirisk' ), __( 'Digirisk', 'digirisk' ), 'manage_options', 'digirisk-simple-risk-evaluation', array( &$this, 'display_dashboard' ), WPDIGI_URL . 'core/assets/images/favicon.png', 4);
		}
	}

	/**
	 * AFFICHAGE/DISPLAY - Affichage de l'écran principal pour la gestion de la structure de la société et l'évaluation des risques / Display main screen for society management and risk evaluation
	 */
	public function display_dashboard() {
		$group_list = group_class::g()->get(
			array(
				'posts_per_page' => -1,
				'post_parent' => 0,
				'post_status' => array( 'publish', 'draft', ),
				'order' => 'ASC'
			), array( 'list_group' ) );

		if ( !empty( $group_list ) ) {
			$society = $group_list[0];
			$tmp_group = group_class::g()->get( array( 'include' => $group_list[0]->id ), array( 'list_group', 'list_workunit' ) );
			$group_list[0] = $tmp_group[0];
			$element_id = !empty( $group_list ) ? $group_list[0]->id : 0;
		}

		$path = wpdigi_utils::get_template_part( WPDIGI_STES_DIR, WPDIGI_STES_TEMPLATES_MAIN_DIR, 'simple', 'dashboard' );
		if( $path ) {
			require_once( $path );
		}

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

    $model_name = str_replace( 'digi-', '', $post_type ) . '_class';
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

		$model_name = str_replace( 'digi-', '', $type ) . '_class';

		if ( $model_name === '_class' ) {
			return false;
		}

		$establishment = $model_name::g()->update( $establishment );
		return $establishment;
	}
}

society_class::g();
