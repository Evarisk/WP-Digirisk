<?php
/**
 * Les filtres relatifs aux catégorie de recommandations
 *
 * @author Evarisk <dev@evarisk.com>
 * @since 7.0.0
 * @version 7.0.0
 * @copyright 2015-2018 Evarisk
 * @package DigiRisk
 */

namespace digi;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Les filtres relatifs aux catégorie de recommandations
 */
class Recommendation_Term_Filter extends Identifier_Filter {}

new Recommendation_Term_Filter();
