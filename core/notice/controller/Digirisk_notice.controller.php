<?php if ( !defined( 'ABSPATH' ) ) exit;
class Digirisk_notice_controller {

	/* PRODEST:
	{
		"name": "__construct",
		"description": "Initialisation de l'utilitaire de gestion des notifications dans l'administration / Initialisation for utilities allowing to manage notices into backend",
		"type": "function",
		"check": true,
		"author":
		{
			"email": "dev@evarisk.com",
			"name": "Alexandre T"
		},
		"version": 1.0
	}
	*/
	function __construct() {
		add_action( 'admin_notices', array( $this, 'display_admin_notice' ) );
	}

	/* PRODEST:
	{
		"name": "display_admin_notice",
		"description": "Récupère la version actuelle de la base de digirisk et affiche un message dans les notifications d'administration pour cette version / Get the current version of digirisk database and display an admin notice for this version",
		"type": "function",
		"check": true,
		"author":
		{
			"email": "dev@evarisk.com",
			"name": "Alexandre T"
		},
		"version": 1.0
	}
	*/
	function display_admin_notice() {
		/**	Get current screen for next use	*/
		$current_screen = get_current_screen();

		/**	Get current digirisk database version	*/
		$digirisk_db_version = getDbOption( 'base_evarisk' );

		/**	Require the notice file if exist	*/
		$notice_filepath = wpdigi_utils::get_template_part( DIGINOTIF_DIR, DIGINOTIF_TEMPLATES_MAIN_DIR, 'backend', 'notice', $digirisk_db_version );
		if ( is_file( $notice_filepath ) ) {
			require_once( $notice_filepath );
		}
	}

}
