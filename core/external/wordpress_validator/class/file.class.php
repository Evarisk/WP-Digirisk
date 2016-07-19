<?php

class file_class {
	public function search_file( $folder, $pattern ) {
		echo $folder . PHP_EOL;
		$dir = new RecursiveDirectoryIterator( $folder );
		$ite = new RecursiveIteratorIterator( $dir );
		$files = new RegexIterator( $ite, $pattern, RegexIterator::GET_MATCH );
		$list_file = array();

		if ( !empty( $files ) ) {
			foreach( $files as $file )
			{
				$list_file[] = $file[0];
			}
		}

		return $list_file;
	}
}

?>
