<?php
/**
 * Apelle la vue list.view du module accident
 *
 * @author Jimmy Latour <jimmy@evarisk.com>
 * @since 6.3.0
 * @version 6.3.0
 * @copyright 2015-2017 Evarisk
 * @package DigiRisk
 */

namespace digi;

if ( ! defined( 'ABSPATH' ) ) {	exit; }

\eoxia\View_Util::exec(
	'digirisk',
	'accident',
	'list',
	array(
		'society_id' => $society_id,
		'accidents' => $accidents,
		'accident_schema' => $accident_schema,
	)
);
