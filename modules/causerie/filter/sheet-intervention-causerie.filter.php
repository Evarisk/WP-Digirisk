<?php
/**
 * Classe gérant les filtres des fiches de groupement.
 *
 * @author    Evarisk <dev@evarisk.com>
 * @copyright (c) 2006-2018 Evarisk <dev@evarisk.com>.
 *
 * @license   AGPLv3 <https://spdx.org/licenses/AGPL-3.0-or-later.html>
 *
 * @package   DigiRisk\Classes
 *
 * @since     6.2.4
 */

namespace digi;

defined( 'ABSPATH' ) || exit;

/**
 * Sheet Groupement Filter class.
 */
class Sheet_Causerie_Intervention_Filter extends Identifier_Filter {

	/**
	 * Ajoutes le filtres
	 *
	 * @since 6.2.4
	 */
	public function __construct() {
		parent::__construct();

		add_filter( 'eo_model_sheet-causerie-inter_before_post', array( $this, 'before_save_doc' ), 10, 2 );
	}

	/**
	 * Ajoutes le titre du document ainsi que le GUID et le chemin vers celui-ci.
	 *
	 * Cette méthode est appelée avant l'ajout du document en base de donnée.
	 *
	 * @since 7.0.0
	 *
	 * @param  array $data Les données du document.
	 * @param  array $args Les données de la requête.
	 *
	 * @return mixed
	 */
	public function before_save_doc( $data, $args ) {
		$upload_dir = wp_upload_dir();

		$data['title']  = current_time( 'Ymd' ) . '_';
		$data['title'] .= '_fiche_causerie_intervention_' . $data['parent']->data['unique_identifier'] . '_' . $data['parent']->data['second_identifier'];
		$data['title']  = str_replace( '-', '_', $data['title'] );

		$data['guid'] = $upload_dir['baseurl'] . '/digirisk/0/' . sanitize_title( $data['title'] ) . '.odt';
		$data['path'] = $upload_dir['basedir'] . '/digirisk/0/' . sanitize_title( $data['title'] ) . '.odt';
		$data['path'] = str_replace( '\\', '/', $data['path'] );

		$data['_wp_attached_file'] = '/digirisk/0/' . sanitize_title( $data['title'] ) . '.odt';

		return $data;
	}
}

new Sheet_Causerie_Intervention_Filter();
