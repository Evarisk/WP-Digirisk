<?php
/**
 * Récupères le commentaire pour ensuiter l'afficher.
 * Fait également l'affichage du formulaire pour ajouter un commentaire.
 *
 * @author Jimmy Latour <jimmy@evarisk.com>
 * @version 6.2.1.0
 * @copyright 2015-2016 Eoxia
 * @package comment
 * @subpackage class
 */

namespace digi;

if ( ! defined( 'ABSPATH' ) ) { exit; }

/**
 * Récupères le commentaire pour ensuiter l'afficher.
 * Fait également l'affichage du formulaire pour ajouter un commentaire.
 */
class Digi_Comment_Class extends Singleton_Util {

	/**
	 * Le constructeur
	 */
	protected function construct() {}

	/**
	 * [display description]
	 *
	 * @param  array $param  Les arguments du shortcode.
	 * @return [type]        [description]
	 */
	public function display( $param ) {
		$display = ! empty( $param ) && ! empty( $param['display'] ) ? $param['display'] : 'edit';
		$type = ! empty( $param ) && ! empty( $param['type'] ) ? $param['type'] : '';
		$id = ! empty( $param ) && ! empty( $param['id'] ) ? $param['id'] : 0;

		if ( empty( $type ) ) {
			return false;
		}

		$model_name = '\digi\\' . $type . '_class';

		if ( 0 !== $id ) {
			$comments = $model_name::g()->get( array( 'post_id' => $id ) );
		}
		else {
			$comments = comment_class::g()->get( array( 'schema' => true ) );
		}

		$comment_new = comment_class::g()->get( array( 'schema' => true ) );
		$comment_new = $comment_new[0];

		view_util::exec( 'comment', 'main', array( 'id' => $id, 'comments' => $comments, 'comment_new' => $comment_new, 'type' => $type, 'display' => $display ) );
	}
}

new Digi_Comment_Class();
