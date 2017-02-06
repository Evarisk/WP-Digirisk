<?php
/**
 * Apelle la vue list.view du module risk
 *
 * @author Jimmy Latour <jimmy@evarisk.com>
 * @since 6.2.3.0
 * @version 6.2.3.0
 * @copyright 2015-2017 Evarisk
 * @package risk
 * @subpackage view
 */

namespace digi;

if ( ! defined( 'ABSPATH' ) ) {	exit; }

View_Util::exec( 'risk', 'list', array( 'society_id' => $society_id, 'risks' => $risks, 'risk_schema' => $risk_schema ) );
