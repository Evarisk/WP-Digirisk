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
class Accident_Comment_Class extends \eoxia\Comment_Class {

	/**
	 * Le nom du modèle
	 *
	 * @var string
	 */
	protected $model_name = '\digi\accident_comment_model';

	/**
	 * La clé principale du modèle
	 *
	 * @var string
	 */
	protected $meta_key = '_wpdigi_accident_comment_model';

	/**
	 * Le type
	 *
	 * @var string
	 */
	protected $type = 'digi-accidentcomment';

	/**
	 * La route pour accéder à l'objet dans la rest API
	 *
	 * @var string
	 */
	protected $base = 'accident-comment';

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
	 * @param  Accident_Model $accident     Les données du risque.
	 * @param  array      $comments La liste des commentaires.
	 *
	 * @return void
	 */
	public function save( $accident, $comments ) {
		if ( isset( $accident->data['id'] ) ) {
			if ( ! empty( $comments ) ) {
				foreach ( $comments as $comment ) {
					if ( ! empty( $comment['content'] ) ) {
						$comment['id']        = ! empty( $comment['id'] ) ? (int) $comment['id'] : 0;
						$comment['post_id']   = $accident->data['id'];
						$comment['author_id'] = ! empty( $comment['author_id'] ) ? (int) $comment['author_id'] : 0;
						$comment['parent_id'] = (int) $comment['parent_id'];

						self::g()->update( $comment );

						do_action( 'digi_add_historic', array(
							'parent_id' => $accident->data['parent_id'],
							'id'        => $accident->data['id'],
							'content'   => __( 'Modification de l\'accident ', 'digirisk' ) . ' ' . $accident->data['unique_identifier'] . ' ' . __( 'ajout du commentaire: ', 'digirisk' ) . ' ' . $comment['content'],
						) );
					}
				}
			}
		}
	}
}

Accident_Comment_Class::g();
