<?php
/**
 * Classe gérant les onglets de DigiRisk.
 *
 * @author Evarisk <dev@evarisk.com>
 * @since 6.4.4
 * @version 7.0.0
 * @copyright 2015-2018 Evarisk
 * @package DigiRisk
 */

namespace digi;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Classe gérant les onglets de DigiRisk.
 */
class Tab_Class extends \eoxia\Singleton_Util {

	/**
	 * Le constructeur
	 *
	 * @since 6.4.4
	 */
	protected function construct() {}

	/**
	 * Affiches les onglets selon le type de la société.
	 *
	 * @since 6.4.4
	 *
	 * @param integer $id       L'ID de la société, du groupement ou de l'unité de travail.
	 * @param string  $tab_slug Le slug de l'onglet.
	 * @param string  $type     Le type de la société.
	 */
	public function display( $id, $tab_slug, $type ) {
		$list_tab = apply_filters( 'digi_tab', array(), $id );

		$element = Society_Class::g()->show_by_type( $id );

		$tab       = new \stdClass();
		$tab->slug = $tab_slug;
		$tab       = $this->build_tab_to_display( $element, $tab_slug );

		\eoxia\View_Util::exec( 'digirisk', 'tab', 'main', array(
			'id'       => $id,
			'tab'      => $tab,
			'type'     => $type,
			'list_tab' => $list_tab,
		), false );
	}

	/**
	 * Charges le contenu d'un onglet
	 *
	 * @since 6.4.4
	 *
	 * @param integer $id     L'ID de la société, du groupement ou de l'unité de travail.
	 * @param string  $tab L'onglet à afficher.
	 */
	public function load_tab_content( $id, $tab ) {
		$element = Society_Class::g()->show_by_type( $id );

		$tab = $this->build_tab_to_display( $element, $tab );

		\eoxia\View_Util::exec( 'digirisk', 'tab', 'content', array(
			'id'  => $id,
			'tab' => $tab,
		), false );
	}

	/**
	 * Récupères les données de l'onglet à afficher.
	 *
	 * @since 7.0.0
	 *
	 * @param  Society_Model|Group_Model|Workunit_Model $element Les données de la société.
	 * @param  stdClass                                 $tab     L'onglet par défaut.
	 *
	 * @return array                                             Les données de l'onglet.
	 */
	public function build_tab_to_display( $element, $tab = null ) {
		if ( null === $tab ) {
			$tab = new \stdClass();
		}

		switch ( $element->data['type'] ) {
			case Society_Class::g()->get_type():
				$default_tab = clone \eoxia\Config_Util::$init['digirisk']->tab->default_tab->society;
				break;
			case Group_Class::g()->get_type():
				$default_tab = clone \eoxia\Config_Util::$init['digirisk']->tab->default_tab->groupment;
				break;
			case Workunit_Class::g()->get_type():
				$default_tab = clone \eoxia\Config_Util::$init['digirisk']->tab->default_tab->workunit;
				break;
			default:
				$default_tab = clone \eoxia\Config_Util::$init['digirisk']->tab->default_tab->society;
				break;
		}

		if ( ! empty( $tab->slug ) ) {
			$default_tab->slug = $tab->slug;
		}

		if ( ! empty( $tab->title ) ) {
			$default_tab->title = $tab->title;
		}

		$default_tab->title = $this->build_tab_title( $element, $default_tab );

		return $default_tab;
	}

	/**
	 * Construit le titre du contenu de l'onglet courant.
	 *
	 * @since 7.0.0
	 *
	 * @param  Society_Model|Group_Model|Workunit_Model $element  Les données de la société.
	 * @param  stdClass                                 $tab_data Les données de l'onglet à afficher.
	 *
	 * @return string                                            Le titre du contenu de l'onglet courant.
	 */
	private function build_tab_title( $element, $tab_data ) {
		$title = $tab_data->title . ' ';

		if ( Society_Class::g()->get_type() !== $element->data['type'] ) {
			$title .= ' ' . $element->data['unique_identifier'];
		}

		$title .= ' ' . $element->data['title'];

		return $title;
	}
}

Tab_Class::g();
