<?php
/**
 * La classe gérant les causeries dans son état "final".
 *
 * @author    Evarisk <dev@evarisk.com>
 * @since     6.6.0
 * @version   6.6.0
 * @copyright 2018 Evarisk.
 * @package   DigiRisk
 */

namespace digi;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * La classe gérant les causeries
 */
class Causerie_Intervention_Class extends \eoxia\Post_Class {

	/**
	 * Le nom du modèle
	 *
	 * @var string
	 */
	protected $model_name = '\digi\Causerie_Intervention_Model';

	/**
	 * Le post type
	 *
	 * @var string
	 */
	protected $post_type = 'digi-final-causerie';

	/**
	 * La route pour accéder à l'objet dans la rest API
	 *
	 * @var string
	 */
	protected $base = 'final-causerie';

	/**
	 * La version de l'objet
	 *
	 * @var string
	 */
	protected $version = '0.1';

	/**
	 * La clé principale du modèle
	 *
	 * @var string
	 */
	protected $meta_key = '_wpdigi_final_causerie';

	/**
	 * Le préfixe de l'objet dans DigiRisk
	 *
	 * @var string
	 */
	public $element_prefix = 'F';

	/**
	 * La fonction appelée automatiquement avant la création de l'objet dans la base de donnée
	 *
	 * @var array
	 */
	protected $before_post_function = array( '\digi\construct_identifier', '\digi\get_identifier' );

	/**
	 * La fonction appelée automatiquement avant la modification de l'objet dans la base de donnée
	 *
	 * @var array
	 */
	protected $before_put_function = array( '\digi\get_identifier' );

	/**
	 * Les callback après avoir récupérer l'objet en base de donnée.
	 *
	 * @var array
	 */
	protected $after_get_function = array( '\digi\get_identifier', '\digi\get_full_causerie' );

	/**
	 * La fonction appelée automatiquement après la récupération de l'objet dans la base de donnée
	 *
	 * @var array
	 */
	protected $after_put_function = array( '\digi\get_full_causerie' );

	/**
	 * Le nom pour le resgister post type
	 *
	 * @var string
	 */
	protected $post_type_name = 'Final Causeries';

	/**
	 * Dupliques toutes les données d'une causerie
	 *
	 * @since 6.6.0
	 * @version 6.6.0
	 *
	 * @param  integer $causerie_id        L'ID de la causerie
	 * @return Causerie_Intervention_Model La causerie "intervention" créé dans cette méthode.
	 */
	public function duplicate( $causerie_id ) {
		$causerie = Causerie_Class::g()->get( array( 'id' => $causerie_id ), true );

		// Clone la causerie.
		$duplicated_causerie = clone $causerie;

		// On met l'ID à 0 pour en créer un nouveau.
		$duplicated_causerie->id                = 0;
		$duplicated_causerie->parent_id         = $causerie->id;
		$duplicated_causerie->unique_identifier = $duplicated_causerie->unique_identifier;
		$duplicated_causerie->second_unique_key = $this->get_unique_key( $causerie->id );
		$duplicated_causerie->second_identifier = $this->element_prefix . $duplicated_causerie->second_unique_key;
		$duplicated_causerie->type              = $this->get_type();

		$tmp_image_ids = $duplicated_causerie->associated_document_id['image'];
		// Supprimes les liaisons avec les images, qui seront par la suite dupliquées.
		unset( $duplicated_causerie->associated_document_id['image'] );
		$duplicated_causerie->thumbnail_id = 0;

		$duplicated_causerie = $this->update( $duplicated_causerie );

		// Duplication des images.
		if ( ! empty( $tmp_image_ids ) ) {
			$duplicated_causerie->associated_document_id['image'] = array();

			foreach ( $tmp_image_ids as $image_id ) {
				$attachment_path = get_attached_file( $image_id );
				$file_id         = \eoxia\File_Util::g()->move_file_and_attach( $attachment_path, 0 );

				if ( empty( $duplicated_causerie->thumbnail_id ) ) {
					$duplicated_causerie->thumbnail_id = $file_id;
				}

				$duplicated_causerie->associated_document_id['image'][] = $file_id;
			}
		}

		$duplicated_causerie->date_start = current_time( 'mysql' );

		return $this->update( $duplicated_causerie );
	}

	/**
	 * Récupères la clé unique selon le nombre d'évaluation de causerie faites avec la causerie parent.
	 *
	 * @since 6.6.0
	 * @version 6.6.0
	 *
	 * @param  integer $causerie_id L'ID de la causerie parent.
	 * @return integer              La clé unique.
	 */
	private function get_unique_key( $causerie_id ) {
		$unique_key = 0;

		$final_causeries = get_posts( array(
			'post_parent'    => $causerie_id,
			'posts_per_page' => -1,
			'post_type'      => $this->get_type(),
		) );

		$unique_key = count( $final_causeries ) + 1;

		return $unique_key;
	}

	/**
	 * Expliqué is_former
	 *
	 * @since 6.6.0
	 * @version 6.6.0
	 *
	 * @param [type]  $final_causerie [description]
	 * @param [type]  $user_id        [description]
	 * @param [type]  $signature_data [description]
	 * @param boolean $is_former      [description]
	 *
	 * @todo: FIXME Commentaire
	 */
	public function add_participant( $final_causerie, $user_id, $is_former = false ) {

		if ( $is_former ) {
			$final_causerie->former['user_id'] = $user_id;
		} else {
			$final_causerie->participants[ $user_id ] = array(
				'user_id' => $user_id,
			);
		}

		return $final_causerie;
	}

	/**
	 * Expliqué is_former
	 *
	 * @since 6.6.0
	 * @version 6.6.0
	 *
	 * @param [type]  $final_causerie [description]
	 * @param [type]  $user_id        [description]
	 * @param [type]  $signature_data [description]
	 * @param boolean $is_former      [description]
	 *
	 * @todo: FIXME Commentaire
	 */
	public function add_signature( $final_causerie, $user_id, $signature_data, $is_former = false ) {
		$upload_dir = wp_upload_dir();

		// Association de la signature.
		if ( ! empty( $signature_data ) ) {
			$encoded_image = explode( ',', $signature_data )[1];
			$decoded_image = base64_decode( $encoded_image );
			file_put_contents( $upload_dir['basedir'] . '/digirisk/tmp/signature.png', $decoded_image );
			$file_id = \eoxia\File_Util::g()->move_file_and_attach( $upload_dir['basedir'] . '/digirisk/tmp/signature.png', $final_causerie->id );

			if ( $is_former ) {
				$final_causerie->former['signature_id']   = $file_id;
				$final_causerie->former['signature_date'] = current_time( 'mysql' );
			} else {
				$final_causerie->participants[ $user_id ]['signature_id']   = $file_id;
				$final_causerie->participants[ $user_id ]['signature_date'] = current_time( 'mysql' );
			}
		}

		return $final_causerie;
	}
}

Causerie_Intervention_Class::g();
