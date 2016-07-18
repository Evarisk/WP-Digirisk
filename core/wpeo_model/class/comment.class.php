<?php if ( !defined( 'ABSPATH' ) ) exit;

/**
 * CRUD Functions pour les comments
 * @author Jimmy Latour
 * @version 0.1
 */
class comment_class extends singleton_util {
	protected $model_name = 'comment_model';
	protected $meta_key = '_comment';
	protected $comment_type	= '';

	protected $base = 'comment';
	protected $version = '0.1';

	protected function construct() {
		/**	Ajout des routes personnalisées pour les éléments de type "commentaires" / Add specific routes for "comments" elements' type	*/
		add_filter( 'json_endpoints', array( &$this, 'callback_register_route' ) );
	}

	/**
	* Met à jour le commentaire et les meta.
	* Appelle la méthode create si l'objet ou le tableau n'a pas d'ID.
	*
	* @param array $data Les données envoyées
	*
	* @return object comment_model object
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
				$object = new $this->model_name( $data, $this->meta_key, false );

				// @TODO : Mettre au propre
				if ( empty( $object->date ) ) {
					$object->date = current_time( 'mysql' );
				}

				if ( $object->author_id == 0 ) {
					$object->author_id = get_current_user_id();
				}

				if ( $object->status == 0 ) {
					$object->status == -34070;
				}
			}
			wp_update_comment( $object->do_wp_object() );

			/** On insert ou on met à jour les meta */
			if( !empty( $object->option ) ) {
				$object->save_meta_data( $object, 'update_comment_meta', $this->meta_key );
			}

			return $object;
		}
	}

	/**
	* Créer le commentaire et les meta.
	*
	* @param array $data Les données envoyées
	*
	* @return object comment_model object
	*/
	public function create( $data ) {
		if ( !is_array( $data ) && !is_object( $data ) ) {
			return false;
		}

		$object = $data;

		if( is_array( $data ) ) {
			$object = new $this->model_name( $data, $this->meta_key );
			$object->type = $this->comment_type;

			// @TODO : Mettre au propre
			if ( empty( $object->date ) ) {
				$object->date = current_time( 'mysql' );
			}

			if ( $object->author_id == 0 ) {
				$object->author_id = get_current_user_id();
			}

			if ( $object->status == 0 ) {
				$object->status == -34070;
			}
		}

		$object->id = wp_insert_comment( $object->do_wp_object() );
		$cloned_object = clone $object;

		/** On insert ou on met à jour les meta */
		if( !empty( $object->option ) ) {
			$cloned_object->save_meta_data( $object, 'update_comment_meta', $this->meta_key  );
		}

		return $cloned_object;
	}

	/**
	* Supprimes un commentaire en utilisant son ID
	*
	* @param int $id (test: 10) L'id du commentaire
	*
	*/
	public function delete( $id ) {
		wp_delete_comment( $id );
	}

	/**
	* Récupères le commentaire dans la base de donnée et le transforme en objet selon le modèle
	*
	* @param int $id (test: 10) L'id du commentaire
	* @param bool $croppred (test: false) Récupère les meta si true.
	*
	* @return object comment_model object
	*/
	public function show( $id, $cropped = false ) {
		// if ( !is_int( $id ) || !is_bool( $cropped ) ) {
		// 	return false;
		// }

		$comment = get_comment( $id );

		$comment = new $this->model_name( $comment, $this->meta_key, $cropped );

		return $comment;
	}

	/**
	* Récupères tous les commentaires d'un post dans la base de donnée et le transforme en objet selon le modèle
	*
	* @param int $post_id (test: 10) Le post parent
	* @param array $args_where (test: parent => 9, status => -34070) Récupère les meta si true.
	* @param bool $croppred (test: false) Récupère les meta si true.
	*
	* @return object comment_model object
	*/
	public function index( $post_id = 0, $args_where = array( 'parent' => 0, 'status' => -34070, ), $cropped = false ) {
		if ( !is_int( $post_id ) || !is_array( $args_where ) ) {
			return false;
		}

		$array_model = array();

		$args = array(
			'post_id' 	=> $post_id,
		);

		if ( !empty( $this->comment_type ) )
			$args['type'] = $this->comment_type;

		$args = array_merge($args, $args_where);
		$array_comment = get_comments( $args );

		if( !empty( $array_comment ) ) {
			foreach( $array_comment as $comment ) {
				$array_model[] = new $this->model_name( $comment, $this->meta_key, $cropped );
			}
		}

		return $array_model;
	}

	/**
	* Renvoie le type du commentaire
	*
	* @return string Le type du commentaire
	*/
	public function get_type() {
		return $this->comment_type;
	}

	/**
	* Récupères la dernière ID enregistrée dans la base de donnée
	*
	* @return int La dernière ID
	*/
	public function get_last_entry() {
		global $wpdb;

		$query = "SELECT comment_ID FROM {$wpdb->comments} WHERE comment_type='$this->comment_type' ORDER BY comment_ID DESC LIMIT 0, 1";
		return $wpdb->get_var( $query );
	}
}
