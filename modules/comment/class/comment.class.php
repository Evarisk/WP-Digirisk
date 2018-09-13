<?php
/**
 * Récupères le commentaire pour ensuiter l'afficher.
 * Fait également l'affichage du formulaire pour ajouter un commentaire.
 *
 * @author Evarisk <dev@evarisk.com>
 * @since 6.2.1
 * @version 7.0.0
 * @copyright 2015-2017 Evarisk
 * @package DigiRisk
 */

namespace digi;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Récupères le commentaire pour ensuiter l'afficher.
 * Fait également l'affichage du formulaire pour ajouter un commentaire.
 */
class Digi_Comment_Class extends \eoxia\Singleton_Util {

	/**
	 * Le constructeur
	 */
	protected function construct() {}

	/**
	 * Récupères les commentaires et le schéma d'un commentaire puis appelle la vue "main.view.php" du module "comment".
	 *
	 * @param  array $param  Les arguments du shortcode.
	 * @return void
	 *
	 * @since 6.2.1
	 * @version 7.0.0
	 */
	public function display( $param ) {
		$display      = ! empty( $param ) && ! empty( $param['display'] ) ? $param['display'] : 'edit';
		$type         = ! empty( $param ) && ! empty( $param['type'] ) ? $param['type'] : '';
		$id           = ! empty( $param ) && ! empty( $param['id'] ) ? $param['id'] : 0;
		$add_button   = ! empty( $param ) && isset( $param['add_button'] ) ? (int) $param['add_button'] : 1;
		$namespace    = ! empty( $param ) && isset( $param['namespace'] ) ? sanitize_text_field( $param['namespace'] ) : 'digi';
		$model_name   = '\\' . $namespace . '\\' . $type . '_class';
		$display_date = ! empty( $param['display_date'] ) ? filter_var( $param['display_date'], FILTER_VALIDATE_BOOLEAN ) : true;
		$display_user = ! empty( $param['display_user'] ) ? filter_var( $param['display_user'], FILTER_VALIDATE_BOOLEAN ) : true;

		$comments = array();

		if ( 0 !== $id ) {
			$comments = $model_name::g()->get( array(
				'post_id' => $id,
			) );

		}

		$comment_new = $model_name::g()->get( array(
			'schema' => true,
		), true );

		\eoxia\View_Util::exec( 'digirisk', 'comment', 'main', array(
			'id'           => $id,
			'comments'     => $comments,
			'comment_new'  => $comment_new,
			'type'         => $type,
			'namespace'    => $namespace,
			'display'      => $display,
			'add_button'   => $add_button,
			'display_date' => $display_date,
			'display_user' => $display_user,
		) );
	}
}

new Digi_Comment_Class();
