<?php
/**
 * Appelle le filtre pour ajouter le bouton "Télécharger le ZIP"
 *
 * @author Jimmy Latour <jimmy@evarisk.com>
 * @version 6.2.1.0
 * @copyright 2015-2016 Evarisk
 * @package zip
 * @subpackage filter
 */

namespace digi;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Gères l'action AJAX de la génération du DUER
 */
class ZIP_Filter {

	/**
	 * Le constructeur
	 */
	function __construct() {
		add_filter( 'digi_list_duer_single_item_action_end', array( $this, 'callback_list_duer_single_item_action_end' ), 10, 2 );
	}

	/**
	 * Cette méthode permet d'ajouter le bouton "Télécharger le ZIP" dans la liste des DUER
	 *
	 * @param  string     $content Un contenu vide.
	 * @param  DUER_Model $element L'objet DUER.
	 *
	 * @return string $content Le contenu du bouton "Télécharger le ZIP"
	 */
	public function callback_list_duer_single_item_action_end( $content, $element ) {
		if ( ! empty( $element->zip_path ) ) {
			ob_start();
			$zip_url = ZIP_Class::g()->get_zip_url( $element->zip_path );
			view_util::exec( 'zip', 'download-button', array( 'zip_url' => $zip_url ) );
			$content .= ob_get_clean();
		}
		return $content;
	}
}

new ZIP_Filter();
