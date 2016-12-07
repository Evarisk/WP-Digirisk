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

		$owner_user = $this->get_owner_user( $element );

		view_util::exec( 'group', 'configuration-form', array( 'element' => $element, 'owner_user' => $owner_user, 'address' => $address ) );
	}

	/**
	 * Récupères l'adresse du groupement
	 *
	 * @param  Group_Model $groupment L'objet groupement.
	 * @return Address_Model        L'adresse du groupement ou le schéma d'une adresse.
	 *
	 * @todo Déplacer cette méthode vers Group_Class
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
	 * Récupères le responsable du groupement
	 *
	 * @param  Group_Model $groupment L'objet groupement.
	 * @return User_Digi_Model				Le responsable du groupement
	 */
	public function get_owner_user( $groupment ) {
		$args_owner_user = array( 'schema' => true );

		if ( ! empty( $groupment->user_info['owner_id'] ) ) {
			$args_owner_user = array( 'include' => array( $groupment->user_info['owner_id'] ) );
		}

		$owner_user = User_Digi_Class::g()->get( $args_owner_user );

		return $owner_user[0];
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
