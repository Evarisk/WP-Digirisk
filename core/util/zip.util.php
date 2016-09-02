<?php if ( !defined( 'ABSPATH' ) ) exit;

/**
 * @author Jimmy Latour <jimmy.eoxia@gmail.com>
 * @version 1.0
 */

class zip_util extends singleton_util {
	protected function construct() {}

  public function unzip( $zip_path, $destination_path ) {
		$zip = new ZipArchive;
		if ( $zip->open( $zip_path ) === TRUE ) {
			$zip->extractTo( $destination_path );
			$zip->close();
			return true;
		}
		else {
			return false;
		}
	}
}
