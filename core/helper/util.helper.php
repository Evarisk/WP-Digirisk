<?php
/**
 * Les fonctions helpers des modèles
 *
 * @package Evarisk\Plugin
 */

namespace digi;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Transforme le contenu d'un point (html) en chaîne standard
 *
 * @param string $element L'action corrective
 *
 * @author: bilponse
 * @author_uri: https://github.com/bilponse
 *
 * @since 6.2.10
 * @version 6.3.1
 */
function point_to_string( $element ) {
	$content = $element->data['content'];
	$content = str_replace( "<br/>","\r\n", $content );
	$content = str_replace( "<div>","\r\n", $content );
	$content = str_replace( "</div>","", $content );
	$content = html_entity_decode( $content );
	$content = strip_tags( $content );
	$content = $element->data['date']['rendered']['date_human_readable'] . ': ' . $content . "\r";
	return $content;
}
