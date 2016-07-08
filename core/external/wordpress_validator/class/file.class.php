<?php

class file_class {
	/**
	* test
	*/
	public function get_list_file( $folder, $list_extension, $after = true, $end_ext = 'php' ) {
    $dir = new RecursiveDirectoryIterator( $folder );
    $ite = new RecursiveIteratorIterator( $dir );
    $regex = '/^.*\\';
    $regex .= !empty( $list_extension ) ? '.(' . implode( '|', $list_extension ) . ')' : '';
    $regex .= $after ? '.' : '.';
    $regex .= !empty( $end_ext ) ? $end_ext . '$/' : '';
    $list_file = new RegexIterator( $ite, $regex, RegexIterator::GET_MATCH );
    return $list_file;
  }

	/**
	* Include all files in $folder that respects the extension specified in $list_extension
	* This function can be recursive.
	*
	*
	* @param string $folder (test: folder) : The folder Name. If empty, search in the current folder.
	* @param array $list_type (test: [class,test]) : The list of extention
	* If empty, nothing be loaded.
	* @param bool $recursive : (test: true) Recursive or not. Default : false
	* @return bool True/False
	*/
	public function inc( $folder, $list_extension, $recursive = false ) {
		/**	Check if the defined directory exists for reading and including the different modules	*/
		$list_file = $this->get_list_file( $folder, $list_extension );
		$list_exclude_dir = array( 'core\\\external' );
		$ordered_file = array();

		foreach ( $list_file as $file ) {
			if ( !empty( $file[0] ) && !empty( $file[1] ) && is_file($file[0]) )  {
				// if ( !preg_match( '/' . implode( '|', $list_exclude_dir ) . '/', $file[0] ) ) {
					$ordered_file[$file[1]][] = $file[0];
				// }
			}

			if ( !empty( $file[0] ) && empty( $file[1] ) ) {
				require_once $file[0];
			}
		}

		foreach ( $list_extension as $extension ) {
			if ( !empty( $ordered_file[$extension] ) ) {
				foreach ( $ordered_file[$extension] as $file ) {
					echo '[+] require_once : ' . $file  . PHP_EOL;
					require_once ( $file );
				}
			}
		}

		return true;
	}
}

?>
