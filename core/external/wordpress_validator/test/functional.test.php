<?php
/**
* @author: Jimmy Latour lelabodudev@gmail.com
*/

use phpDocumentor\Reflection\DocBlockFactory;

class functional_test {
	private $list_file;
	private $exclude_path = array();
	private $list_method_queue = array();
	private $current_index = 0;
	private $total = 0;

	public function __construct( $list_file ) {
		$this->list_file = $list_file;
	}

	public function set_exclude_path( $exclude_path ) {
		$this->exclude_path = $exclude_path;
	}

	public function execute() {
		echo "[+] Starting functional tests" . PHP_EOL . PHP_EOL;

		if ( !empty( $this->list_file ) ) {
		  foreach ( $this->list_file as $file_path ) {
				$file_path[0] = str_replace( '/', '\\', $file_path[0] );
				if ( !in_array( $file_path[0], $this->exclude_path ) ) {
					$this->get_methods( $file_path[0], $file_path[1] );
				}
		  }
			$this->total = count( $this->list_method_queue );
			echo "<pre>"; print_r($this->list_method_queue); echo "</pre>";
			$this->execute_queue();
		}
	}

	public function resume() {
		if ( count( $this->list_method_queue ) == 0 ) {
			echo "[+] End functional tests" . PHP_EOL . PHP_EOL;
		}
		else {
			echo '[+] Resume' . PHP_EOL;

			$this->execute_queue();
		}
	}

	public function get_methods( $file_path, $format ) {
		$class_info = $this->get_class_info( $file_path );

		if ( empty( $class_info ) ) {
			return false;
		}

		$class_name = $class_info['namespace'];

		if ( !empty( $class_name ) ) {
			$class_name .= '\\';
		}

	  $class_name .= $class_info['class_name'];

		if ( !class_exists( $class_name ) ) {
			return false;
		}

		$reflection_class = new ReflectionClass( $class_name );
		$methods = $reflection_class->getMethods();

		if ( !empty( $methods ) ) {
		  foreach ( $methods as $element ) {
				$list_args = $this->load_args_json( $file_path, $format );
				if ( !empty( $list_args ) && !empty( $list_args[$element->name] ) ) {
				  foreach ( $list_args[$element->name] as $args ) {
						$array = array(
							'parent_class_name' => $class_info['parent_class_name'],
							'file_path' => $file_path,
							'args' => $args,
							'reflection_class' => $reflection_class,
							'class_name' => $class_name,
							'method_name' => $element->name,
						);

						$this->list_method_queue[] = $array;
					}
				}
		  }
		}
	}

	private function get_class_info( $file_path ) {
		$content = file_get_contents( $file_path );

		$pattern = '/class ([a-z0-9_]+) (extends (.*) {|{)/';
    preg_match( $pattern, $content, $matched_class );

		$namespace_pattern = '/namespace (.*);/';
    preg_match( $namespace_pattern, $content, $matched_namespace );

		if ( empty( $matched_class[1] ) ) {
			return false;
		}

		return array(
			'class_name' => $matched_class[1],
			'parent_class_name' => !empty( $matched_class[3] ) ? $matched_class[3] . '\\' : '',
			'namespace' => !empty( $matched_namespace[1] ) ? $matched_namespace[1] : '',
		);
	}

	private function load_args_json( $file_path, $format ) {
		$filename = basename( $file_path, '.' . $format . '.php' );
		$path_to_json = trim( dirname( $file_path ) . '\\test\\' . $filename . '.test.json' . PHP_EOL );
		if ( is_file ( $path_to_json ) ) {
			$json_content = file_get_contents( $path_to_json );
		}
		else {
			return '';
		}

		return json_decode( $json_content, true );
	}

	private function execute_queue() {
	 	$this->current_index = 1;
		while ( $this->list_method_queue ) {
			$this->display_progress();
			$method = array_pop( $this->list_method_queue );

			if ( !empty( $method['args'] ) ) {
				// Execute the method
				$this->execute_method( $method );

			}

			$this->current_index++;
		}
	}

	private function execute_method( $method ) {
		$_REQUEST['_wpnonce'] = wp_create_nonce( $method['method_name'] );
		$_POST = $method['args'];

		$this->display_args( $method['reflection_class'], $method['method_name'], $method['args'] );
		if ( !empty( $method['parent_class_name'] ) && ( $method['parent_class_name'] == 'comment_class' || $method['parent_class_name'] == 'post_class' || $method['parent_class_name'] == 'term_class' ||
			$method['parent_class_name'] == 'user_class' || $method['parent_class_name'] == 'singleton_util\\' ) ) {
				$className = $method['class_name'];
				$return = $method['reflection_class']->getMethod( $method['method_name'] )->invokeArgs( $className::get(), $method['args'] );
		}
		else {
			$return = $method['reflection_class']->getMethod( $method['method_name'] )->invokeArgs( new $method['class_name'], $method['args'] );
		}
	}

	private function display_args( $class, $method_name, $args ) {
		echo '[+] Test ' . $method_name . ' (Args: ' . count( $args ) . ')' . PHP_EOL;
		echo '[+] add nonce for ' . $method_name . ' : ' . $_REQUEST['_wpnonce'] . PHP_EOL;
		if ( !empty( $args ) ) {
			$i = 0;
		  foreach ( $args as $key => $element ) {
				if ( is_array( $element ) ) {
					$this->display_array( $i, $element );
				}
				else {
					echo '[+] Args #' . $key . ' (' . gettype( $element ) . ') -> ' . $element . PHP_EOL;
				}
				$i++;
			}
		}
	}

	public function display_array( $i, $arr ) {
		if ( !empty( $arr ) ) {
			$x = 0;
		  foreach ( $arr as $key => $element ) {
				if ( is_array( $element ) ) {
					$this->display_array( $i, $element );
				}
				else {
					echo '[+] Args #' . $key . ' (array) index #' . $x . ' (' . gettype( $element ) . ') -> ' . $element . PHP_EOL;
				}
				$x++;
		  }
		}
	}

	private function display_return( $class, $method_name, $value ) {
		echo '[+] Return ' . $method_name . ' (Value: ' . count( $value ) . ') -> ' . gettype($value) . PHP_EOL;
	}

	private function display_progress() {
		echo '[+] Test ' . $this->current_index . ' on ' . $this->total . '(' . (int) ( ( $this->current_index / $this->total ) * 100 ) . '/100%)' . PHP_EOL;
	}
}
