<?php namespace digi;
/**
* Ajoutes deux shortcodes
* digi_evaluation_method permet d'afficher la méthode d'évaluation simple
* digi_evaluation_method_complex permet d'afficher la méthode d'évaluation complexe
*
* @author Jimmy Latour <jimmy.latour@gmail.com>
* @version 0.1
* @copyright 2015-2016 Eoxia
* @package evaluation_method
* @subpackage shortcode
*/

if ( !defined( 'ABSPATH' ) ) exit;

class digi_comment_class extends singleton_util {
	/**
	* Le constructeur
	*/
	protected function construct() {}

	public function display( $param ) {
		$display = !empty( $param ) && !empty( $param['display'] ) ? $param['display'] : 'edit';
		$type = !empty( $param ) && !empty( $param['type'] ) ? $param['type'] : '';
		$id = !empty( $param ) && !empty( $param['id'] ) ? $param['id'] : 0;

		if ( empty( $type ) ) {
			return false;
		}

		$model_name = '\digi\\' . $type . '_class';

		if ( $id !== 0 ) {
			$element = $model_name::g()->get( array( 'include' => $id ), array( 'comment' ) );
			$element = $element[0];
		}
		else {
			$element = $model_name::g()->get( array( 'schema' => true ) );
			$element = $element[0];
			$element->comment = comment_class::g()->get( array( 'schema' => true ) );
		}

		view_util::exec( 'comment', 'main', array( 'element' => $element, 'type' => $type, 'display' => $display ) );
	}
}

new digi_comment_class();
