<?php
/**
 * Plugin Name: Digirisk
 * Plugin URI:  http://www.evarisk.com/document-unique-logiciel
 * Description: Avec le plugin Digirisk vous pourrez réaliser, de façon simple et intuitive, le ou les documents uniques de vos entreprises et gérer toutes les données liées à la sécurité de votre personnel.
 * Version:     6.1.5.10
 * Author:      Evarisk
 * Author URI:  http://www.evarisk.com
 * License:     GPL2
 * License URI: https://www.gnu.org/licenses/gpl-2.0.html
 * Domain Path: /core/assets/languages
 * Text Domain: digirisk
 */

require_once( 'digirisk.config.php' );
require_once( 'core/util/singleton.util.php' );
require_once( 'core/util/include.util.php' );
require_once( 'core/external/wpeo_log/wpeo_log.php' );
require_once( 'core/external/wpeo_model/class/helper.class.php' );
require_once( 'core/action/digirisk.action.php' );

include_util::inc();

// include_util::inc( WPDIGI_PATH . 'core/external/wpeo_model', array( 'util' ) );
// include_util::inc( WPDIGI_PATH . 'core/external/wpeo_export', array( 'config', 'class' ) );
// include_util::inc( WPDIGI_PATH . 'core/' , array( 'action' ) );
