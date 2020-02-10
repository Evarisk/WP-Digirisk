<?php
/**
 * Les filtres relatifs aux statistiques
 *
 * @author Evarisk <dev@evarisk.com>
 * @since 7.5.3
 * @version 7.5.3
 * @copyright 2015-2020 Evarisk
 * @package DigiRisk
 */

namespace digi;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Les filtres relatifs aux statistiques
 */
class Statistics_Filter {

	/**
	 * Le constructeur
	 */
	public function __construct() {
		add_filter( 'digi_tab', array( $this, 'callback_tab' ), 80, 2 );
		add_filter( 'digi_get_risks_recursive', array( $this, 'callback_get_risks_recursive' ), 10, 2 );

	}

	/**
	 * Ajoutes l'onglet statistique à la société, aux groupements et aux unités de travail
	 *
	 * @param  array   $list_tab La liste des filtres.
	 * @param  integer $id L'ID de la société.
	 *
	 * @return array
	 *
	 * @since 6.2.2
	 */
	public function callback_tab( $list_tab, $id ) {
		$list_tab['digi-society']['statistic'] = array(
			'type'  => 'text',
			'text'  => __( 'Statistiques', 'digirisk' ),
			'title' => __( 'Les statistiques', 'digirisk' ),
		);

		$list_tab['digi-group']['statistic'] = array(
			'type'  => 'text',
			'text'  => __( 'Statistiques', 'digirisk' ),
			'title' => __( 'Les statistiques', 'digirisk' ),
		);

		$list_tab['digi-workunit']['statistic'] = array(
			'type'  => 'text',
			'text'  => __( 'Statistiques', 'digirisk' ),
			'title' => __( 'Les statistiques', 'digirisk' ),
		);

		return $list_tab;
	}

	/**
	 * Permet de récupérer les risques liés à la societé de manière récursive.
	 *
	 * @param  integer $id L'ID de la société.
	 *
	 * @return array
	 *
	 * @since 7.5.3
	 */
	public function callback_get_risks_recursive( $society ) {

		$risks = get_posts( array(
			'post_type'   => array( 'digi-society', 'digi-group', 'digi-workunit' ),
			'post_parent' => $parent_id,
			'numberposts' => -1,
			'post_status' => array( 'publish', 'inherit' ),'a'
		) );

//		$risks = Risk_Class::g()->get( array(
//			'post_parent' => $society->data['id'],
//		) );
		$society->data['childrens'][] = $risks;

//		if ( ! empty( $risks ) ) {
//			foreach ( $risks as $risk ) {
//
//			}
//		}

		return $society;
	}
}

new Statistics_Filter();

