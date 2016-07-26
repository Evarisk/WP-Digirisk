<?php
/**
 * Plugin Name: Digirisk
 * Plugin URI:  http://www.evarisk.com/document-unique-logiciel
 * Description: Avec le plugin Digirisk vous pourrez réaliser, de façon simple et intuitive, le ou les documents uniques de vos entreprises et gérer toutes les données liées à la sécurité de votre personnel.
 * Version:     6.1.5.0
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

require_once( 'core/wpeo_log/wpeo_log.php' );
include_util::inc( WPDIGI_PATH . 'core/wpeo_model', array( 'class', 'model' ) );
include_util::inc( WPDIGI_PATH . 'core/wpdigi-utils', array( 'class', 'model' ) );
include_util::inc( WPDIGI_PATH , array( 'config', 'util', 'model', 'class', 'action', 'filter', 'shortcode' ) );
