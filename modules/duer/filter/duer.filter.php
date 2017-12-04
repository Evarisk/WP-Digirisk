<?php
/**
 * Les filtres relatives au DUER
 *
 * @author Jimmy Latour <jimmy@evarisk.com>
 * @since 6.2.5
 * @version 6.4.4
 * @copyright 2015-2017 Evarisk
 * @package DigiRisk
 */

namespace digi;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Les filtres relatives au DUER
 */
class DUER_Filter {

	/**
	 * Le constructeur ajoute le filtre society_header_end
	 *
	 * @since 6.2.5
	 * @version 6.4.4
	 */
	public function __construct() {
		add_filter( 'society_header_end', array( $this, 'callback_society_header_end' ), 10, 1 );
		add_filter( 'digi_tab', array( $this, 'callback_digi_tab' ), 5, 2 );
	}

	/**
	 * Appelle la vue button-generate-duer.view.php avec le groupement en paramètre.
	 *
	 * @since 6.2.5
	 * @version 6.4.4
	 *
	 * @param  Society_Model $element Les données du groupement.
	 * @return void
	 */
	public function callback_society_header_end( $element ) {
		if ( 'digi-society' === $element->type ) {
			\eoxia\View_Util::exec( 'digirisk', 'duer', 'button-generate-duer', array(
				'element' => $element,
			) );
		}
	}

	/**
	 * Ajoutes une entrée dans le tableau $list_tab
	 *
	 * @param  array   $list_tab  La liste des filtres.
	 * @param  integer $id        L'ID de la société.
	 * @return array              La liste des filtres + le filtre ajouté par cette méthode.
	 *
	 * @since 6.4.4
	 * @version 6.4.4
	 */
	public function callback_digi_tab( $list_tab, $id ) {
		$list_tab['digi-group']['list-duer'] = array(
			'type'         => 'text',
			'text'         => __( 'Liste des risques ', 'digirisk' ),
			'title'        => __( 'Liste des risques', 'digirisk' ),
			'parent_class' => 'gp button red uppercase',
		);

		return $list_tab;
	}
}

new DUER_Filter();
