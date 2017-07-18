<?php
/**
 * Affiches la liste des cotations
 *
 * @author Jimmy Latour <jimmy@evarisk.com>
 * @since 6.2.10.0
 * @version 6.2.10.0
 * @copyright 2015-2017 Evarisk
 * @package historic
 * @subpackage view
 */

namespace digi;

if ( ! defined( 'ABSPATH' ) ) {	exit; }

\eoxia\View_Util::exec( 'digirisk', 'historic', 'risk/list', array(
	'evaluations' => $evaluations,
) );
