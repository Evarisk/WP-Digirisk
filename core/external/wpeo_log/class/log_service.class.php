<?php
namespace digi;

if ( !defined( 'ABSPATH' ) ) exit;

class log_service_class extends singleton_util {
	protected function construct() {}

	/**
	* Crée un service par défaut et l'ajoutes au tableau JSON _wpeo_log_settings.
	* Renvoie un message de type updated en transient pour afficher qu'un
	* nouveau service à été crée.
	*
	* @param string $name Le nom du service
	* @return void
	*/
	public function add( $name ) {
		$data_service = array(
				'active' 		=> true,
				'name'			=> !empty( $name ) ? $name : 'new_log',
				'size' 			=> '1000000',
				'format' 		=> 'ko',
				'rotate'		=> false,
				'number' 		=> 0,
				'created_date'	=> current_time( 'mysql' ),
		);
		$array_current_settings = get_option( '_wpeo_log_settings' );
		if ( !empty( $array_current_settings ) ) {
			$array_current_settings = json_decode( $array_current_settings, true );
		}
		else {
			$array_current_settings = array();
		}
		$array_current_settings[] = $data_service;
		$success = update_option( '_wpeo_log_settings', json_encode( $array_current_settings ) );
		if ( $success ) {
			set_transient( 'log_message', json_encode( array( 'type' => 'updated', 'message' => __( 'A new service has been created!', 'digirisk' ) ) ) );
		}
		if ( !empty( $name ) ) {
			return $data_service;
		}
		else {
			wp_safe_redirect( wp_get_referer() );
			die();
		}
	}

	public function get_service_by_id( $id ) {
		$array_service = get_option( '_wpeo_log_settings', array() );
		$getted_service = null;
		if ( !empty( $array_service ) ) {
			$array_service = json_decode( $array_service, true );
			foreach ( $array_service as $key => $service ) {
				if( $key == $id ) {
					$getted_service = $service;
					break;
				}
			}
		}
		return $getted_service;
	}

	/**
	* Récupères le service selon son nom.
	*
	* @param string $name Le nom du service
	* @return array | null
	*/
	public static function get_service_by_name( $name ) {
		$array_service = get_option( '_wpeo_log_settings', array() );
		$getted_service = null;
		if ( !empty( $array_service ) ) {
			$array_service = !is_array( $array_service ) ? json_decode( $array_service, true ) : $array_service;
			foreach ( $array_service as $service ) {
				if( $service['name'] == $name ) {
					$getted_service = $service;
					break;
				}
			}
		}
		return $getted_service;
	}

	public function create_service( $service_name ) {
		$service = self::get_service_by_name( $service_name );

		if( $service == null ) {
		/** Créer le service s'il n'existe pas */
			$service = self::add( $service_name );
		}

		return $service;
	}
}

?>
