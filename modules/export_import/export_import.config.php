<?php if ( !defined( 'ABSPATH' ) ) exit;
/**
 * Fichier principal du module d'export/import des données, définissant les variables globales et l'état du module / Main file for export/import module, define globals vars and module state
 *
 * @author Alexandre Techer <dev@evarisk.com>
 * @version 6.1.5.5
 * @copyright 2015-2016 Evarisk
 * @package export_import
 * @subpackage shortcode
 */

/** Version du module / Module version */
DEFINE( 'WPDIGI_IMPEXP_VERSION', '1.0');

/**	Définition des constantes pour le module / Define constant for module	*/
DEFINE( 'WPDIGI_IMPEXP_DIR', basename(dirname(__FILE__)));
DEFINE( 'WPDIGI_IMPEXP_PATH_TO_MODULE', str_replace( str_replace( "\\", "/", WP_PLUGIN_DIR ), "", str_replace( "\\", "/", plugin_dir_path( __FILE__ ) ) ) );
DEFINE( 'WPDIGI_IMPEXP_PATH', str_replace( "\\", "/", plugin_dir_path( __FILE__ ) ) );
DEFINE( 'WPDIGI_IMPEXP_URL', str_replace( str_replace( "\\", "/", ABSPATH), site_url() . '/', WPDIGI_IMPEXP_PATH ) );

/**	Définition du chemin absolu vers les suelette d'affichage / Define the templates absolute directories	*/
DEFINE( 'WPDIGI_IMPEXP_VIEW_DIR', WPDIGI_IMPEXP_PATH . '/view/');
