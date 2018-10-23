<?php
/**
 * Les actions relatives aux outils pour les categories de risque.
 *
 * @author Jimmy Latour <jimmy@evarisk.com>
 * @since 6.4.5
 * @version 6.4.5
 * @copyright 2015-2017 Evarisk
 * @package DigiRisk
 */

namespace digi;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
/**
 * Les actions relatives aux outils pour les categories de risque.
 */
class Risk_Category_Tools_Action {

	/**
	 * Le constructeur fait appel aux actions définies par WordPress.
	 *
	 * @since 6.4.5
	 * @version 6.4.5
	 */
	function __construct() {
		add_action( 'wp_ajax_digi-fix-categories', array( $this, 'callback_digi_fix_categories' ) );
	}

	/**
	 * Correction des différences de catégories de danger et catégories de risques.
	 *
	 * Fonctionnement : On a trois cas possibles
	 * 1- Le risque possède une categorie de danger ET une catégorie de risque ET la correspondance de l'INRS est correcte:      on ne fait rien.
	 * 2- Le risque possède une categorie de danger MAIS ne possède pas de catégorie de risque :                                 on ajoute la catégorie de risque INRS correspondante à la catégorie de danger.
	 * 3- Le risque possède une categorie de danger ET une catégorie de risque MAIS la correspondance de l'INRS est incorrecte:  on supprime la catégorie de risque associée et on associe celle définie par l'INRS.
	 *
	 * @return void
	 *
	 * @since 6.4.5
	 * @version 6.4.5
	 */
	public function callback_digi_fix_categories() {
		check_ajax_referer( 'digi-fix-danger-categories' );

		$digi_danger_category = ! empty( $_POST ) && ! empty( $_POST['old_term_id'] ) && is_int( (int) $_POST['old_term_id'] ) ? (int) $_POST['old_term_id'] : 0;
		$digi_category_risk = ! empty( $_POST ) && ! empty( $_POST['new_term_id'] ) && is_int( (int) $_POST['new_term_id'] ) ? (int) $_POST['new_term_id'] : 0;
		$total_risk_done = 0;
		$total_risk_to_do = 0;

		// Cas n°2: Le risque possède une categorie de danger MAIS ne possède pas de catégorie de risque : on ajoute la catégorie de risque INRS correspondante à la catégorie de danger.
		$fix_cat_matching = Risk_Category_Tools_Class::g()->associate_missing_category( $digi_danger_category, $digi_category_risk );
		$total_risk_to_do += $fix_cat_matching['total'];
		$total_risk_done += $fix_cat_matching['done'];

		// Cas n°3: Le risque possède une categorie de danger ET une catégorie de risque MAIS la correspondance de l'INRS est incorrecte: on supprime la catégorie de risque associée et on associe celle définie par l'INRS.
		$fix_cat_matching = Risk_Category_Tools_Class::g()->fix_categories_matching( $digi_danger_category, $digi_category_risk );
		$total_risk_to_do += $fix_cat_matching['total'];
		$total_risk_done += $fix_cat_matching['done'];

		wp_send_json_success( array(
			'message' => sprintf( __( '%1$d/%2$d risque(s) traité(s).', 'digirisk' ), $total_risk_done, $total_risk_to_do ),
		) );
	}

}

new Risk_Category_Tools_Action();
