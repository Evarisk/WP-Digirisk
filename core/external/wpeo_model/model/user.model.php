<?php namespace digi;

if ( !defined( 'ABSPATH' ) ) exit;

class user_model extends constructor_data_class {

	/**
	 * Définition des couleurs pour les utilisateurs si ils n'ont pas de gravatar / Define color list for user that don't have gravatar
	 *
	 * @var array Une liste de couleurs prédéfinies pour les avatars / A pre-defined color for user avatar
	 */
	public $avatar_color = array(
		'e9ad4f',
		'50a1ed',
		'e05353',
		'e454a2',
		'47e58e',
		'734fe9',
	);

	/**
	 * Définition de l'url du site gravatar / Define gravatar website url
	 *
	 * @var string L'url du site gravatar permettant de récupérer le gravatar d'un utiilsateur / The gravatar main url for getting user gravatar
	 */
	private static $gravatar_url = 'http://www.gravatar.com/avatar/';

	/**
	 * Définition du modèle principal des utilisateurs / Main definition for user model
	 * @var array Les champs principaux d'un utilisateur / Main fields for a user
	 */
	protected $model = array(
		'id' => array(
			'type'		=> 'integer',
			'field'		=> 'ID',
		),
		'email' => array(
			'type'		=> 'string',
			'field'		=> 'user_email',
			'required'	=> true,
		),
		'login' => array(
			'type'		=> 'string',
			'field'		=> 'user_login',
			'required'	=> true,
		),
		'password' => array(
			'type'		=> 'string',
			'field'		=> 'user_pass',
			'required'	=> true,
		),
		'displayname' => array(
			'type'		=> 'string',
			'field'		=> 'display_name',
		),
		'date' => array(
			'type'		=> 'string',
			'field'		=> 'user_registered',
		),
		'avatar' => array(
			'type'			=> 'string',
			'meta_type' => 'single',
			'field'			=> 'avatar',
			'bydefault'	=> '',
		),
		'avatar_color' => array(
			'type'			=> 'string',
			'meta_type'	=> 'single',
			'field'			=> 'avatar_color',
			'bydefault'	=> '',
		),
		'initial'		=> array(
			'type'			=> 'string',
			'meta_type'	=> 'single',
			'field'			=> 'initial',
			'bydefault'	=> '',
		),
		'firstname'		=> array(
			'type'			=> 'string',
			'meta_type'	=> 'single',
			'field'			=> 'first_name',
			'bydefault'	=> '',
			'required'		=> true,
		),
		'lastname'		=> array(
			'type'			=> 'string',
			'meta_type'	=> 'single',
			'field'			=> 'last_name',
			'bydefault'	=> '',
			'required'		=> true,
		)
	);

	public function __construct( $object, $children_wanted = array(), $args = array() ) {
		/**	Instanciation du constructeur de modèle principal / Instanciate the main model constructor	*/
		parent::__construct( $object, $children_wanted, $args );
		//
		// /** If cropped don't get meta */
		// if ( !$cropped ) {
		// 	$user_meta = get_user_meta( $this->id );
		//
		// 	if ( !empty( $user_meta ) )
		// 		$user_meta = array_merge( $user_meta, get_user_meta( $this->id, $meta_key ) );
		// 	else
		// 		$user_meta = get_user_meta( $this->id, $meta_key );
		//
		// 	$internal_meta = !empty( $user_meta ) && !empty( $user_meta[ $meta_key ] ) && !empty( $user_meta[ $meta_key ][ 0 ] ) ? json_decode( $user_meta[ $meta_key ][ 0 ], true ) : null;
		//
		// 	if ( !empty( $this->array_option ) ) {
		// 		foreach( $this->array_option as $key => $array ) {
		// 			$this->option[ $key ] = $this->fill_value( $object, $user_meta, $key, $array, $internal_meta );
		// 		}
		// 	}
		// }
	}

	/**
	 * Retourne l'adresse url de l'image gravatar d'un utilisateur / Return the gravatar picture for a given user.
	 * Utilisation: il faut utiliser cette valeur dans l'attribut src de la balise image, c'est à ce moment qu'il faut définir les différents paramètres que l'on souhaite (Taille:?s=; Image par défaut:?d=[404|blank|...])
	 * Use: Use the value into src attribute of img html tag, parameters have to be set at this moment (Size:?s=; Default picture:?d=[404|blank|...])
	 * Documentation complète / Complete documentation : https://fr.gravatar.com/site/implement/images/
	 *
	 * @param object $user Les données de l'utilisateur courant / Current user data
	 *
	 * @return string L'adresse url du gravatar de l'utilisateur / The url address of current user gravatar
	 */
	public static function build_user_avatar_url( $user ) {
		if ( empty( $user ) || empty( $user->user_email ) )
			return self::$gravatar_url . '00000000000000000000000000000000?d=blank';

		return self::$gravatar_url . md5( $user->user_email );
	}

}
