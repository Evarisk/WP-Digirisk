<?php
/**
 * Affiches le message comme quoi il faut installer Task Manager
 *
 * @author Evarisk <dev@evarisk.com>
 * @since 6.0.0
 * @version 6.2.5
 * @copyright 2015-2017 Evarisk
 * @package DigiRisk
 */

namespace digi;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

_e( 'Il faut installer l\'extension <a href="https://wordpress.org/plugins/task-manager/" target="_blank">Task Manager</a> pour créer des actions correctives.', 'digirisk' ); // WPCS: XSS is ok.
