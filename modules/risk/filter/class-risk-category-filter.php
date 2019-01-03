<?php
/**
 * Les filtres relatifs aux catégorie de risque
 *
 * @author Evarisk <dev@evarisk.com>
 * @since 6.2.4
 * @version 7.0.0
 * @copyright 2015-2018 Evarisk
 * @package DigiRisk
 */

namespace digi;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Les filtres relatifs aux catégorie de risque
 */
class Risk_Category_Filter extends Identifier_Filter {}

new Risk_Category_Filter();
