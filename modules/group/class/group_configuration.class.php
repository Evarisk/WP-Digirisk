<?php
/**
 * Appelle la vue pour afficher le formulaire de configuration d'un groupement
 *
 * @author Jimmy Latour <jimmy@evarisk.com>
 * @version 6.2.1.0
 * @copyright 2015-2016 Eoxia
 * @package group
 * @subpackage class
 */

namespace digi;

if ( ! defined( 'ABSPATH' ) ) { exit; }

/**
 * Appelle la vue pour afficher le formulaire de configuration d'un groupement
 */
class Group_Configuration_Class extends Singleton_Util {

	/**
	 * Le constructeur
	 *
	 * @return void
	 */
	protected function construct() {}

	/**
	 * Charges le responsable et l'addresse du groupement.
	 * Envois les données à la vue group/configuration-form.view.php
	 *
	 * @param  Group_Model $element L'objet groupement.
	 * @return void
	 */
	public function display( $element ) {
		$address = $this->get_address( $element );
		$address = $address[0];

		view_util::exec( 'group', 'configuration-form', array( 'element' => $element, 'address' => $address ) );
	}

	/**
	 * Récupères l'adresse du groupement
	 *
	 * @param  Group_Model $groupment L'objet groupement.
	 * @return Address_Model        L'adresse du groupement ou le schéma d'une adresse.
	 */
	public function get_address( $groupment ) {
		$args_address = array( 'schema' => true );

		if ( ! empty( $groupment->contact['address_id'] ) ) {
			$args_address = array( 'comment__in' => array( max( $groupment->contact['address_id'] ) ) );
		}

		$address = Address_Class::g()->get( $args_address );

		return $address;
	}

	/**
	 * Sauvegardes les données du groupements
	 *
	 * @param  array $data  Les données à sauvegarder.
	 * @return Group_Model Le groupement mis à jour.
	 */
	public function save( $data ) {
		$group = group_class::g()->update( $data );
		return $group;
	}
}

group_configuration_class::g();
