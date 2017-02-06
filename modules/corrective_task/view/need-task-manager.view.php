<?php
/**
 * Affiches le message comme quoi il faut installer Task Manager
 *
 * @author Jimmy Latour <jimmy@evarisk.com>
 * @since 0.1
 * @version 6.2.5.0
 * @copyright 2015-2017 Evarisk
 * @package corrective_task
 * @subpackage view
 */

namespace digi;

if ( ! defined( 'ABSPATH' ) ) { exit; }

_e( 'Il faut installer l\'extension <a href="https://wordpress.org/plugins/task-manager/" target="_blank">Task Manager</a> pour créer des tâches correctives.', 'digirisk' ); // WPCS: XSS is ok.
