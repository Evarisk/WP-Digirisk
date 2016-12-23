<?php
/**
 * Gestion des modèles personnalisés
 *
 * @since 6.1.5.5
 * @version 6.2.3.0
 *
 * @package Evarisk\Plugin
 */

namespace digi;

if ( ! defined( 'ABSPATH' ) ) { exit; }

/**
 * Gestion des modèles personnalisés
 */
class Handle_Model_Class extends Singleton_Util {

	/**
	 * La liste des documents personnalisables avec leur titre
	 *
	 * @var array
	 */
	private $list_type_document = array(
		'document_unique' => 'Document unique',
		'fiche_de_groupement' => 'Fiche de groupement',
		'fiche_de_poste' => 'Fiche de poste',
		'affichage_legal_A3' => 'Affichage légal A3',
		'affichage_legal_A4' => 'Affichage légal A4',
	);

	/**
	 * Le constructeur
	 *
	 * @return void
	 */
	protected function construct() {}

	/**
	 * Appelle la vue main.view.php pour afficher la gestion des modèles personnalisés.
	 *
	 * @return void
	 */
	public function display() {
		$list_document_default = array();

		if ( ! empty( $this->list_type_document ) ) {
			foreach ( $this->list_type_document as $key => $element ) {
				$list_document_default[ $key ] = document_class::g()->get_model_for_element( array( $key, 'model', 'default_model' ) );
			}
		}

		view_util::exec( 'handle_model', 'main', array( 'list_type_document' => $this->list_type_document, 'list_document_default' => $list_document_default ) );
	}
}

Handle_Model_Class::g();
