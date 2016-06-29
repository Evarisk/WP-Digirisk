<?php
/**
* @TODO : A détailler
*
* @author Jimmy Latour <jimmy.latour@gmail.com>
* @version 0.1
* @copyright 2015-2016 Eoxia
* @package risk
* @subpackage action
*/

if ( !defined( 'ABSPATH' ) ) exit;

class risk_action {
	public function __construct() {
		add_action( 'wp_ajax_save_risk', array( $this, 'callback_save_risk' ), 5 );
	}

	/**
  * Enregistres un risque.
	* Ce callback est le dernier de save risque
  *
  * @param int $_POST['establishment']['establishment_id'] L'id de l'établissement
  * @param int $_POST['danger_id'] L'id du danger
  *
  * @author Jimmy Latour <jimmy.latour@gmail.com>
  *
  * @since 6.0.0.0
  *
  * @return void
  */
	public function callback_save_risk() {
		check_ajax_referer( 'save_risk' );

		global $wpdigi_risk_ctr;

		$ctr = !empty( $_POST['global'] ) ? sanitize_text_field( $_POST['global'] ) : '';
		$element_id = !empty( $_POST['element_id'] ) ? (int) $_POST['element_id'] : 0;
		global ${$ctr};

		$element = ${$ctr}->show( $element_id );

		$list_risk_id = $element->option['associated_risk'];
		$list_risk = array();
		foreach ( $list_risk_id as $risk_id ) {
			$list_risk[] = $wpdigi_risk_ctr->get_risk( $risk_id );
		}
		if ( count( $list_risk ) > 1 ) {
			usort( $list_risk, function( $a, $b ) {
				if( $a->evaluation->option[ 'risk_level' ][ 'equivalence' ] == $b->evaluation->option[ 'risk_level' ][ 'equivalence' ] ) {
					return 0;
				}
				return ( $a->evaluation->option[ 'risk_level' ][ 'equivalence' ] > $b->evaluation->option[ 'risk_level' ][ 'equivalence' ] ) ? -1 : 1;
			} );
		}

		ob_start();
		?>
		<li class="wp-digi-risk-list-header wp-digi-table-header" >
			<span class="wp-digi-risk-list-column-thumbnail" >&nbsp;</span>
			<span class="wp-digi-risk-list-column-cotation" ><?php _e( 'Cot.', 'digirisk' ); ?></span>
			<span class="wp-digi-risk-list-column-reference header" ><?php _e( 'Ref.', 'digirisk' ); ?></span>
			<span><?php _e( 'Risque', 'digirisk' ); ?></span>
			<span><?php _e( 'Comment', 'digirisk' ); ?></span>
			<span class="wp-digi-risk-list-column-actions" >&nbsp;</span>
		</li>
		<?php
		if ( !empty( $list_risk ) ) {
			foreach ( $list_risk as $risk ) {
				require( wpdigi_utils::get_template_part( WPDIGI_RISKS_DIR, WPDIGI_RISKS_TEMPLATES_MAIN_DIR, 'simple', 'list', 'item' ) );
			}
		}
		wp_send_json_success( array( 'template' => ob_get_clean() ) );
	}
}

new risk_action();
