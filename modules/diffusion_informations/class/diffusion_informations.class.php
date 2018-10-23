<?php
/**
 * Classe gérant les diffusions d'informations
 *
 * @author    Evarisk <dev@evarisk.com>
 * @since     6.4.0
 * @version   7.0.0
 * @copyright 2018 Evarisk.
 * @package   DigiRisk
 */

namespace digi;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Classe gérant les diffusions d'informations
 */
class Diffusion_Informations_Class extends Document_Class {

	/**
	 * Le nom du modèle
	 *
	 * @var string
	 */
	protected $model_name = '\digi\Diffusion_Informations_Model';

	/**
	 * Le post type
	 *
	 * @var string
	 */
	protected $type = 'digi-diffusion-info';

	/**
	 * La clé principale du modèle
	 *
	 * @var string
	 */
	protected $meta_key = '_wpdigi_diffusion_information';

	/**
	 * La route pour accéder à l'objet dans la rest API
	 *
	 * @var string
	 */
	protected $base = 'diffusion-information';

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
	public $element_prefix = 'DI';

	/**
	 * Le nom pour le resgister post type
	 *
	 * @var string
	 */
	protected $post_type_name = 'Diffusion information';

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
		$this->message['empty']    = __( 'Aucun diffusion d\'information générés', 'digirisk' );
		$this->message['generate'] = __( 'Cliquer pour générer un diffusion d\'information', 'digirisk' );
	}

	/**
	 * Le formulaire pour générer une diffusion d'information
	 *
	 * @since   6.2.10
	 *
	 * @param  object $element La société.
	 *
	 * @return void
	 */
	public function display_form( $element_id ) {
		$diffusion_information = $this->get( array(
			'post_parent'    => $element_id,
			'posts_per_page' => 1,
			'post_status'    => array(
				'publish',
				'inherit',
			),
		), true );

		if ( empty( $diffusion_information ) ) {
			$diffusion_information = $this->get( array(
				'schema' => true,
			), true );
		}

		\eoxia\View_Util::exec( 'digirisk', 'diffusion_informations', 'form', array(
			'element_id'            => $element_id,
			'diffusion_information' => $diffusion_information,
		) );
	}
}

Diffusion_Informations_Class::g();
