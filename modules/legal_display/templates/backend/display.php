<?php
/**
* L'affichage légal, inclus tous les templates nécessaires
*
* @author Jimmy Latour <jimmy.latour@gmail.com>
* @version 0.1
* @copyright 2015-2016 Eoxia
* @package society
* @subpackage templates
*/

if ( !defined( 'ABSPATH' ) ) exit;

require( wpdigi_utils::get_template_part( LEGAL_DISPLAY_DIR, LEGAL_DISPLAY_TEMPLATES_MAIN_DIR, 'backend', 'detective-work' ) );
require( wpdigi_utils::get_template_part( LEGAL_DISPLAY_DIR, LEGAL_DISPLAY_TEMPLATES_MAIN_DIR, 'backend', 'occupational-health-service' ) );
require( wpdigi_utils::get_template_part( LEGAL_DISPLAY_DIR, LEGAL_DISPLAY_TEMPLATES_MAIN_DIR, 'backend', 'emergency-service' ) );
require( wpdigi_utils::get_template_part( LEGAL_DISPLAY_DIR, LEGAL_DISPLAY_TEMPLATES_MAIN_DIR, 'backend', 'safety-rules' ) );
require( wpdigi_utils::get_template_part( LEGAL_DISPLAY_DIR, LEGAL_DISPLAY_TEMPLATES_MAIN_DIR, 'backend', 'working-hours' ) );
require( wpdigi_utils::get_template_part( LEGAL_DISPLAY_DIR, LEGAL_DISPLAY_TEMPLATES_MAIN_DIR, 'backend', 'derogations-schedules' ) );
require( wpdigi_utils::get_template_part( LEGAL_DISPLAY_DIR, LEGAL_DISPLAY_TEMPLATES_MAIN_DIR, 'backend', 'documents' ) );
