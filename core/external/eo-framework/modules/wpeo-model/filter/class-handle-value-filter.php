<?php
/**
 * Gestion des filtres globaux concernant les dates dans EO_Framework.
 *
 * @author Eoxia <dev@eoxia.com>
 * @since 1.0.0
 * @version 1.0.0
 * @copyright 2015-2018 Eoxia
 * @package EO_Framework\EO_Model\Filter
 */

namespace eoxia;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Gestion des filtres globaux concernant les dates dans EO_Framework.
 */
class Handle_Value_Filter {

	/**
	 * Initialisation et appel des différents filtres définis dans EO_Framework.
	 */
	public function __construct() {
		add_filter( 'eo_model_handle_value', array( $this, 'callback_eo_model_handle_value' ), 10, 4 );
	}

	/**
	 * Filtre permettant de construire un champs de type date à la construction d'un objet.
	 *
	 * @param mixed  $value          La valeur actuelle du champs qu'il faut formater selon le type wpeo_date.
	 * @param mixed  $current_object L'objet actuellement en cours de construction et qu'il faut remplir.
	 * @param array  $field_def      La définition complète du champs. Type / Valeur par défaut / Champs dans la base de données.
	 * @param string $req_method     Méthode HTTP actuellement appelée.
	 *
	 * @return mixed                 La valeur du champs actuellement traité. Si il s'agit bien d'un champs de type wpeo_date la valeur aura le format défini dans @see fill_date.
	 */
	public function callback_eo_model_handle_value( $value, $current_object, $field_def, $req_method ) {
		// Traitement spécial des champs date.
		if ( 'wpeo_date' === $field_def['type'] ) {
			// Dans le cas ou on construit un objet vide ou que l'on ne défini pas la date on prend la date courante (du WordPress) au format mysql.
			if ( null === $value ) {
				$value = current_time( 'mysql' );
			}

			// Construction du champs date pour le retourner dans l'objet en construction. On ne le construit que si la méthode HTTP actuelle "$req_method" est définie dans le model.
			if ( isset( $field_def['context'] ) && in_array( $req_method, $field_def['context'], true ) ) {
				$value = array(
					'raw'      => $value,
					'rendered' => Date_Util::g()->fill_date( $value ),
				);
			}

			if ( in_array( $req_method, array( 'PUT', 'POST' ), true ) && isset( $value['raw'] ) ) {
				$value = $value['raw'];
			}

		}

		// Traitement spécial pour les champs de type "float" on remplace systèmatiquement les "," par des "." obligatoires pour la base de données.
		if ( ( null !== $value ) && ! is_array( $value ) && ! is_object( $value ) && 'float' === $field_def['type'] ) {
			$value = (float) str_replace( ',', '.', $value );
		}

		// Si la méthode HTTP appelée est la méthode GET alors on enlève les "slash" en trop.
		if ( ( null !== $value ) && ( 'GET' === $req_method ) && ( 'string' === $field_def['type'] ) ) {
			$value = stripslashes( $value );
		}

		return $value;
	}

}

new Handle_Value_Filter();
