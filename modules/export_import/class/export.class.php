<?php if ( !defined( 'ABSPATH' ) ) exit;
/**
* Fichier de gestion des actions pour le tableau de bord de Digirisk / File for managing Digirisk dashboard
*
* @author Alexandre Techer <dev@evarisk.com>
* @since 6.1.5.5
* @copyright 2015-2016 Evarisk
* @package Digirisk\dashboard
* @subpackage class
*/

/**
* Classe de gestion des actions pour les exports et imports des données de Digirisk / Class for managing export and import for Digirisk datas
*
* @author Alexandre Techer <dev@evarisk.com>
* @since 6.1.5.5
* @copyright 2015-2016 Evarisk
* @package Digirisk\dashboard
* @subpackage class
*/
class export_class extends singleton_util {

	/**
	 * Constructeur de la classe. Doit être présent même si vide pour coller à la définition "abstract" des parents / Class constructor. Must be present even if empty for matchin with "abstract" definition of ancestors
	 */
	function construct() {}

	/**
	 * Fonction d'export des données pour un élément donné / Export datas for a given element
	 *
	 * @param int $element_id L'identifiant de l'élément pour lequel il faut exporter les données / The element identifier we want to export datas for
	 * @param array $what_to_export Une liste contenant les types de contenus a exporter / A list of element type to export
	 *
	 * @return array L'élément exporté au format demandé / Element exported into the requested format
	 */
	function export( $element_id, $what_to_export = array( ) ) {
		/** Récupération de la définition de l'élément passé en paramètre / Get the definition of given element */
		$element = society_class::g()->show_by_type( $element_id );
		$element_to_export = new wpeo_export_class( $element );
		$data_exported = $element_to_export->export();

		/** Dans le cas ou l'élément actuel est un groupement on va chercher tous les sous éléments dans l'arbre ( groupements et unités de travail ) / In case current element is a group, we have to get all exiting children into tree ( groups and workunit ) */
		if ( 'digi-group' == $element->type ) {
			/** Récupération de la liste des enfants (groupement et unité de travail) du groupement actuel / Get children list (group and workunit) for current group */
			$group_children_list = group_class::g()->get_group_children( $element_id );

			/** Lecture de la liste des enfants pour la construction du fichier d'export / Read children list in order to build export file */
			if ( !empty( $group_children_list ) && is_array( $group_children_list ) ) {
				foreach ( $group_children_list as $children ) {
					$children_type = $children->type;
					if ( in_array( $children_type, $what_to_export ) ) {
						if ( !isset( $data_exported[$children_type] ) ) {
							$data_exported[$children_type] = array();
						}
						/** On empile chaque élément dans un sous index de l'objet ayant comme clé le type de l'élément / Push each element into a sub-index of the object having as key its type */
						array_push( $data_exported[$children_type], $this->export( $children->id, $what_to_export ) );
					}
				}
			}
		}

		/** Récupération de la liste des risques pour l'élément actuel / Get risks list for current element */
		$risk_type = risk_class::g()->get_post_type();
		if ( in_array( $risk_type, $what_to_export ) ) {
			$risk_list = risk_class::g()->index( array( 'post_parent' => $element_id ) );
			if ( !empty( $risk_list ) ) {
				if ( !isset( $data_exported[$risk_type] ) ) {
					$data_exported[$risk_type] = array();
				}

				foreach ( $risk_list as $risk ) {
					$risk =  risk_class::g()->get_risk( $risk->id );
					$risk_to_export = new wpeo_export_class( $risk );
					$data_risk_exported = $risk_to_export->export();
					array_push( $data_exported[$risk_type], $data_risk_exported );
				}
			}
		}

		return $data_exported;
	}

}
