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
class Causerie_Filter extends Identifier_Filter {

	public function __construct() {
		parent::__construct();

		$current_type = Causerie_Class::g()->get_type();
		add_filter( "eo_model_digi-causerie_after_get", array( $this, 'get_full_causerie' ), 10, 2 );
		add_filter( "eo_model_digi-causerie_after_put", array( $this, 'get_full_causerie' ), 10, 2 );
		add_filter( "eo_model_digi-final-causerie_after_get", array( $this, 'get_full_causerie' ), 10, 2 );
		add_filter( "eo_model_digi-final-causerie_after_put", array( $this, 'get_full_causerie' ), 10, 2 );
	}

	/**
	 * [public description]
	 * @var [type]
	 */
	public function callback_digi_document_identifier( $unique_identifier, $causerie ) {
		$unique_identifier = $causerie->unique_identifier . '_' . $causerie->second_identifier . '_';
		return $unique_identifier;
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
	public function get_full_causerie( $object, $args ) {
		if ( ! empty( $object->data['id'] ) ) {
			$object->data['risk_category'] = Risk_Category_Class::g()->get( array(
				'id' => end( $object->data['taxonomy'][ Risk_Category_Class::g()->get_type() ] ),
			), true );

			$object->data['exclude_user_ids'] = '';

			if ( ! empty( $object->data['former']['user_id'] ) ) {
				$object->data['exclude_user_ids'] = $object->data['former']['user_id'] . ',';
			}

			$object->data['former']['rendered'] = null;

			if ( ! empty( $object->data['former']['user_id'] ) ) {
				$object->data['former']['rendered'] = User_Class::g()->get( array( 'id' => $object->data['former']['user_id'] ), true );
			}

			if ( ! empty( $object->data['participants'] ) ) {
				foreach ( $object->data['participants'] as &$participant ) {
					if ( ! empty( $participant['user_id'] ) ) {
						$participant['rendered'] = User_Class::g()->get( array( 'id' => $participant['user_id'] ), true );
						$object->data['exclude_user_ids'] .= $participant['user_id'] . ',';
					}
				}
			}

			$object->data['exclude_user_ids'] = substr( $object->data['exclude_user_ids'], 0, -1 );

			$object->data['sheet'] = Sheet_Causerie_Class::g()->get( array(
				'posts_per_page' => 1,
				'post_parent'    => $object->data['id'],
			), true );
		}

		return $object;
	}
}

new Causerie_Filter();
