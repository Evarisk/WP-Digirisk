<?php
/**
 * Gestion des routes
 *
 * @author Eoxia <dev@eoxia.com>
 * @since 1.0.0
 * @version 1.0.0
 * @copyright 2015-2018
 * @package EO_Framework\EO_Model\Class
 */

namespace eoxia;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! class_exists( '\eoxia\Rest_Class' ) ) {
	/**
	 * Gestion des utilisateurs (POST, PUT, GET, DELETE)
	 */
	class Rest_Class extends Singleton_Util {

		/**
		 * [construct description]
		 */
		protected function construct() {
			add_action( 'rest_api_init', array( $this, 'register_routes' ), 20 );
		}

		/**
		 * Check user capability to access to element
		 *
		 * @param string $cap The capability name to check.
		 *
		 * @since 1.0.0
		 * @version 1.0.0
		 *
		 * @return string The rest api base for current element
		 */
		public function check_cap( $cap, $request ) {
			$can = apply_filters( 'eo_model_check_cap', true, $request );

			if ( ! $can ) {
				return false;
			}

			if ( ( ! in_array( $_SERVER['REMOTE_ADDR'], Config_Util::$init['eo-framework']->wpeo_model->allowed_ip_for_unauthentified_access_rest, true ) ) && ! current_user_can( $this->capabilities[ 'get' ] ) ) {
				return false;
			}

			return true;
		}

		/**
		 * Return the base for rest api.
		 *
		 * @since 1.0.0
		 * @version 1.0.0
		 *
		 * @return string The rest api base for current element
		 */
		public function get_rest_base() {
			return $this->base;
		}

		/**
		 * Défini et ajoute les routes dans l'api rest de WordPress
		 *
		 * @since 1.0.0
		 * @version 1.0.0
		 */
		public function register_routes() {
			$element_namespace = new \ReflectionClass( get_called_class() );
			register_rest_route( $element_namespace->getNamespaceName() . '/v' . Config_Util::$init['eo-framework']->wpeo_model->api_version, '/' . $this->base . '/schema', array(
				array(
					'method'   => \WP_REST_Server::READABLE,
					'callback' => array( $this, 'get_schema' ),
				),
			) );

			register_rest_route( $element_namespace->getNamespaceName() . '/v' . Config_Util::$init['eo-framework']->wpeo_model->api_version, '/' . $this->base, array(
				array(
					'methods'             => \WP_REST_Server::READABLE,
					'callback'            => array( $this, 'get_from_parent' ),
					'permission_callback' => function( $request ){
						return Rest_Class::g()->check_cap( 'get', $request );
					}
				),
				array(
					'methods'             => \WP_REST_Server::CREATABLE,
					'callback'            => array( $this, 'create_from_parent' ),
					'permission_callback' => function( $request ){
						return Rest_Class::g()->check_cap( 'post', $request );
					}
				),
			), true );

			register_rest_route( $element_namespace->getNamespaceName() . '/v' . Config_Util::$init['eo-framework']->wpeo_model->api_version, '/' . $this->base . '/(?P<id>[\d]+)', array(
				array(
					'method'              => \WP_REST_Server::READABLE,
					'callback'            => array( $this, 'get_from_parent' ),
					'permission_callback' => function( $request ){
						return Rest_Class::g()->check_cap( 'get', $request );
					},
				),
				array(
					'methods'             => \WP_REST_Server::CREATABLE,
					'callback'            => array( $this, 'create_from_parent' ),
					'permission_callback' => function( $request ){
						return Rest_Class::g()->check_cap( 'put', $request );
					}
				),
			), true );

			register_rest_route( $element_namespace->getNamespaceName() . '/v' . Config_Util::$init['eo-framework']->wpeo_model->api_version, '/' . $this->base . 's/(?P<id>[\d]+)', array(
				array(
					'method'              => \WP_REST_Server::READABLE,
					'callback'            => array( $this, 'get_parent_from_parent' ),
					'permission_callback' => function( $request ){
						return Rest_Class::g()->check_cap( $request, 'get' );
					}
				),
			), true );

		}

		/**
		 * Get element(s) from parent object type
		 *
		 * @since 1.0.0
		 * @version 1.0.0
		 *
		 * @param  WP_Http::request $request The current Rest API request.
		 *
		 * @return mixed                     Element list or single element if id was specified.
		 */
		public function get_from_parent( $request ) {
			$args   = array();
			$single = false;
			$list   = null;

			if ( ! empty( $request ) && ( ! empty( $request['id'] ) ) ) {
				$args['id'] = $request['id'];
				$single     = true;
			}

			$elements = $this->get( $args, $single );
			if ( ! empty( $elements ) ) {
				if ( $single ) {
					$list[] = $elements;
				} else {
					foreach ( $elements as $element ) {
						$list[] = $element;
					}
				}
			}

			$new_list = null;

			if ( ! empty( $list ) ) {
				foreach ( $list as $element ) {
					if ( ! empty( $element->get_model() ) ) {
						foreach ( $element->get_model() as $key => $model ) {
							if ( isset( $element->data[ $key ] ) && ( isset( $model['show_in_rest'] ) && ! $model['show_in_rest'] ) ) {
								unset( $element->data[ $key ] );
							}
						}
					}

					$new_list[] = $element->data;
				}
			}

			if ( $single ) {
				$list = $list[0];
			}

			return $list;
		}

		/**
		 * Get element(s) from parent object type
		 *
		 * @since 1.0.0
		 * @version 1.0.0
		 *
		 * @param  WP_Http::request $request The current Rest API request.
		 *
		 * @return mixed                     Element list or single element if id was specified.
		 */
		public function get_parent_from_parent( $request ) {
			$args   = array();
			$single = false;

			if ( ! empty( $request ) && ( ! empty( $request['id'] ) ) ) {
				$args['post_id'] = $request['id'];
				$args['status']  = '1';
				$single          = true;
			}

			return $this->get( $args, $single );
		}

		/**
		 * Create / Update element from request
		 *
		 * @since 1.6.0
		 * @version 1.6.0
		 *
		 * @param  WP_Http::request $request The current Rest API request.
		 *
		 * @return mixed                     New created element.
		 */
		public function create_from_parent( $request ) {
			$params = $request->get_params();

			if ( isset( $params['id'] ) ) {
				$params['id'] = (int) $params['id'];

				$object       = $this->get( array( 'id' => $params['id'] ), true );
				$object->data = wp_parse_args( $params, $object->data );

				return $this->update( $object->data );
			} else {
				return $this->update( $params );
			}
		}

	}

}
