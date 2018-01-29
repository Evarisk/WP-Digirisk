<?php
/**
 * Les actions relatives aux outils pour les risques.
 *
 * @author Evarisk <dev@evarisk.com>
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
 * Les actions relatives aux outils pour les risques.
 */
class Risk_Tools_Action {

	/**
	 * Le constructeur fait appel aux actions définies par WordPress.
	 *
	 * @since 6.4.5
	 * @version 6.4.5
	 */
	function __construct() {
		add_action( 'wp_ajax_digi-risk-preset-reset', array( $this, 'callback_digi_risk_preset_reset' ) );
	}

	/**
	 * Remise à zéro des risques prédéfinis.
	 *
	 * Fonctionnement :
	 * 1- On récupère tous les risques ayant la meta preset. Pour chaque risque :
	 *   1.a - si aucun commentaire et aucune méthode/cotation n'est associée alors on le supprime
	 *   1.b - si une des deux informations est définies alors on ne le touche pas.
	 *
	 * 2- On relance la création des risques prédéfinis qui ne recréé que ceux qui n'existe pas.
	 *
	 * @return void
	 *
	 * @since 6.4.5
	 * @version 6.4.5
	 */
	public function callback_digi_risk_preset_reset() {
		check_ajax_referer( 'risk_preset_reset' );
		global $wpdb;

		// On commence par supprimer l'option qui contient l'information que les dangers prédéfinis ont déjà été créés.
		delete_option( \eoxia\Config_Util::$init['digirisk']->setting->key_preset_danger );

		// On récupère les risques ayant la meta "preset" qui correspond à un risque prédéfini.
		$presets_risks = $wpdb->get_results( $wpdb->prepare(
			"SELECT R.ID, RM.meta_value
			FROM {$wpdb->posts} AS R
				JOIN {$wpdb->postmeta} AS RM ON ( RM.post_id = R.ID )
			WHERE R.post_type = 'digi-risk'
				AND R.post_status != 'trash'
				AND RM.meta_key = %s
				AND RM.meta_value = %s",
		'_wpdigi_preset', true ) );

		if ( ! empty( $presets_risks ) ) {
			foreach ( $presets_risks as $risk ) {
				$risk_id = $risk->ID;
				$builded_risk = Risk_Class::g()->get( array( 'id' => $risk_id ), true );

				// Si le risque possède une évaluation c'est qu'il a été défini on ne le supprime pas.
				if ( 0 === $builded_risk->current_evaluation_id && ( ! isset( $builded_risk->comment ) || empty( $builded_risk->comment ) || ( ( 1 === count( $builded_risk->comment ) ) && ( 0 === $builded_risk->comment[0]->id ) ) ) ) {
					$builded_risk->status = 'trash';
					Risk_Class::g()->update( $builded_risk );
					\eoxia\LOG_Util::log( sprintf( __( 'Le risque %1$d a été mis à la corbeille car rien n\'avait été configuré', 'digirisk' ), $id ), 'digirisk-tools' );
				} else {
					\eoxia\LOG_Util::log( sprintf( __( 'Le risque %1$d n\'a pas été modifié car il avait déjà été configuré.', 'digirisk' ), $risk_id ), 'digirisk-tools' );
				}
			}
		}

		wp_send_json_success();
	}

}

new Risk_Tools_Action();
