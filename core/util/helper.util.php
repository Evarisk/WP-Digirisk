<?php
/**
 * Gestion des fonctions "helper"
 *
 * @author Jimmy Latour <jimmy@evarisk.com>
 * @since 6.2.9.0
 * @version 6.2.9.0
 * @copyright 2015-2017 Evarisk
 * @package Digirisk
 * @subpackage util
 */

namespace digi;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Gestion des fonctions "helper"
 */
class Helper_Util extends Singleton_Util {
	/**
	 * Le constructeur obligatoirement pour utiliser la classe Singleton_util
	 *
	 * @return void nothing
	 */
	protected function construct() {}

	/**
	 * Transforme le contenu d'un point (html) en chaîne standard.
	 *
	 * @param  string $element Le contenu d'un point (html).
	 * @return string          Le point transformé en chaîne standard.
	 *
	 * @since 6.2.9.0
	 * @version 6.2.9.0
	 */
	public function point_to_string( $element ) {
		$content = $element->content;
		$content = str_replace( '<br/>', '\r\n', $content );
		$content = str_replace( '<div>', '\r\n', $content );
		$content = str_replace( '</div>', '', $content );
		$content = html_entity_decode( $content );
		$content = strip_tags( $content );
		$content = 'Le ' . mysql2date( 'd F Y', $element->date, true ) . ' : ' . $content . "
";
		return $content;
	}
}
