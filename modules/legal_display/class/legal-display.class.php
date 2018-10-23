<?php
/**
 * Controlleur du modèle "Legal_Display_Model".
 *
 * @author    Evarisk <dev@evarisk.com>
 * @copyright (c) 2006-2018 Evarisk <dev@evarisk.com>.
 *
 * @license   AGPLv3 <https://spdx.org/licenses/AGPL-3.0-or-later.html>
 *
 * @package   DigiRisk\Classes
 *
 * @since     6.1.5
 */

namespace digi;

defined( 'ABSPATH' ) || exit;

/**
 * Legal Display Class.
 */
class Legal_Display_Class extends Document_Class {

	/**
	 * Le nom du modèle
	 *
	 * @var string
	 */
	protected $model_name = '\digi\Legal_Display_Model';

	/**
	 * Le post type
	 *
	 * @var string
	 */
	protected $type = 'digi-legal-display';

	/**
	 * La clé principale du modèle
	 *
	 * @var string
	 */
	protected $meta_key = '_wpdigi_legal_display';

	/**
	 * La route pour accéder à l'objet dans la rest API
	 *
	 * @var string
	 */
	protected $base = 'legal-display';

	/**
	 * La version de l'objet
	 *
	 * @var string
	 */
	protected $version = '0.1';

	/**
	 * Le préfixe de l'objet dans DigiRisk
	 *
	 * @var string
	 */
	public $element_prefix = 'LD';

	/**
	 * Le nom pour le resgister post type
	 *
	 * @var string
	 */
	protected $post_type_name = 'Affichages légal';

	/**
	 * Tableau contenant les messages à afficher dans la vue de la génération de ce document.
	 *
	 * @since 7.0.0
	 */
	protected $messages = array();

	/**
	 * Initialises les messages d'information pour la génération de l'ODT.
	 */
	protected function construct() {
		$this->message['empty']    = __( 'Aucun affichage légal générés', 'digirisk' );
	}

	/**
	 * Le formulaire pour générer un affichage légal
	 *
	 * @since 6.0.0
	 *
	 * @param integer $element_id L'ID de la société.
	 */
	public function display_form( $element_id ) {
		$legal_display = $this->get( array(
			'posts_per_page' => 1,
			'post_parent'    => $element_id,
		), true );

		if ( empty( $legal_display ) ) {
			$legal_display = $this->get( array(
				'schema' => true,
			), true );
		}

		\eoxia\View_Util::exec( 'digirisk', 'legal_display', 'form/display', array(
			'element_id'    => $element_id,
			'legal_display' => $legal_display,
		) );
	}

	/**
	 * Sauvegardes les données de l'affichage légal
	 *
	 * @since   6.0.0
	 *
	 * @param  array $data  Les données de l'affichage légal.
	 *
	 * @return Legal_Display_Model L'objet généré
	 */
	public function save_data( $data ) {
		return $this->create( $data );
	}
}

Legal_Display_Class::g();
