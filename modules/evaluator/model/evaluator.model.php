<?php if ( !defined( 'ABSPATH' ) ) exit;
/**
 * Fichier contenant le modèle pour les utilisateurs / File containing the main user model
 *
 * @author Evarisk development team <dev@evarisk.com>
 * @version 6.0
 */

/**
 * Classe définissant le modèle pour les utilisateurs / Class defining the main user model
 *
 * @author Evarisk development team <dev@evarisk.com>
 * @version 6.0
 */
class wpdigi_evaluator_mdl_01 extends user_model {

	/**
	* Construit le modèle d'un utilisateur / Fill the user model
	*
	* @param array|WP_Object $object La définition de l'objet dans l'instance actuelle / Object currently present into model instance
	* @param string $meta_key Le nom de la metakey utilisée pour le rangement des données associées à l'élément / The main metakey used to store data associated to current object
	* @param boolean $cropped Permet de ne récupèrer que les données principales de l'objet demandé / If true, return only main informations about object
	*/
	public function __construct( $object, $field_wanted = array() ) {
		// Ajout de la date d'embauche dans le modèle
		$this->array_option['user_info']['hiring_date'] = array(
			'type'			=> 'string',
			'field_type' 	=> 'computed',
			'field'			=> 'digirisk_user_information_meta',
			'function'		=> 'wpdigi_evaluator_mdl_01::get_hiring_date',
			'default'		=> 0,
			'required'		=> false,
		);

		parent::__construct( $object, $field_wanted );
		/**     Création d'un code couleur pour l'utilisateur si inexistant ou utilisation du code couleur existant    */
		if ( empty( $this->option[ 'evaluator_info' ][ 'avatar_color' ] ) ) {
			global $wpdigi_evaluator_ctr;
			$this->option[ 'user_info' ][ 'avatar_color' ] = $this->avatar_color[ array_rand( $this->avatar_color, 1 ) ];
			$wpdigi_evaluator_ctr->update( $this );
		}
	}

	public static function get_hiring_date( $user ) {
		$user_information = get_the_author_meta( 'digirisk_evaluator_information_meta', $user->ID );
		$hiring_date = !empty( $user_information['digi_hiring_date'] ) ? $user_information['digi_hiring_date'] : current_time( 'Y-m-d' );

		return $hiring_date;
	}

}

?>
