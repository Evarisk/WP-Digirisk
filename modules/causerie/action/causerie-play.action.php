<?php
/**
 * Gestion des actions des causeries pour la lecture.
 *
 * @author Evarisk <dev@evarisk.com>
 * @since 6.6.0
 * @version 6.6.0
 * @copyright 2015-2018
 * @package DigiRisk
 */

namespace digi;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Gestion des actions des causeries pour la lecture.
 */
class Causerie_Play_Action {

	/**
	 * Le constructeur appelle une action personnalisée
	 */
	public function __construct() {
		add_action( 'admin_post_start_causerie', array( $this, 'callback_start_causerie' ) );
		add_action( 'wp_ajax_load_modal_signature', array( $this, 'callback_load_modal_signature' ) );
	}

	/**
	 * Dupliques la causerie sélectionné puis appel la vue suivante.
	 *
	 * @since 1.7.0
	 * @version 1.7.0
	 *
	 * @return void
	 */
	public function callback_start_causerie() {
		$id = ! empty( $_GET['id'] ) ? (int) $_GET['id'] : 0;

		$causerie = Causerie_Class::g()->get( array( 'id' => $id ), true );

		// Clone la causerie.
		$final_causerie = $causerie;
		// On met l'ID à 0 pour en créer un nouveau.
		$final_causerie->id                = 0;
		$final_cuaserie->parent_id         = $causerie->id;
		$final_causerie->unique_key        = 1;
		$final_causerie->unique_identifier = $final_causerie->unique_identifier . ' - ' . Final_Causerie_Class::g()->element_prefix . $final_causerie->unique_key;
		$final_causerie->type              = Final_Causerie_Class::g()->get_type();

		$tmp_image_ids = $final_causerie->associated_document_id['image'];
		// Supprimes les liaisons avec les images, qui seront par la suite dupliquées.
		unset( $final_causerie->associated_document_id['image'] );
		$final_causerie->thumbnail_id = 0;

		$final_causerie = Final_Causerie_Class::g()->update( $final_causerie );

		// Duplication des images.
		if ( ! empty( $tmp_image_ids ) ) {
			$final_causerie->associated_document_id['image'] = array();

			foreach ( $tmp_image_ids as $image_id ) {
				$attachment_path = get_attached_file( $image_id );
				$file_id         = \eoxia\File_Util::g()->move_file_and_attach( $attachment_path, 0 );

				if ( empty( $final_causerie->thumbnail_id ) ) {
					$final_causerie->thumbnail_id = $file_id;
				}

				$final_causerie->associated_document_id['image'][] = $file_id;
			}
		}

		$final_causerie = Final_Causerie_Class::g()->update( $final_causerie );

		wp_redirect( admin_url( 'admin.php?page=digirisk-causerie&id=' . $final_causerie->id . '&step=1' ) );
	}

	public function callback_load_modal_signature() {
		check_ajax_referer( 'load_modal_signature' );

		ob_start();
		\eoxia\View_Util::exec( 'digirisk', 'causerie', 'start/modal' );

		wp_send_json_success( array(
			'view' => ob_get_clean(),
		) );
	}
}

new Causerie_Play_Action();
