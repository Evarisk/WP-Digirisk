<?php
/**
 * Définition des données des utilisateurs
 *
 * @author Eoxia <dev@eoxia.com>
 * @since 0.1.0
 * @version 1.0.0
 * @copyright 2015-2018
 * @package EO_Framework\EO_Model\Model
 */

namespace eoxia;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! class_exists( '\eoxia\User_Model' ) ) {
	/**
	 * Définition des données des utilisateurs
	 */
	class User_Model extends Data_Class {

		/**
		 * Définition des différentes couleurs pour l'avatar
		 *
		 * @var array
		 */
		public $avatar_color = array( '50a1ed' );

		/**
		 * L'url pour l'avatar
		 *
		 * @var string
		 */
		private static $gravatar_url = 'http://www.gravatar.com/avatar/';

		/**
		 * Définition du modèle principal des utilisateurs
		 *
		 * @var array Les champs principaux d'un utilisateur
		 */
		protected $schema = array();

		/**
		 * Le constructeur
		 *
		 * @since 0.1.0
		 * @version 1.0.0
		 *
		 * @param array $data       Les données de l'objet.
		 * @param mixed $req_method Peut être "GET", "POST", "PUT" ou null.
		 */
		public function __construct( $data = null, $req_method = null ) {
			$this->schema['id'] = array(
				'type'    => 'integer',
				'field'   => 'ID',
				'default' => 0,
			);

			$this->schema['email'] = array(
				'type'     => 'string',
				'field'    => 'user_email',
				'required' => true,
				'default'  => '',
				'show_in_rest' => false,

			);

			$this->schema['login'] = array(
				'type'         => 'string',
				'field'        => 'user_login',
				'required'     => true,
				'show_in_rest' => false,
			);

			$this->schema['password'] = array(
				'type'         => 'string',
				'field'        => 'user_pass',
				'show_in_rest' => false,
			);

			$this->schema['displayname'] = array(
				'type'  => 'string',
				'field' => 'display_name',
			);

			$this->schema['date'] = array(
				'type'  => 'string',
				'field' => 'user_registered',
			);

			$this->schema['avatar'] = array(
				'type'      => 'string',
				'meta_type' => 'single',
				'field'     => 'avatar',
				'default'   => '',
			);

			$this->schema['avatar_color'] = array(
				'type'      => 'string',
				'meta_type' => 'single',
				'field'     => 'avatar_color',
				'default'   => '50a1ed',
			);

			$this->schema['initial'] = array(
				'type'      => 'string',
				'meta_type' => 'single',
				'field'     => 'initial',
				'default'   => '',
			);

			$this->schema['firstname'] = array(
				'type'         => 'string',
				'meta_type'    => 'single',
				'field'        => 'first_name',
				'default'      => '',
				'show_in_rest' => false,

			);

			$this->schema['lastname'] = array(
				'type'         => 'string',
				'meta_type'    => 'single',
				'field'        => 'last_name',
				'default'      => '',
				'show_in_rest' => false,

			);

			parent::__construct( $data, $req_method );
		}

		/**
		 * Retourne l'adresse url de l'image gravatar d'un utilisateur / Return the gravatar picture for a given user.
		 * Utilisation: il faut utiliser cette valeur dans l'attribut src de la balise image, c'est à ce moment qu'il faut définir les différents paramètres que l'on souhaite (Taille:?s=; Image par défaut:?d=[404|blank|...])
		 * Use: Use the value into src attribute of img html tag, parameters have to be set at this moment (Size:?s=; Default picture:?d=[404|blank|...])
		 * Documentation complète / Complete documentation : https://fr.gravatar.com/site/implement/images/
		 *
		 * @param object $user Les données de l'utilisateur courant / Current user data.
		 *
		 * @return string L'adresse url du gravatar de l'utilisateur / The url address of current user gravatar
		 */
		public static function build_user_avatar_url( $user ) {
			if ( empty( $user ) || empty( $user->user_email ) ) {
				return self::$gravatar_url . '00000000000000000000000000000000?d=blank';
			}

			return self::$gravatar_url . md5( $user->user_email );
		}

	}

} // End if().
