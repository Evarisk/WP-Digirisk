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
		$display_mode = 'simple';

		$group_list = group_class::get()->index( array( 'posts_per_page' => -1, 'post_parent' => 0, 'post_status' => array( 'publish', 'draft', ), ), false );
		$element_id = !empty( $group_list ) ? $group_list[0]->id : 0;

		require_once( wpdigi_utils::get_template_part( WPDIGI_STES_DIR, WPDIGI_STES_TEMPLATES_MAIN_DIR, $display_mode, 'dashboard' ) );
	}

	/**
	* Récupères l'objet par rapport à son post type
	*
	* @param int $id L'ID de l'objet
	* @param bool $cropped (Optional) Récupères toutes les données si false
	*
	* @return object L'objet
	*/
	public function show_by_type( $id, $cropped = false ) {
		if ( !is_int( $id ) || !is_bool( $cropped ) ) {
			return false;
		}

    $post_type = get_post_type( $id );

		if ( !$post_type ) {
			return false;
		}

    $model_name = str_replace( 'digi-', '', $post_type ) . '_class';
    $establishment = $model_name::get()->show( $id );

    return $establishment;
  }

	/**
	* Met à jour par rapport au post type de l'objet
	*
	* @param object $establishment L'objet à mêttre à jour
	*
	* @return object L'objet mis à jour
	*/
	public function update_by_type( $establishment ) {
		if ( !is_object( $establishment ) ) {
			return false;
		}
		
		$type = empty( $establishment->type ) ? $establishment['type'] : $establishment->type;
		$model_name = str_replace( 'digi-', '', $type ) . '_class';
		$establishment = $model_name::get()->update( $establishment );
		return $establishment;
	}
}

society_class::get();
