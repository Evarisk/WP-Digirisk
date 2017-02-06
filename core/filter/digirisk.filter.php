<?php
/**
 * Gestion des filtres principaux de l'application.
 *
 * @author Jimmy Latour <jimmy@evarisk.com>
 * @since 6.2.5.0
 * @version 6.2.5.0
 * @copyright 2015-2017 Evarisk
 * @package core
 * @subpackage filter
 */

namespace digi;

if ( ! defined( 'ABSPATH' ) ) {	exit; }

/**
 * Gestion des filtres principaux de l'application.
 */
class Digirisk_Filter {

	/**
	 * Le constructeur
	 *
	 * @since 6.2.5.0
	 * @version 6.2.5.0
	 */
	public function __construct() {
		add_filter( 'upload_size_limit', array( $this, 'callback_upload_size_limit' ) );
	}

	/**
	 * Modifie la valeur max pour upload un fichier.
	 *
	 * @param integer $size La valeur courante.
	 *
	 * @return integer La nouvelle valeur.
	 *
	 * @since 6.2.5.0
	 * @version 6.2.5.0
	 */
	public function callback_upload_size_limit( $size ) {
		return 1024 * 10000;
	}
}

new Digirisk_Filter();
