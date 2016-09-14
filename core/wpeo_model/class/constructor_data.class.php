<?php if ( !defined( 'ABSPATH' ) ) exit;

class constructor_data_class extends helper_class {
	protected function __construct( $data, $field_wanted ) {
		$this->dispatch_wordpress_data( $data, $data );
		$this->fill_child( $field_wanted );
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
			if ( isset( $field_def['child'] ) ) {
				$current_data = !empty( $all_data[$field_name] ) ? $all_data[$field_name] : array();

				if ( empty( $current_object->$field_name ) ) {
					$current_object->$field_name = new stdClass();
				}

				$current_object->$field_name = $this->dispatch_wordpress_data( $all_data, $current_data, $current_object->$field_name, $field_def['child'] );
			}
			elseif ( isset( $field_def['field'] ) && isset( $data[$field_def['field']] ) ) {
				$current_object->$field_name = $data[$field_def['field']];
			}

			// Est-ce que le field_name existe en donnée (premier niveau) ?
			if ( isset( $data[$field_name] ) ) {
				$current_object->$field_name = $data[$field_name];
			}

			if ( !empty( $field_def['type'] ) ) {
				settype( $current_object->$field_name, $field_def['type'] );
			}
		}

		return $current_object;
	}

	private function set_default_data( $field_name, $field_def ) {
		if ( isset( $field_def['bydefault'] ) ) {
			return $field_def['bydefault'];
		}
	}

	private function fill_child( $field_wanted ) {
		if ( !empty( $this->model['child'] ) ) {
			foreach ( $this->model['child'] as $child_name => $child_def ) {
				if ( isset( $child_def['field'] ) && (in_array( $child_name, !empty( $field_wanted ) ? $field_wanted : array() ) || empty( $field_wanted ) ) ) {

					if ( isset( $this->id ) ) {
						$value = $this->id;

						if ( !empty( $child_def['value'] ) ) {
							$key = $this->parse_key( $child_def );

							if ( !is_array( $key ) ) {
								$value = $this->$child_def['value'];
							}
							else {
								$value = $this->parse_value( $key );
							}

							if ( !is_array( $key ) && empty( $this->$child_def['value'] ) ) {
								$value = $this->id;
							}

							if ( !is_array( $key ) && !empty( $child_def['custom_field'] ) && !empty( $this->$child_def['value'] ) ) {
								$value = $this->$child_def['custom_field'];
								$child_def['field'] = $child_def['custom_field'];
							}

							if ( is_array( $key ) && !empty( $child_def['custom_field'] ) && $this->$child_def['value'] ) {
								$value = $this->parse_value( $key );
								$child_def['field'] = $child_def['custom_field'];
							}
						}

						if ( $child_def['field'] == 'include' || $child_def['field'] == 'comment__in' && !is_array( $value ) ) {
							$value = (array) $value;
						}

						$list_child = $child_def['controller']::g()->get( array( $child_def['field'] => $value ), $field_wanted );
					}
					else {
						$list_child = $child_def['controller']::g()->get( array( 'id' => 0 ), $field_wanted );
					}

					if ( !empty( $list_child ) ) {
						$this->$child_name = $list_child;
					}
				}
			}
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

		$value = $this->$key[0];
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
