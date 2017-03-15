<?php
/**
 * Classe gérant la page "Risques" du menu "Digirisk" de WordPress.
 *
 * @author Jimmy Latour <jimmy@evarisk.com>
 * @since 6.2.3.0
 * @version 6.2.8.0
 * @copyright 2015-2017 Evarisk
 * @package risk
 * @subpackage class
 */


namespace digi;

if ( ! defined( 'ABSPATH' ) ) {	exit; }

/**
 * Classe gérant la page "Risques" du menu "Digirisk" de WordPress.
 */
class Risk_Page_Class extends Singleton_Util {
	/**
	 * La limite des risques a afficher par page
	 *
	 * @var integer
	 */
	public $limit_risk = 20;

	/**
	 * Le nombre de risque par page.
	 *
	 * @var integer
	 */
	public $option_name = 'risk_per_page';


	/**
	 * Le constructeur obligatoirement pour utiliser la classe Singleton_util
	 *
	 * @return void nothing
	 *
	 * @since 6.2.3.0
	 * @version 6.2.4.0
	 */
	protected function construct() {}

	/**
	 * Affiches le contenu de la page "Tous les risques"
	 *
	 * @return void nothing
	 *
	 * @since 6.2.3.0
	 * @version 6.2.8.0
	 */
	public function display() {
		$per_page = get_user_meta( get_current_user_id(), $this->option_name, true );

		if ( empty ( $per_page ) || $per_page < 1 ) {
			$per_page = $this->limit_risk;
		}

		$current_page = ! empty( $_POST['next_page'] ) ? (int) $_POST['next_page'] : 1;

		$args_where = array(
			'post_status' => 'publish',
			'offset' => ( $current_page - 1 ) * $per_page,
			'posts_per_page' => $per_page,
		);

		$risk_list = Risk_Class::g()->get( $args_where );

		// Pour compter le nombre d'utilisateur en enlevant la limit et l'offset.
		unset( $args_where['offset'] );
		unset( $args_where['posts_per_page'] );
		$args_where['fields'] = array( 'ID' );
		$count_risk = count( Risk_Class::g()->get( $args_where ) );

		$number_page = ceil( $count_risk / $per_page );

		View_Util::exec( 'risk', 'page/main', array(
			'current_page' => $current_page,
			'number_page' => $number_page,
		) );
	}

	/**
	 * Charges tous les risques de l'application, ajoutes ses parents dans l'objet, et les tries selon leur cotation.
	 * Si $_GET['order_key'] et $_GET['order_type'] existent, le trie se fait selon ses critères.
	 *
	 * @return void nothing
	 *
	 * @since 6.2.3.0
	 * @version 6.2.8.0
	 */
	public function display_risk_list() {
		global $wpdb;
		$current_page = ! empty( $_POST['next_page'] ) ? (int) $_POST['next_page'] : 1;

		$per_page = get_user_meta( get_current_user_id(), $this->option_name, true );

		if ( empty ( $per_page ) || $per_page < 1 ) {
			$per_page = $this->limit_risk;
		}

		$args_where = array(
			'post_status' => 'publish',
			'offset' => ( $current_page - 1 ) * $per_page,
			'posts_per_page' => $per_page,
		);

		$risk_list = Risk_Class::g()->get( $args_where );

		$order_key = ! empty( $_GET['order_key'] ) ? $_GET['order_key'] : 'equivalence';
		$order_type = ! empty( $_GET['order_type'] ) ? $_GET['order_type'] : 'asc';
		$url_ref_order = '&order_key=equivalence&order_type=';
		$url_ref_order .= ( 'asc' === $order_type ) ? 'desc' : 'asc';

		if ( ! empty( $risk_list ) ) {
			foreach ( $risk_list as $key => $element ) {
				$risk_list[ $key ]->parent = Society_Class::g()->show_by_type( $element->parent_id );

				if ( !$risk_list[ $key ]->parent ) {
					unset( $risk_list[ $key ] );
				} else {
					if ( 'digi-group' === $risk_list[ $key ]->parent->type ) {
						$risk_list[ $key ]->parent_group = $risk_list[ $key ]->parent;
					} else {
						$risk_list[ $key ]->parent_workunit = $risk_list[ $key ]->parent;
						$risk_list[ $key ]->parent_group = Society_Class::g()->show_by_type( $risk_list[ $key ]->parent_workunit->parent_id );
					}
				}
			}
		}

		unset( $element );

		if ( count( $risk_list ) > 1 ) {
			if ( 'equivalence' === $order_key ) {
				if ( 'asc' === $order_type ) {
					usort( $risk_list, function( $a, $b ) {
						if ( $a->evaluation->risk_level['equivalence'] === $b->evaluation->risk_level['equivalence'] ) {
							return 0;
						}
						return ( $a->evaluation->risk_level['equivalence'] > $b->evaluation->risk_level['equivalence'] ) ? -1 : 1;
					} );
				} else {
					usort( $risk_list, function( $a, $b ) {
						if ( $a->evaluation->risk_level['equivalence'] === $b->evaluation->risk_level['equivalence'] ) {
							return 0;
						}
						return ( $a->evaluation->risk_level['equivalence'] < $b->evaluation->risk_level['equivalence'] ) ? -1 : 1;
					} );
				}
			}
		}

		View_Util::exec( 'risk', 'page/list', array(
			'risk_list' => $risk_list,
			'url_ref_order' => $url_ref_order,
		) );
	}
}
