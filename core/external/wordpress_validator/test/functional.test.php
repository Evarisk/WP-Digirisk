<?php
/**
* @author: Jimmy Latour lelabodudev@gmail.com
*/

class functional_test {
	private $list_file;
	private $exclude_path = array();

	public function __construct( $list_file ) {
		$this->list_file = $list_file;
	}

	public function execute() {
		echo "[+] Starting functional tests" . PHP_EOL . PHP_EOL;

		if ( !empty( $this->list_file ) ) {
		  foreach ( $this->list_file as $file_path ) {
				$file_path[0] = str_replace( '/', '\\', $file_path[0] );
				if ( !in_array( $file_path[0], $this->exclude_path ) ) {
					$class_info = $this->get_class_info( $file_path[0] );

					$class_name = $class_info['namespace'];
		      $class_name .= $class_info['class_name'];
		      $class = new ReflectionClass( $class_name );
		      $methods = $class->getMethods();

					$this->get_paramaters_methods( $methods );
				}
		  }
		}

		$this->display();

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

	private function get_paramaters_methods( $methods ) {
		if ( !empty( $methods ) ) {
		  foreach ( $methods as $element ) {
				echo '[+] class : ' . $element->class . PHP_EOL;
				echo '[+] method : ' . $element->name . PHP_EOL;
				$p = new ReflectionMethod( $element->class, $element->name );
				$params = $p->getParameters();
				if ( !empty( $params ) ) {
				  foreach ( $params as $param ) {
						echo '[+] paramater : (' . $param->getType() . ') ' . $param->getName() . PHP_EOL;
				  }
				}
		  }
		}
	}

	private function display() {
	}
}
