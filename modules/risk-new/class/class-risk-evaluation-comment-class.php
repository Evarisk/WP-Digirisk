<?php
/**
 * Classe gérant les commentaires d'un risque.
 *
 * @author Evarisk <dev@evarisk.com>
 * @since 6.1.5
 * @version 7.0.0
 * @copyright 2015-2018 Evarisk
 * @package DigiRisk
 */

namespace digi;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Classe gérant les risques
 */
class Risk_Evaluation_Comment_Class extends \eoxia\Comment_Class {

	/**
	 * Le nom du modèle
	 *
	 * @var string
	 */
	protected $model_name = '\digi\risk_evaluation_comment_model';

	/**
	 * La clé principale du modèle
	 *
	 * @var string
	 */
	protected $meta_key = '_wpdigi_risk_evaluation_comment';

	/**
	 * Le type
	 *
	 * @var string
	 */
	protected $type = 'digi-riskevalcomment';

	/**
	 * La route pour accéder à l'objet dans la rest API
	 *
	 * @var string
	 */
	protected $base = 'risk-evaluation-comment';

	/**
	 * La version de l'objet
	 *
	 * @var string
	 */
	protected $version = '0.1';

	/**
	 * Enregistres les commentaire des risques.
	 *
	 * @since 6.5.0
	 * @version 7.0.0
	 *
	 * @param  Risk_Model $risk     Les données du risque.
	 * @param  array      $comments La liste des commentaires.
	 *
	 * @return void
	 */
	public function save( $risk, $comments ) {
		if ( isset( $risk->data['id'] ) ) {
			if ( ! empty( $comments ) ) {
				foreach ( $comments as $comment ) {
					if ( ! empty( $comment['content'] ) ) {
						$comment['id']        = ! empty( $comment['id'] ) ? (int) $comment['id'] : 0;
						$comment['post_id']   = $risk->data['id'];
						$comment['author_id'] = ! empty( $comment['author_id'] ) ? (int) $comment['author_id'] : 0;

						if ( empty( $comment['parent_id'] ) ) {
							$comment['parent_id'] = $risk->data['evaluation']->data['id'];
						}

						$comment['parent_id'] = (int) $comment['parent_id'];

						self::g()->update( $comment );

						do_action( 'digi_add_historic', array(
							'parent_id' => $risk->data['parent_id'],
							'id'        => $risk->data['id'],
							'content'   => __( 'Modification du risque ', 'digirisk' ) . ' ' . $risk->data['unique_identifier'] . ' ' . __( 'ajout du commentaire: ', 'digirisk' ) . ' ' . $comment['content'],
						) );
					}
				}
			}
		}
	}
}

Risk_Evaluation_Comment_Class::g();
