<?php if ( !defined( 'ABSPATH' ) ) exit;


/**
 * CRUD Functions pour les utilisateurs
 * @author Jimmy Latour
 * @version 0.1
 */
class user_class extends singleton_util {
	protected $model_name = 'user_model';
	protected $meta_key = '_wpeo_user';
	protected $base = 'user';
	protected $version = '0.1';

	public $element_prefix = 'U';

	/**
	 * Instanciation du controleur principal pour les éléments de type "user" dans wordpress / Instanciate main controller for "user" elements' type into wordpress
	 */
	protected function construct() {
		/**	Ajout des routes personnalisées pour les éléments de type "user" / Add specific routes for "user" elements' type	*/
		add_filter( 'json_endpoints', array( &$this, 'callback_register_route' ) );
	}

	/**
	* Met à jour un utilisateur
	*
	* @param array $data Les données à mêttre à jour
	*
	* @return object L'objet utilisateur
	*/
	public function update( $data ) {
		if ( !is_array( $data ) && !is_object( $data ) ) {
			return false;
		}

		if ( ( is_array( $data ) && empty( $data['id'] ) ) || ( is_object( $data) && empty( $data->id ) ) ) {
			return $this->create( $data );
		}
		else {

			$object = $data;

			if( is_array( $data ) ) {
				$object = new $this->model_name( $data, $this->meta_key );
			}

			wp_update_user( $object->do_wp_object() );

			/** On insert ou on met à jour les meta */
			if( !empty( $object->option ) ) {
				$cloned_object = clone $object;
				$cloned_object->save_meta_data( $object, 'update_user_meta', $this->meta_key );
			}
		}

		return $cloned_object;
	}

	/**
	* Créer un utilisateur
	*
	* @param array $data Les données à créer
	*
	* @return object L'objet utilisateur
	*/
	public function create( $data ) {
		if ( !is_array( $data ) && !is_object( $data ) ) {
			return false;
		}

		$object = $data;

		if( is_array( $data ) ) {
			$object = new $this->model_name( $data, $this->meta_key );
		}

		$array_object = $object->do_wp_object();

		if ( empty( $array_object['user_pass'] ) ) {
			$array_object['user_pass'] = wp_generate_password();
		}


		$object->id = wp_insert_user( $array_object );

		$object->option['user_info']['initial'] = $object->build_user_initial( $object );
		$object->option[ 'user_info' ][ 'avatar_color' ] = $object->avatar_color[ array_rand( $object->avatar_color, 1 ) ];

		/** On insert ou on met à jour les meta */
		if( !empty( $object->option ) ) {
			$cloned_object = clone $object;
			$cloned_object->save_meta_data( $object, 'update_user_meta', $this->meta_key );
		}


		return $cloned_object;
	}

	/**
	* Supprimes un utilisateur
	*
	* @param int $id L'ID de l'utilisateur
	*/
	public function delete( $id ) {
		wp_delete_user( $id );
	}

	/**
	* Récupères l'utilsiateur par son ID
	*
	* @param int $id L'ID de l'utilisateur
	* @param boolean $cropped Récupères toutes les données si false
	*
	* @return object L'objet utilisateur
	*/
	public function show( $id, $cropped = false ) {
 		$user = get_user_by( 'id', $id );
		$user = new $this->model_name( $user, $this->meta_key, $cropped );

		return $user;
	}

	/**
	* Indexes tous les utilisateurs
	*
	* @param array $args_where
	* @param bool $cropped Récupères toutes les données si false
	*
	* @return array La liste des utilisateurs
	*/
	public function index( $args_where = array( ), $cropped = false ) {
		$array_model = array();

		$array_user = get_users( $args_where );

		if( !empty( $array_user ) ) {
			foreach( $array_user as $key => $user ) {
				$array_model[$key] = new $this->model_name( $user, $this->meta_key, $cropped );
			}
		}

		return $array_model;
	}

}
