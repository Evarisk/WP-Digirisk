<?php
/**
 * Gestion des adresses
 *
 * @package Evarisk\Plugin
 */

namespace digi;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Gestion des adresses
 *
 * @author Jimmy Latour <jimmy.eoxia@gmail.com>
 * @version 1.1.0.0
 */
class Address_class extends Comment_class {

	/**
	 * Le modèle à utiliser
	 *
	 * @var string
	 */
	protected $model_name   = '\digi\address_model';

	/**
	 * Le type du commentaire
	 *
	 * @var string
	 */
	protected $comment_type = 'digi-address';
	/**
	 * La clé de la table comment_meta
	 *
	 * @var string
	 */
	protected $meta_key    	= '_wpdigi_address';

	/**
	 * L'url pour la Rest API
	 *
	 * @var string
	 */
	protected $base					= 'digirisk/address';

	/**
	 * La version pour l'url de la Rest API
	 *
	 * @var string
	 */
	protected $version = '0.1';

	/**
	 * Utilies le filtre pour ajouter la route dans la Rest API
	 *
	 * @return void nothing
	 */
	protected function construct() {
		add_filter( 'json_endpoints', array( $this, 'callback_register_route' ) );
	}

	/**
	 * Sauvegardes une adresse en utilisant le modèle
	 *
	 * @param  array $data 		Les données de l'adresse (voir le fichier ./modules/address/model/adress.model.php).
	 * @return address_model  Les données enregistrées
	 */
	public function save( $data ) {
		return $this->update( $data );
	}
}

Address_class::g();
