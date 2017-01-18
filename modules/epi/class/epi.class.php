<?php
/**
 * Classe gérant les EPI
 *
 * @author Jimmy Latour <jimmy@evarisk.com>
 * @since 0.1
 * @version 6.2.4.0
 * @copyright 2015-2017 Evarisk
 * @package epi
 * @subpackage class
 */

namespace digi;

if ( ! defined( 'ABSPATH' ) ) { exit; }

/**
 * Classe gérant les EPI
 */
class EPI_Class extends Post_Class {

	/**
	 * Le nom du modèle
	 *
	 * @var string
	 */
	protected $model_name   = '\digi\epi_model';

	/**
	 * Le post type
	 *
	 * @var string
	 */
	protected $post_type    = 'digi-epi';

	/**
	 * La clé principale du modèle
	 *
	 * @var string
	 */
	protected $meta_key    	= '_wpdigi_epi';

	/**
	 * La route pour accéder à l'objet dans la rest API
	 *
	 * @var string
	 */
	protected $base = 'digirisk/epi';

	/**
	 * La version de l'objet
	 *
	 * @var string
	 */
	protected $version = '0.1';

	/**
	 * La fonction appelée automatiquement avant la création de l'objet dans la base de donnée
	 *
	 * @var array
	 */
	protected $before_post_function = array( '\digi\construct_identifier' );

	/**
	 * La fonction appelée automatiquement après la récupération de l'objet dans la base de donnée
	 *
	 * @var array
	 */
	protected $after_get_function = array( '\digi\get_identifier', '\digi\update_remaining_time' );

	/**
	 * Le préfixe de l'objet dans DigiRisk
	 *
	 * @var string
	 */
	public $element_prefix = 'EPI';

	/**
	 * La limite des risques a afficher par page
	 *
	 * @var integer
	 */
	protected $limit_epi = -1;

	/**
	 * Le nom pour le resgister post type
	 *
	 * @var string
	 */
	protected $post_type_name = 'Équipements de protection individuelle';

	/**
	 * Instanciation principale de l'extension / Plugin instanciation
	 */
	protected function construct() {
		parent::construct();
		add_filter( 'json_endpoints', array( $this, 'callback_register_route' ) );
	}

	/**
	 * Charges le schéma des EPI puis appel la vue epi/view/main.view.php
	 *
	 * @param  integer $society_id L'ID de la société.
	 *
	 * @return void
	 *
	 * @since 0.1
	 * @version 6.2.4.0
	 */
	public function display( $society_id ) {
		$epi = $this->get( array( 'schema' => true ) );
		$epi = $epi[0];
		View_Util::exec( 'epi', 'main', array( 'society_id' => $society_id, 'epi' => $epi ) );
	}

	/**
	 * Charges tous les EPI de la société et appel la vue epi/view/list.view.php
	 *
	 * @param  integer $society_id L'ID de la société.
	 *
	 * @return void
	 *
	 * @since 0.1
	 * @version 6.2.4.0
	 */
	public function display_epi_list( $society_id ) {
		$society = Society_Class::g()->show_by_type( $society_id );

		$epi_list = EPI_Class::g()->get( array( 'post_parent' => $society_id ) );

		View_Util::exec( 'epi', 'list', array( 'society_id' => $society_id, 'epi_list' => $epi_list ) );
	}
}
EPI_Class::g();
