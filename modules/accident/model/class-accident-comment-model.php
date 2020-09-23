<?php
/**
 * Définition des champs des d'un risque.
 *
 * @author Evarisk <dev@evarisk.com>
 * @since 6.0.0
 * @version 6.5.0
 * @copyright 2015-2018 Evarisk
 * @package DigiRisk
 */

namespace digi;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Définition des champs des commentaire d'un risque.
 */
class Accident_Comment_Model extends \eoxia\Comment_Model {

	/**
	 * Définition des champs des commentaire d'un risque.
	 *
	 * @since 6.0.0
	 * @version 6.0.0
	 *
	 * @param array $data       Data.
	 * @param mixed $req_method Peut être "GET", "POST", "PUT" ou null.
	 */
	public function __construct( $data = null, $req_method = null ) {
		parent::__construct( $data, $req_method );
	}

}
