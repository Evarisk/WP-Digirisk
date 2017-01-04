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
	 * @return void
	 */
	public function display( $param ) {
		$display = ! empty( $param ) && ! empty( $param['display'] ) ? $param['display'] : 'edit';
		$type = ! empty( $param ) && ! empty( $param['type'] ) ? $param['type'] : '';
		$id = ! empty( $param ) && ! empty( $param['id'] ) ? $param['id'] : 0;

		$model_name = '\digi\\' . $type . '_class';

		if ( 0 !== $id ) {
			$comments = $model_name::g()->get( array( 'post_id' => $id ) );
		} else {
			$comments = Comment_Class::g()->get( array( 'schema' => true ) );
		}

		$comment_new = Comment_Class::g()->get( array( 'schema' => true ) );
		$comment_new = $comment_new[0];

		View_Util::exec( 'comment', 'main', array( 'id' => $id, 'comments' => $comments, 'comment_new' => $comment_new, 'type' => $type, 'display' => $display ) );
	}
}

new Digi_Comment_Class();
