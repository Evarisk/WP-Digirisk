<?php namespace digi;
/**
* Ajoutes deux shortcodes
* digi_evaluation_method permet d'afficher la méthode d'évaluation simple
* digi_evaluation_method_complex permet d'afficher la méthode d'évaluation complexe
*
* @author Jimmy Latour <jimmy.latour@gmail.com>
* @version 0.1
* @copyright 2015-2016 Eoxia
* @package danger
* @subpackage shortcode
*/

if ( !defined( 'ABSPATH' ) ) exit;

class danger_shortcode {
	/**
	* Le constructeur
	*/
	public function __construct() {
		add_shortcode( 'dropdown_danger', array( $this, 'callback_dropdown_danger' ) );
	}

	/**
	* Récupère le niveau et l'équivalence de la méthode d'évaluation du risque courant.
	*
	* @param array $param Tableau de donnée
	* @param int $param['risk_id'] L'id du risque
	* @param string $param['display'] La méthode d'affichage pour le template
	*
	* @return bool
	*/
	public function callback_dropdown_danger( $param ) {
		$id = !empty( $param ) && !empty( $param['id'] ) ? $param['id'] : 0;
		$display = !empty( $param ) && !empty( $param['display'] ) ? $param['display'] : 'edit';

		$danger_category_list = category_danger_class::g()->get( array( ), array( '\digi\danger' ) );

		if ( $display === 'edit' ) {
			view_util::exec( 'danger', 'dropdown', array( 'id' => $id, 'danger_category_list' => $danger_category_list ) );
		}
		else {
			$risk = risk_class::g()->get( array( 'include' => $id ), array( 'danger', 'danger_category' ) );
			$risk = $risk[0];
			view_util::exec( 'danger', 'item', array( 'id' => $id, 'risk' => $risk ) );
		}
	}
}

new danger_shortcode();
