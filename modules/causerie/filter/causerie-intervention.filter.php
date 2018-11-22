<?php
/**
 * La classe gérant les filtres des causeries
 *
 * @author    Evarisk <dev@evarisk.com>
 * @since     6.6.0
 * @version   6.6.0
 * @copyright 2018 Causerie.
 * @package   DigiRisk
 */

namespace digi;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * La classe gérant les filtres des causeries
 */
class Causerie_Intervention_Filter extends Identifier_Filter {

	public function __construct() {
		$current_type = Causerie_Class::g()->get_type();
		add_filter( "eo_model_digi-final-causerie_after_get", array( $this, 'get_full_causerie_intervention' ), 11, 2 );
	}

	/**
	 * Récupères tous les éléments nécessaires pour le fonctionnement d'une causerie
	 * - Catégorie de risque
	 * - Participants
	 * - Formateur
	 *
	 * @since   6.6.0
	 *
	 * @param  Causerie_Model $data L'objet.
	 * @return Causerie_Model L'objet avec tous les éléments ajoutés par cette méthode.
	 */
	public function get_full_causerie_intervention( $object, $args ) {
		if ( ! empty( $object->data['id'] ) ) {
			$object->data['sheet_intervention'] = Sheet_Causerie_Intervention_Class::g()->get( array(
				'posts_per_page' => 1,
				'post_parent'    => $object->data['id'],
			), true );
		}

		return $object;
	}
}

new Causerie_Intervention_Filter();
