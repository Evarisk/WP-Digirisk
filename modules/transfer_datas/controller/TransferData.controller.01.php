<?php if ( !defined( 'ABSPATH' ) ) exit;
/* PRODEST-MASTER:
{
	"name": "TransferData.controller.php",
	"description": "Fichier contenant l'utilitaire de transfert pour les données de Digirisk / File containing utilities for transfer datas of Digirisk",
	"type": "file",
	"check": true,
	"author":
	{
		"email": "dev@evarisk.com",
		"name": "Alexandre T"
	},
	"version": 1.0
}
*/

/* PRODEST:
{
	"name": "TransferData_controller",
	"description": "Classe contenant l'utilitaire de transfert pour les données de Digirisk / Class containing utilities for transfer datas of Digirisk",
	"type": "class",
	"check": true,
	"author":
	{
		"email": "dev@evarisk.com",
		"name": "Alexandre T"
	},
	"version": 1.0
}
*/
class TransferData_controller_01 {

	/**
	 * Déclaration de la correspondance entre les anciens types Evarisk et les nouveaux types dans wordpress / Declare an array for making correspondance between evarisk old types and wordpress new type
	 * @var array Correspondance between Evarisk types and wordpress types for element transfer
	 */
	protected $post_type = array(
// 		TABLE_TACHE => 'wpeo-tasks',
// 		TABLE_ACTIVITE => 'comments',

		TABLE_GROUPEMENT => WPDIGI_STES_POSTTYPE_MAIN,
		TABLE_UNITE_TRAVAIL => WPDIGI_STES_POSTTYPE_SUB,
	);

	/**
	 * Déclaration des types principaux à transférer / Declare an array with main element to transfer
	 * @var array
	 */
	protected $element_type = array(
// 		TABLE_TACHE,
		TABLE_GROUPEMENT,
	);

	/* PRODEST:
	{
		"name": "__construct",
		"description": "Initialisation de l'utilitaire de transfert des données de Digirisk vers le stockage de wordpress / Initialisation for utilities allowing to transfer Digirisk datas to wordpress storage",
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
		/**	Add admin menu for module management	*/
		add_action( 'admin_menu', array( $this, 'admin_menu' ), 12 );

		/**	Add log settings	*/
		$current_log_settings = get_option( '_wpeo_log_settings', array() );
		if ( empty( $current_log_settings ) || $current_log_settings[ 'my_services' ] || ( !array_key_exists( 'digirisk-datas-transfert-document', $current_log_settings[ 'my_services' ] ) ) ) {
			$current_log_settings[ 'my_services' ][ 'digirisk-datas-transfert-document' ] = array(
				'service_active' 		=> 1,
				'service_name' 			=> 'digirisk-datas-transfert-document',
				'service_size' 			=> 999999999999,
				'service_size_format' 	=> 'oc',
				'service_rotate' 		=> false,
			);
			$current_log_settings[ 'my_services' ][ 'digirisk-datas-transfert-picture' ] = array(
				'service_active' 		=> 1,
				'service_name' 			=> 'digirisk-datas-transfert-picture',
				'service_size' 			=> 999999999999,
				'service_size_format' 	=> 'oc',
				'service_rotate' 		=> false,
			);
			$current_log_settings[ 'my_services' ][ 'digirisk-datas-transfert-danger-category' ] = array(
				'service_active' 		=> 1,
				'service_name' 			=> 'digirisk-datas-transfert-danger-category',
				'service_size' 			=> 999999999999,
				'service_size_format' 	=> 'oc',
				'service_rotate' 		=> false,
			);
			$current_log_settings[ 'my_services' ][ 'digirisk-datas-transfert-danger' ] = array(
				'service_active' 		=> 1,
				'service_name' 			=> 'digirisk-datas-transfert-danger',
				'service_size' 			=> 999999999999,
				'service_size_format' 	=> 'oc',
				'service_rotate' 		=> false,
			);
			$current_log_settings[ 'my_services' ][ 'digirisk-datas-transfert-recommendation-category' ] = array(
				'service_active' 		=> 1,
				'service_name' 			=> 'digirisk-datas-transfert-recommendation-category',
				'service_size' 			=> 999999999999,
				'service_size_format' 	=> 'oc',
				'service_rotate' 		=> false,
			);
			$current_log_settings[ 'my_services' ][ 'digirisk-datas-transfert-recommendation' ] = array(
				'service_active' 		=> 1,
				'service_name' 			=> 'digirisk-datas-transfert-recommendation',
				'service_size' 			=> 999999999999,
				'service_size_format' 	=> 'oc',
				'service_rotate' 		=> false,
			);
			$current_log_settings[ 'my_services' ][ 'digirisk-datas-transfert-evaluation-method' ] = array(
				'service_active' 		=> 1,
				'service_name' 			=> 'digirisk-datas-transfert-evaluation-method',
				'service_size' 			=> 999999999999,
				'service_size_format' 	=> 'oc',
				'service_rotate' 		=> false,
			);
			$current_log_settings[ 'my_services' ][ 'digirisk-datas-transfert-evaluation-vars' ] = array(
				'service_active' 		=> 1,
				'service_name' 			=> 'digirisk-datas-transfert-evaluation-vars',
				'service_size' 			=> 999999999999,
				'service_size_format' 	=> 'oc',
				'service_rotate' 		=> false,
			);

			foreach ( $this->element_type as $element_type ) {
				switch( $element_type ){
					case TABLE_GROUPEMENT:
						$sub_element_type = TABLE_UNITE_TRAVAIL;
						break;
					case TABLE_TACHE:
						$sub_element_type = TABLE_ACTIVITE;
						break;
				}
				$current_log_settings[ 'my_services' ][ 'digirisk-datas-transfert-' . $element_type ] = array(
					'service_active' 		=> 1,
					'service_name' 			=> 'digirisk-datas-transfert-' . $element_type,
					'service_size' 			=> 999999999999,
					'service_size_format' 	=> 'oc',
					'service_rotate' 		=> false,
				);
				$current_log_settings[ 'my_services' ][ 'digirisk-datas-transfert-' . $sub_element_type ] = array(
					'service_active' 		=> 1,
					'service_name' 			=> 'digirisk-datas-transfert-' . $sub_element_type,
					'service_size' 			=> 999999999999,
					'service_size_format' 	=> 'oc',
					'service_rotate' 		=> false,
				);
			}

			update_option( '_wpeo_log_settings', $current_log_settings );
		}

		/**	Include the different javascripts and Styles	*/
		add_action( 'admin_enqueue_scripts', array( &$this, 'admin_assets' ) );
	}

	/* PRODEST:
	{
		"name": "admin_assets",
		"description": "Inclusion des librairies javascripts et des styles nécessaire pour le module dans l'administration/ Include javascripts librairies and styles usefull for the module in backend",
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
	function admin_assets() {
		global $digi_data_transfer_menu;
		$screen = get_current_screen();

		if ( !empty( $screen ) && ( $screen->id == $digi_data_transfer_menu ) ) {
			wp_enqueue_script( 'wpdigi-datas-transfert', DIGI_DTRANS_URL . DIGI_DTRANS_DIR . '/assets/js/backend.js', array( 'jquery', 'jquery-form' ), DIGI_DTRANS_VERSION, true );

			wp_register_style( 'wpdigi-datas-transfert', DIGI_DTRANS_URL . DIGI_DTRANS_DIR . '/assets/css/backend.css', '', DIGI_DTRANS_VERSION );
			wp_enqueue_style( 'wpdigi-datas-transfert' );
		}
	}

	/* PRODEST:
	{
		"name": "admin_menu",
		"description": "Création d'un menu administrateur pour le module / Admin menu creation for the module",
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
	function admin_menu() {
		global $digi_data_transfer_menu;
		remove_menu_page( 'digirisk-simple-risk-evaluation' );
		$digi_data_transfer_menu = add_menu_page( __( 'Digirisk : Manage datas transfert from digirisk V5.X', 'wp-digi-dtrans-i18n' ), __( 'Digirisk', 'wpdigi-i18n' ), 'manage_options', 'digi-transfert', array( &$this, 'transfer_page' ), WPDIGI_URL . 'core/assets/images/favicon.png', 4 );
	}

	/* PRODEST:
	{
		"name": "transfer_page",
		"description": "Affichage de la page permettant de lancer ainsi de voir l'avancement du transfert de données / Display interface allowing to launch and to check the state of datas transfer",
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
	function transfer_page() {
		require( wpdigi_utils::get_template_part( DIGI_DTRANS_DIR, DIGI_DTRANS_TEMPLATES_MAIN_DIR, "backend", "transfert" ) );
	}

	/* PRODEST:
	{
		"name": "get_transfer_progression",
		"description": "Récupération du nombre d'éléments à transferer et déjà transférés / Count element number to transfer and already transfered",
		"type": "function",
		"check": true,
		"author":
		{
			"email": "dev@evarisk.com",
			"name": "Alexandre T"
		},
		"param":
		{
			"$main_element_type": {"type": "string", "description": "Le type de l'élément principal a compter / The main element type to count", "default": "null"},
			"$sub_element_type": {"type": "string", "description": "Le type de l'élément secondaire a compter / The sub element type to count", "default": "null"}
		},
		"return":
		{
			"$count" : {"type": "array", "description": "Nombre d'éléments a transférer et déjà transférés selon les types d'éléments demandés / Number of element to transfer and already transfered regarding requested elements types" }
		},
		"version": 1.0
	}
	*/
	function get_transfer_progression( $main_element_type, $sub_element_type ) {
		global $wpdb;
		$count = array();

		/**	Get the number of element that will be transfered for the given element type	*/
		$query = $wpdb->prepare( "SELECT
			(
				SELECT COUNT( DISTINCT( id ) )
				FROM {$main_element_type}
				WHERE id != 1
			) AS main_element_nb,
			(
				SELECT COUNT( DISTINCT( id ) )
				FROM {$sub_element_type}
			) AS sub_element_nb,
			(
				SELECT COUNT( DISTINCT( id ) )
				FROM " . TABLE_PHOTO_LIAISON . "
				WHERE tableElement IN ( %s, %s )
			) AS nb_picture,
			(
				SELECT COUNT( DISTINCT( id ) )
				FROM " . TABLE_GED_DOCUMENTS . "
				WHERE table_element IN ( %s, %s )
			) AS nb_document,
			(
				SELECT COUNT( DISTINCT( id ) )
				FROM " . TABLE_FP . "
				WHERE table_element  IN ( %s, %s )
			) AS nb_fiches,
			(
				SELECT COUNT( DISTINCT( id ) )
				FROM " . TABLE_DUER . "
				WHERE element IN ( %s, %s )
			) AS nb_duer", array( $main_element_type, $sub_element_type, $main_element_type, $sub_element_type, $main_element_type, $sub_element_type, $main_element_type, $sub_element_type, ) );

		/**	Get the element number from database	*/
		$nb_element_to_transfert = $wpdb->get_row( $query );

		/**	Get option with already transfered element	*/
		$digirisk_transfert_options = get_option( '_wpdigirisk-dtransfert', array() );

		$count = array(
			'to_transfer' => $nb_element_to_transfert,
			'transfered' => $digirisk_transfert_options,
		);

		return $count;
	}

}

$wpdigi_dtransfert = new TransferData_controller_01();
