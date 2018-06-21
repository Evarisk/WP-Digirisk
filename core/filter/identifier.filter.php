<?php
/**
 * Gestion des filtres relatifs aux identifiants de DigiRisk.
 *
 * @author Evarisk <dev@evarisk.com>
 * @since 7.0.0
 * @version 7.0.0
 * @copyright 2015-2018 Evarisk
 * @package DigiRisk
 */

namespace digi;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Gestion des filtres relatifs aux identifiants de DigiRisk.
 */
class Identifier_Filter {

	/**
	 * Constructeur.
	 *
	 * @since 7.0.0
	 * @version 7.0.0
	 */
	public function __construct() {
		add_filter( 'eo_model_handle_schema', array( $this, 'callback_handle_schema' ), 10, 2 );

		$called_class = str_replace( '_Filter', '_Class', get_called_class() );
		$current_type = $called_class::g()->get_type();

		add_filter( "eo_model_{$current_type}_before_post", array( $this, 'construct_identifier' ), 10, 2 );
		add_filter( "eo_model_{$current_type}_after_get", array( $this, 'get_identifier' ), 10, 2 );
	}

	/**
	 * Ajoutes les entrées "unique_key" et "unique_identifier" dans tous les schémas de DigiRisk.
	 *
	 * @since 7.0.0
	 * @version 7.0.0
	 *
	 * @param  array  $schema     Le schéma.
	 * @param  string $req_method La méthode de la requête.
	 *
	 * @return array              Le schéma modifié.
	 */
	public function callback_handle_schema( $schema, $req_method ) {
		$schema['unique_key'] = array(
			'since'     => '6.1.6',
			'version'   => '7.0.0',
			'type'      => 'integer',
			'meta_type' => 'single',
			'field'     => '_wpdigi_unique_key',
		);

		$schema['unique_identifier'] = array(
			'since'     => '6.1.6',
			'version'   => '7.0.0',
			'type'      => 'string',
			'meta_type' => 'single',
			'field'     => '_wpdigi_unique_identifier',
		);

		return $schema;
	}


	/**
	 * Construit l'identifiant unique d'un modèle
	 *
	 * @since 6.0.0
	 * @version 7.0.0
	 *
	 * @param  array $data Les données du modèle.
	 * @param  array $args Les arguments supplémentaires.
	 *
	 * @return array       Les données du modèle avec l'identifiant
	 */
	public function construct_identifier( $data, $args ) {
		$model_name      = $args['model_name'];
		$controller_name = str_replace( 'model', 'class', $model_name );
		$controller_name = str_replace( 'Model', 'Class', $controller_name );
		$next_identifier = $this->get_last_unique_key( $controller_name );
		$next_identifier++;

		if ( empty( $data['unique_key'] ) ) {
			$data['unique_key'] = (int) $next_identifier;
		}

		if ( empty( $data['unique_identifier'] ) ) {
			$data['unique_identifier'] = $controller_name::g()->element_prefix . $next_identifier;
		}

		return $data;
	}

	/**
	 * Remplaces l'identifiant du modèle par l'identifiant personnalisé qui se trouve dans la BDD
	 *
	 * @since 6.0.0
	 * @version 7.0.0
	 *
	 * @param  object $object Les données du modèle.
	 * @param  array  $args   Les données de la requête.
	 *
	 * @return object       Les données du modèle avec l'identifiant personnalisé
	 */
	public function get_identifier( $object, $args ) {
		$object->data['modified_unique_identifier'] = '';

		$list_accronym = get_option( \eoxia\Config_Util::$init['digirisk']->accronym_option );
		$list_accronym = json_decode( $list_accronym, true );
		if ( isset( $object->data['type'] ) ) {
			$type = str_replace( 'digi-', '\\digi\\', $object->data['type'] );
			if ( ! empty( $type ) && class_exists( $type . '_class' ) ) {
				$type .= '_class';

				$element_prefix = $type::g()->element_prefix;

				if ( ! empty( $object->data['unique_identifier'] ) && ! empty( $list_accronym[ $element_prefix ] ) ) {
					$object->data['modified_unique_identifier'] = str_replace( $element_prefix, $list_accronym[ $element_prefix ]['to'], $object->data['unique_identifier'] );
				}
			}
		}

		return $object;
	}

	/**
	 * Renvoie la dernière clé unique selon le type de l'élement
	 *
	 * @since 6.3.1
	 * @version 6.5.0
	 *
	 * @param string $controller Le nom du controller.
	 *
	 * @return int               L'identifiant unique
	 */
	public static function get_last_unique_key( $controller ) {
		$element_type = $controller::g()->get_type();
		$wp_type      = $controller::g()->get_identifier_helper();

		if ( empty( $wp_type ) || empty( $element_type ) || ! is_string( $wp_type ) || ! is_string( $element_type ) ) {
			return false;
		}

		global $wpdb;

		switch ( $wp_type ) {
			case 'post':
			case 'attachment':
				$query = $wpdb->prepare(
					"SELECT max( PM.meta_value + 0 )
					FROM {$wpdb->postmeta} AS PM
						INNER JOIN {$wpdb->posts} AS P ON ( P.ID = PM.post_id )
					WHERE PM.meta_key = %s
						AND P.post_type = %s", '_wpdigi_unique_key', $element_type );
				break;

			case 'comment':
				$query = $wpdb->prepare(
					"SELECT max( CM.meta_value + 0 )
					FROM {$wpdb->commentmeta} AS CM
						INNER JOIN {$wpdb->comments} AS C ON ( C.comment_ID = CM.comment_id )
					WHERE CM.meta_key = %s
						AND C.comment_type = %s", '_wpdigi_unique_key', $element_type );
				break;

			case 'user':
				$query = $wpdb->prepare(
					"SELECT max( UM.meta_value + 0 )
					FROM {$wpdb->usermeta} AS UM
					WHERE UM.meta_key = %s", '_wpdigi_unique_key' );
				break;

			case 'term':
				$query = $wpdb->prepare(
					"SELECT max( TM.meta_value + 0 )
					FROM {$wpdb->term_taxonomy} AS T
						INNER JOIN {$wpdb->termmeta} AS TM ON ( T.term_id = TM.term_id )
					WHERE TM.meta_key = %s AND T.taxonomy=%s", '_wpdigi_unique_key', $element_type );
				break;
		}

		if ( ! empty( $query ) ) {
			$last_unique_key = $wpdb->get_var( $query );
		}

		if ( empty( $last_unique_key ) ) {
			return 0;
		}

		return $last_unique_key;
	}
}
