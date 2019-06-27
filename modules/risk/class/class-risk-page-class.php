<?php
/**
 * Classe gérant la page "Risques" du menu "Digirisk" de WordPress.
 *
 * @author Evarisk <dev@evarisk.com>
 * @since 6.2.3
 * @version 6.5.0
 * @copyright 2015-2018 Evarisk
 * @package DigiRisk
 */

namespace digi;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Classe gérant la page "Risques" du menu "Digirisk" de WordPress.
 */
class Risk_Page_Class extends \eoxia\Singleton_Util {

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
	 * Le constructeur obligatoirement pour utiliser la classe \eoxia\Singleton_Util
	 *
	 * @since 6.2.3
	 */
	protected function construct() {}

	/**
	 * Affiches le contenu de la page "Tous les risques"
	 *
	 * @since 6.2.3
	 */
	public function display() {
		$per_page = get_user_meta( get_current_user_id(), $this->option_name, true );

		if ( empty( $per_page ) || 1 > $per_page ) {
			$per_page = $this->limit_risk;
		}

		$current_page = ! empty( $_POST['next_page'] ) ? (int) $_POST['next_page'] : 1;
		$order_type   = ! empty( $_GET['order_type'] ) ? sanitize_text_field( $_GET['order_type'] ) : 'ASC';

		$args_where = array(
			'post_status'    => array( 'publish', 'inherit' ),
			'offset'         => ( $current_page - 1 ) * $per_page,
			'posts_per_page' => $per_page,
			'meta_key'       => '_wpdigi_equivalence',
			'orderby'        => 'meta_value_num',
			'meta_query'     => array(
				array(
					'key'     => '_wpdigi_preset',
					'value'   => 1,
					'compare' => '!=',
				),
			),
			
		);
		
		if ( ! empty( $_GET['category_risk_id'] ) ) {
			$args_where['tax_query'] = array(
				array(
					'taxonomy' => 'digi-category-risk',
					'field'    => 'term_id',
					'terms'    => $_GET['category_risk_id'],
				),
			);
		}

		$risk_list = Risk_Class::g()->get( $args_where );

		// Pour compter le nombre d'utilisateur en enlevant la limit et l'offset.
		unset( $args_where['offset'] );
		unset( $args_where['posts_per_page'] );
		$args_where['fields'] = array( 'ID' );

		$count_risk  = count( Risk_Class::g()->get( $args_where ) );
		$number_page = ceil( $count_risk / $per_page );
		
		$risk_categories = Risk_Category_Class::g()->get();

		\eoxia\View_Util::exec( 'digirisk', 'risk', 'page/main', array(
			'current_page'    => $current_page,
			'number_page'     => $number_page,
			'risk_categories' => $risk_categories,
		) );
	}

	/**
	 * Charges tous les risques de l'application, ajoutes ses parents dans l'objet, et les tries selon leur cotation.
	 * Si $_GET['order_key'] et $_GET['order_type'] existent, le trie se fait selon ses critères.
	 *
	 * @since 6.2.3
	 */
	public function display_risk_list() {
		global $wpdb;
		$current_page = ! empty( $_POST['next_page'] ) ? (int) $_POST['next_page'] : 1;

		$per_page = get_user_meta( get_current_user_id(), $this->option_name, true );

		if ( empty( $per_page ) || $per_page < 1 ) {
			$per_page = $this->limit_risk;
		}

		$order_type = ! empty( $_GET['order_type'] ) ? $_GET['order_type'] : 'DESC';

		$args_where = array(
			'post_status'    => array( 'publish', 'inherit' ),
			'offset'         => ( $current_page - 1 ) * $per_page,
			'posts_per_page' => $per_page,
			'meta_key'       => '_wpdigi_equivalence',
			'orderby'        => 'meta_value_num',
			'order'          => $order_type,
			'meta_query'     => array(
				array(
					'key'     => '_wpdigi_preset',
					'value'   => 1,
					'compare' => '!=',
				),
			),
		);
		
		if ( ! empty( $_GET['category_risk_id'] ) ) {
			$args_where['tax_query'] = array(
				array(
					'taxonomy' => 'digi-category-risk',
					'field'    => 'term_id',
					'terms'    => $_GET['category_risk_id'],
				),
			);
		}

		$risk_list = Risk_Class::g()->get( $args_where );

		$order_key      = ! empty( $_GET['order_key'] ) ? $_GET['order_key'] : 'equivalence';
		$url_ref_order  = '&order_key=equivalence&order_type=';
		$url_ref_order .= ( 'ASC' === $order_type ) ? 'DESC' : 'ASC';

		if ( ! empty( $risk_list ) ) {
			foreach ( $risk_list as $key => $element ) {
				$risk_list[ $key ]->parent = Society_Class::g()->show_by_type( $element->data['parent_id'] );

				if ( empty( $risk_list[ $key ]->parent ) ) {
					unset( $risk_list[ $key ] );
				} else {
					if ( 'digi-group' === $risk_list[ $key ]->parent->data['type'] ) {
						$risk_list[ $key ]->parent_group = $risk_list[ $key ]->parent;
					} else {
						$risk_list[ $key ]->parent_workunit = $risk_list[ $key ]->parent;
						$risk_list[ $key ]->parent_group    = Society_Class::g()->show_by_type( $risk_list[ $key ]->parent_workunit->data['parent_id'] );
					}
				}
			}
		}

		\eoxia\View_Util::exec( 'digirisk', 'risk', 'page/list', array(
			'risk_list'     => $risk_list,
			'url_ref_order' => $url_ref_order,
		) );
	}
}
