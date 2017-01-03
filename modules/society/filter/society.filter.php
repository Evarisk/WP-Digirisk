<?php
/**
 * Les filtres pour les sociétés
 *
 * @author Jimmy Latour <jimmy@evarisk.com>
 * @since 6.2.2.0
 * @version 6.2.3.0
 * @copyright 2015-2017 Evarisk
 * @package society
 * @subpackage filter
 */

namespace digi;

if ( ! defined( 'ABSPATH' ) ) { exit; }

class Society_Filter {

	public function __construct() {
		add_filter( 'digi_menu', array( $this, 'callback_digi_menu' ), 10, 2 );

		add_filter( 'society_identity', array( $this, 'callback_society_identity' ), 10, 2 );
		add_filter( 'wpdigi_establishment_action', array( $this, 'callback_establishment_action' ) );

		add_filter( 'digi_dashboard', array( $this, 'callback_digi_dashboard' ), 10, 2 );
	}

	public function callback_digi_menu( $content, $groupment_selected_id ) {
		require_once( SOCIETY_VIEW_DIR . 'menu.view.php' );
	}

	public function callback_society_identity( $element, $editable_identity = false ) {
		View_Util::exec( 'society', 'identity', array( 'element' => $element, 'editable_identity' => $editable_identity ), false );
	}

	public function callback_establishment_action( $element ) {
		require( SOCIETY_VIEW_DIR . '/action.view.php' );
	}

	public function callback_digi_dashboard( $content, $establishment_selected_id ) {
		$establishment = establishment_class::g()->show_by_type( $establishment_selected_id );
		$object_name_establishment = apply_filters( 'wpdigi_object_name_' . $establishment->type, '' );
		require( SOCIETY_VIEW_DIR . '/content.view.php' );
	}
}

new Society_Filter();
