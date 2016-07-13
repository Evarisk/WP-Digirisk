<?php
/**
* @author: Jimmy Latour lelabodudev@gmail.com
*/

use phpDocumentor\Reflection\DocBlockFactory;

class functional_test {
	private $list_file;
	private $exclude_path = array();
	private $list_methods_to_test = array();

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
					echo '[+] Testing file : ' . $file_path[0] . PHP_EOL;

					$class_info = $this->get_class_info( $file_path[0] );
					$this->list_methods_to_test[$file_path[0]] = array();

					$class_name = $class_info['namespace'];
					if ( !empty( $class_name ) ) {
						$class_name .= '\\';
					}

		      $class_name .= $class_info['class_name'];
					if ( class_exists( $class_name ) ) {
			      $class = new ReflectionClass( $class_name );

						$factory = DocBlockFactory::createInstance();
			      $methods = $class->getMethods();

						$json_content = $this->load_test_json( $file_path[0], $file_path[1] );

						if ( !empty( $methods ) ) {
						  foreach ( $methods as $element ) {
								if ( empty( $this->list_methods_to_test[$file_path[0]][$element->class] ) ) {
									$this->list_methods_to_test[$file_path[0]][$element->class] = array();
								}

								$this->list_methods_to_test[$file_path[0]][$element->class][$element->name] = array();
								$docBlock = $factory->create($element->getDocComment());
								$this->fill_method( $file_path[0], $element, $docBlock );
								$this->call_method( $class, $file_path[0], $this->list_methods_to_test[$file_path[0]][$element->class], $json_content );
						  }
						}
					}
				}
		  }
		}

		echo "[+] End functional tests" . PHP_EOL . PHP_EOL;
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

	private function load_test_json( $file_path, $format ) {
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

	private function fill_method( $file_path, $element, $docBlock ) {
		if ( !empty( $docBlock->getTags() ) ) {
		  foreach ( $docBlock->getTags() as $tag ) {
				$this->list_methods_to_test[$file_path][$element->class][$element->name][$tag->getVariableName()] = $tag->getInfo();
		  }
		}
	}

	private function call_method( $class, $file_path, $list_methods_to_test, $json_content ) {
		$parentClassName = ( !empty( $class->getParentClass() ) && !empty( $class->getParentClass()->name ) ) ? $class->getParentClass()->name : '';
		if ( !empty( $list_methods_to_test ) ) {
		  foreach ( $list_methods_to_test as $method_name =>  $method_to_test ) {
				if ( !empty( $json_content[$method_name] ) ) {
				  foreach ( $json_content[$method_name] as $json ) {

						// Default value
						$this->display_args( $class, $method_name, $json );

						if ( !empty( $parentClassName ) && ( $parentClassName == 'comment_class' || $parentClassName == 'post_class' || $parentClassName == 'term_class' ||
							$parentClassName == 'user_class' || $parentClassName == 'singleton_util' ) ) {
								$className = $class->name;
								$return = $class->getMethod( $method_name )->invokeArgs( $className::get(), $json );
						}
						else {
							$return = $class->getMethod( $method_name )->invokeArgs( new $class->name(), $json );
						}

						$this->display_return( $class, $method_name, $return );
					}
				}
		  }
		}
	}

	private function display_args( $class, $method_name, $args ) {
		echo '[+] Test ' . $method_name . ' (Args: ' . count( $args ) . ')' . PHP_EOL;
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

	private function display_array( $i, $arr ) {
		if ( !empty( $arr ) ) {
			$x = 0;
		  foreach ( $arr as $key => $element ) {
				echo '[+] Args #' . $key . ' (array) index #' . $x . ' (' . gettype( $element ) . ') -> ' . $element . PHP_EOL;
				$x++;
		  }
		}
	}

	private function display_return( $class, $method_name, $value ) {
		echo '[+] Return ' . $method_name . ' (Value: ' . count( $value ) . ') -> ' . gettype($value) . PHP_EOL;
	}
}
