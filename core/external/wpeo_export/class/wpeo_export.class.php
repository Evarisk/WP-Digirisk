<?php namespace digi;

if ( !defined( 'ABSPATH' ) ) exit;

class wpeo_export_class {
	protected $_instance;

	/**
	* Get the $instance of the object to export
	*
	* @param constructor_data_class $instance The instance of the object to export
	*/
	public function __construct( constructor_data_class $instance ) {
		$this->_instance = $instance;
		$this->list_data_to_export = array();
	}

	/**
	* Call get_field_to_export
	* And fill the list_data_to_export array with the values of the exported fields
	*
	* @return array The list of exported values
	*/
	public function export( $field_to_export = array(), $current_data = null ) {
		if ( $this->_instance ) {

			if ( empty( $field_to_export ) ) {
				$list_data_to_export = array();
				$field_to_export = $this->get_field_to_export( $this->_instance->get_model() );
				$current_data = $this->_instance;
			}


			if ( $field_to_export ) {
				foreach ( $field_to_export as $name => $key ) {
					if ( $name !== 'child' ) {
						$list_data_to_export[$key] = $current_data->$key;
					}
					else {
						if ( !empty( $key ) ) {
							foreach( $key as $k ) {
								if ( !empty( $current_data->$k ) ) {
									foreach( $current_data->$k as $data ) {
										$schema = $data->get_model();
										$field_to_export = $this->get_field_to_export( $schema );

										if ( !isset( $list_data_to_export[$k] ) ) {
											$list_data_to_export[$k] = array();
										}

										if ( !empty( $field_to_export ) ) {
											array_push( $list_data_to_export[$k], $this->export( $field_to_export, $data ) );
										}
									}
								}
							}
						}
					}
				}
			}


			return $list_data_to_export;
		}
	}

	/**
	* Get the model of the object (for defintion of all fields)
	* And fill the list_field_to_export when the defintion contains the key export as true
	*/
	private function get_field_to_export( $schema ) {
		$list_field_to_export = array();

		foreach ( $schema as $key => $def ) {
			if ( !empty( $def ) && !empty( $def['export'] ) ) {
				$list_field_to_export[] = $key;
			}
		}

		if ( !empty( $schema['child'] ) ) {
			foreach( $schema['child'] as $key => $def ) {
				if ( !empty( $def ) && !empty( $def['export'] ) ) {
					$list_field_to_export['child'][] = $key;
				}
			}
		}

		return $list_field_to_export;
	}
}
