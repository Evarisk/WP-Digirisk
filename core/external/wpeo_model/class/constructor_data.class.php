<?php namespace digi;

if ( ! defined( 'ABSPATH' ) ) { exit; }

class constructor_data_class extends helper_class {

	/**
	 * Constructeur
	 * @param [type] $data         [description]
	 * @param [type] $field_wanted [description]
	 * @param array  $args         [description]
	 */
	protected function __construct( $data ) {
		$this->dispatch_wordpress_data( $data, $data );
		log_class::g()->exec( 'digirisk_construct_data', '', __( 'Unable to transfer risk to wordpress system.', 'wp-digi-dtrans-i18n' ), array( 'object_id' => '', 'object' => $this, ), 0 );
	}

	private function dispatch_wordpress_data( $all_data, $data, $current_object = null, $model = array() ) {
		if ( empty( $model ) ) {
			$model = $this->model;
		}

		if ( $current_object === null ) {
			$current_object = $this;
		}

		foreach ( $model as $field_name => $field_def ) {
			$current_object->$field_name = $this->set_default_data( $field_name, $field_def );

			// Est-ce qu'il existe des enfants ?
			if ( isset( $field_def['field'] ) && isset( $data[$field_def['field']] ) && !isset( $field_def['child'] ) ) {
				$current_object->$field_name = $data[$field_def['field']];
			}
			else if ( isset( $field_def['child'] ) ) {
				$current_data = !empty( $all_data[$field_name] ) ? $all_data[$field_name] : array();

				if ( empty( $current_object->$field_name ) ) {
					$current_object->$field_name = new \stdClass();
				}

				$current_object->$field_name = $this->dispatch_wordpress_data( $all_data, $current_data, $current_object->$field_name, $field_def['child'] );
			}

			// Est-ce que le field_name existe en donnée (premier niveau) ?
			if ( isset( $data[$field_name] ) && isset( $field_def ) && !isset( $field_def['child'] ) ) {
				$current_object->$field_name = $data[$field_name];
			}

			if ( isset( $field_def['required'] ) && $field_def['required'] && !isset( $current_object->$field_name ) ) {
				$this->error = true;
			}

			if ( !empty( $field_def['type'] ) ) {
				settype( $current_object->$field_name, $field_def['type'] );
				if ( $field_def['type'] === 'string' ) {
					$current_object->$field_name = stripslashes( $current_object->$field_name );
				}

				if ( !empty( $field_def['array_type'] ) ) {
					if ( !empty( $current_object->$field_name ) ) {
					  foreach ( $current_object->$field_name as &$element ) {
							settype( $element, $field_def['array_type'] );
					  }
					}
				}
			}
		}

		return $current_object;
	}

	private function set_default_data( $field_name, $field_def ) {
		if ( isset( $field_def['bydefault'] ) ) {
			return $field_def['bydefault'];
		}
	}

	public function do_wp_object() {
		$object = array();

		foreach( $this->model as $field_name => $field_def ) {
			if( !empty( $field_def['field'] ) && isset( $this->$field_name ) )
				$object[ $field_def[ 'field' ] ] = $this->$field_name;
		}

		return $object;
	}

	public function parse_key( $def ) {
		$key = $def['value'];
		$custom = !empty( $def['custom'] ) ? $def['custom'] : '';

		switch( $custom ) {
			case "array":
				$key = $this->parse_key_array( $key );
				break;
			default:
				break;
		}

		return $key;
	}

	private function parse_key_array( $key ) {
		$key = str_replace( ']', '', $key );
		$key = explode( '[', $key );
		return $key;
	}

	private function parse_value( $key ) {
		if ( !is_array( $key ) ) {
			return $this->$key;
		}

		$value = $this->{$key[0]};
		array_shift( $key );

		if ( !empty( $key ) ) {
		  foreach ( $key as $k ) {
				if ( !empty( $value ) && !empty( $value[$k] ) ) {
					$value = $value[$k];
				}
		  }
		}

		return $value;
	}
}
