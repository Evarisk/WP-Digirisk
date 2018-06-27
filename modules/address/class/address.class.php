<?php
/**
 * Classe gérant les adresses
 *
 * @author Evarisk <dev@evarisk.com>
 * @since 6.0.0
 * @version 7.0.0
 * @copyright 2015-2018 Evarisk
 * @package DigiRisk
 */

namespace digi;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Classe gérent les adresses
 */
class Address_Class extends \eoxia\Comment_Class {

	/**
	 * Le modèle à utiliser
	 *
	 * @var string
	 */
	protected $model_name = '\digi\Address_Model';

	/**
	 * Le type du commentaire
	 *
	 * @var string
	 */
	protected $type = 'digi-address';
	/**
	 * La clé de la table comment_meta
	 *
	 * @var string
	 */
	protected $meta_key = '_wpdigi_address';

	/**
	 * L'url pour la Rest API
	 *
	 * @var string
	 */
	protected $base = 'address';

	/**
	 * Préfixes pour les adresses
	 *
	 * @var string
	 */
	public $element_prefix = 'AD';

	/**
	 * La version pour l'url de la Rest API
	 *
	 * @var string
	 */
	protected $version = '0.1';

	/**
	 * Sauvegardes une adresse en utilisant le modèle
	 *
	 * @since 6.0.0
	 * @version 6.5.0
	 *
	 * @param  array $data    Les données de l'adresse (voir le fichier ./modules/address/model/adress.model.php).
	 * @return Address_Model  Les données enregistrées
	 */
	public function save( $data ) {
		$data['content'] = '';

		return $this->create( $data );
	}
}

Address_class::g();
