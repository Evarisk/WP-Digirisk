<?php if ( !defined( 'ABSPATH' ) ) exit;


/**
 * CRUD Functions pour les posts
 * @author Jimmy Latour
 * @version 0.1
 */
class post_class extends singleton_util {
	protected $model_name = 'post_model';
	protected $post_type = 'post';
	protected $meta_key = '_wpeo_post';
	protected $base = 'post';
	protected $version = '0.1';

	/**
	 * Instanciation du controleur principal pour les éléments de type "post" dans wordpress / Instanciate main controller for "post" elements' type into wordpress
	 */
	protected function construct() {
		/**	Ajout des routes personnalisées pour les éléments de type "post" / Add specific routes for "post" elements' type	*/
		add_filter( 'json_endpoints', array( &$this, 'callback_register_route' ) );
	}

	/**
	* Met à jour les données d'un post
	*
	* @param array $data
	*
	* @return object L'objet
	*/
	public function update( $data ) {
		// if ( !is_array ( $data ) && !is_object( $data ) ) {
		// 	return false;
		// }

		if ( ( is_array( $data ) && empty( $data['id'] ) ) || ( is_object( $data ) && empty( $data->id ) ) ) {
			return $this->create( $data );
		}
		else {
			$object = $data;

			if( is_array( $data ) ) {
				$object = new $this->model_name( $data, $this->meta_key );
			}

			wp_update_post( $object->do_wp_object() );

			/** On insert ou on met à jour les meta */
			if( !empty( $object->option ) ) {
				$object->save_meta_data( $object, 'update_post_meta', $this->meta_key );
			}

			/** On insert les terms */
			if ( !empty( $object->taxonomy ) ) {
				foreach( $object->taxonomy as $taxonomy => $array_value ) {
					if( !empty( $taxonomy ) && !empty( $array_value ) ) {
						wp_set_object_terms( $object->id, $array_value, $taxonomy );
					}
					else if( !empty( $taxonomy ) && empty( $array_value ) ) {
						wp_set_object_terms( $object->id, '', $taxonomy );
					}
				}
			}

			return $object;
		}
	}

	/**
	* Créer un post
	*
	* @param array $data
	*
	* @return object L'objet cloné
	*/
	public function create( $data ) {
		// if ( !is_array( $data ) && !is_object( $data ) ) {
		// 	return false;
		// }

		$object = $data;

		if( is_array( $data ) ) {
			$object = new $this->model_name( $data, $this->meta_key );
			$object->type = $this->post_type;
		}
		$object->id = wp_insert_post( $object->do_wp_object() );
		$cloned_object = clone $object;

		/** On insert ou on met à jour les meta */
		if( !empty( $object->option ) ) {
			$cloned_object->save_meta_data( $object, 'update_post_meta', $this->meta_key );
		}

		/** On insert les terms */
		if ( !empty( $cloned_object->taxonomy ) ) {
			foreach( $cloned_object->taxonomy as $taxonomy => $array_value ) {
				if( !empty( $taxonomy ) && !empty( $array_value ) ) {
					wp_set_object_terms( $cloned_object->id, $array_value, $taxonomy );
				}
			}
		}

		return $cloned_object;
	}

	/**
	* Supprimes un post
	*
	* @param int $id L'ID du post
	*
	*/
	public function delete($id) {
		wp_trash_post($id);
	}

	/**
	 * Récupère un élément et le retourne construit selon le modèle / Get an element and build datas with the model
	 *
	 * @param int $id L'identifiant de l'élément que l'on souhaite avoir / Element's identifier we want to get
	 * @param boolean $cropped Optionnal La fonction doit elle retourner le modèle entier ou uniquement les données principales / The function must return the entire model or only main datas
	 *
	 * @return object L'objet construit selon le modèle définit / Builded object by model structure
	 */
	public function show( $id, $cropped = false ) {

 		$post = get_post( $id );
		$post = new $this->model_name( $post, $this->meta_key, $cropped );

		return $post;
	}

	/**
	* Indexe la liste des posts
	*
	* array['post_parent'] (Optional) L'ID parent du post
	*
	* @param array $args_where
	* @param bool $cropped
	*
	* @return array La liste des posts
	*/
	public function index( $args_where = array( 'post_parent' => 0 ), $cropped = false ) {
		if ( !is_array( $args_where ) ) {
			return false;
		}

		$array_model = array();

		$args = array(
			'post_status' 		=> 'publish',
			'post_type' 		=> $this->post_type,
			'posts_per_page' 	=> -1,
		);

		$args = wp_parse_args( $args, $args_where );
		$array_post = get_posts( $args );

		if( !empty( $array_post ) ) {
			foreach( $array_post as $key => $post ) {
				$array_model[$key] = new $this->model_name( $post, $this->meta_key, $cropped );
			}
		}

		return $array_model;
	}

	/**
	* Recherche dans les metas des posts
	*
	* @param string $search La recherche.
	* @param array $array
	*
	* @return array La liste des posts trouvés
	*/
	public function search( $search, $array ) {
			global $wpdb;

			if( empty( $array ) || !is_array( $array ) )
				return array();

			$where = ' AND ( ';

			if ( !empty( $array ) ) {
			  foreach ( $array as $key => $element ) {
					if( is_array( $element ) ) {
						foreach( $element as $sub_element ) {
							$where .= $where == ' AND ( ' ? '' : ' OR ';
							$where .= ' (PM.meta_key="' . $sub_element . '" AND PM.meta_value LIKE "%'. $search . '%") ';
						}
					}
					else {
						$where .= $where == ' AND ( ' ? '' : ' OR ';
						$where .= ' P.' . $element . ' LIKE "%' . $search . '%" ';
					}
			  }
			}

			$where .= ' ) ';


			$list_group = $wpdb->get_results( "SELECT DISTINCT P.ID FROM {$wpdb->posts} as P JOIN {$wpdb->postmeta} AS PM ON PM.post_id=P.ID WHERE P.post_type='".$this->get_post_type()."'" . $where );

			$list_model = array();

			if ( !empty( $list_group ) ) {
			  foreach ( $list_group as $element ) {
					$list_model[] = $this->show( $element->ID );
			  }
			}

			return $list_model;
	}

	/**
	 * GETTER - Récupère tous les terms d'un post depuis sa définition dans le modèle / Get all term in post by the model definition
	 *
	 * @param array $object
	 * @return array Le tableau des terms id
	 */
	public static function eo_get_object_terms( $object ) {
		// if ( !is_array( $object ) || !is_object( $object ) ) {
		// 	return false;
		// }

		$list_term 		= array();
		$array_model 	= $object->get_model();

		if( !empty( $array_model ) && !empty( $array_model['taxonomy'] ) ) {
			foreach( $array_model['taxonomy'] as $key => $value ) {
				$list_term[$key] = wp_get_object_terms( $object->id, $key, array( 'fields' => 'ids' ) );

			}
		}

		return $list_term;
	}

	/**
	 * GETTER - Récupération du type de l'élément courant / Get the current element type
	 *
	 * @return string Le type d'élément courant / The current element type
	 */
	public function get_post_type() {
		return $this->post_type;
	}

	/**
	 * Retourne le nom d'un post selon son identifiant / Return a post title according to given identifier
	 *
	 * @param integer $post_id L'identifiant du post dont on veut récupérer le nom / The post identifier we want to get the name for
	 *
	 * @return boolean Le titre du post si il est trouvé, false dans le cas contraire / The post title in case it is founded, false in other case
	 */
	public function get_title_by_id( $post_id ) {
		if (  true !== is_int( ( int )$post_id ) )
			return false;

		$post_title = get_post_field( 'post_title', $post_id );

		return $post_title;
	}

	/**
	* Récupère la dernière entrée ajouté dans les posts et en rapport avec le post_type
	*
	* @return int L'ID de la dernière entrée
	*/
	public function get_last_entry() {
		global $wpdb;

		$query = "SELECT ID FROM {$wpdb->posts} WHERE post_type='$this->post_type' ORDER BY ID DESC LIMIT 0, 1";
		return $wpdb->get_var( $query );
	}
}
