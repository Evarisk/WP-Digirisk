<?php
/**
 * Classe gérant les affichages légaux
 *
 * @author Jimmy Latour <jimmy@evarisk.com>
 * @since 0.1
 * @version 6.2.4.0
 * @copyright 2015-2017 Evarisk
 * @package legal_display
 * @subpackage class
 */

namespace digi;

if ( ! defined( 'ABSPATH' ) ) { exit; }

/**
 * Classe gérant les affichages légaux
 */
class Legal_Display_Class extends Post_Class {

	/**
	 * Le nom du modèle
	 *
	 * @var string
	 */
	protected $model_name = '\digi\legal_display_model';

	/**
	 * Le post type
	 *
	 * @var string
	 */
	protected $post_type  = 'digi-legal-display';

	/**
	 * La clé principale du modèle
	 *
	 * @var string
	 */
	protected $meta_key   = '_wpdigi_legal_display';

	/**
	 * La route pour accéder à l'objet dans la rest API
	 *
	 * @var string
	 */
	protected $base 			= 'digirisk/legal-display';

	/**
	 * La version de l'objet
	 *
	 * @var string
	 */
	protected $version 		= '0.1';

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
	protected $after_get_function = array( '\digi\get_identifier', '\digi\get_full_legal_display' );

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
	 * Constructeur
	 *
	 * @return void
	 *
	 * @since 0.1
	 * @version 6.2.4.0
	 */
	protected function construct() {
		parent::construct();
		add_filter( 'json_endpoints', array( $this, 'callback_register_route' ) );
	}

	/**
	 * Appelle la méthode display_form
	 *
	 * @param  mixed $element Les données de la société.
	 * @return void
	 *
	 * @since 0.1
	 * @version 6.2.4.0
	 */
	public function display( $element ) {
		view_util::exec( 'legal_display', 'main', array( 'element' => $element, 'element_id' => $element->id ) );
		$this->display_form( $element );
	}

	/**
	 * Appelle le template list.view.php dans le dossier /view/
	 *
	 * @param  integer $element_id L'ID de l'élement.
	 * @return void
	 *
	 * @since 0.1
	 * @version 6.2.4.0
	 */
	public function display_document_list( $element_id ) {
		$list_document = Affichage_Legal_A3_Class::g()->get( array( 'post_parent' => $element_id, 'post_status' => array( 'publish', 'inherit' ) ) );
		$list_document = array_merge( $list_document, Affichage_Legal_A4_Class::g()->get( array( 'post_parent' => $element_id, 'post_status' => array( 'publish', 'inherit' ) ) ) );

		// Trie le tableau par ordre des clés.
		usort( $list_document, function( $a, $b ) {
			if ( $a->unique_key === $b->unique_key ) {
				return 0;
			}

			return ( $a->unique_key > $b->unique_key ) ? -1 : 1;
		} );

		View_Util::exec( 'legal_display', 'list', array( 'list_document' => $list_document ) );
	}

	/**
	 * Le formulaire pour générer un affichage légal
	 *
	 * @param  object $element L'objet affichage_legal.
	 * @return void
	 */
	public function display_form( $element ) {
		$legal_display = $this->get( array( 'post_parent' => $element->id ), array( '\digi\detective_work', '\digi\occupational_health_service', '\digi\address' ) );

		if ( empty( $legal_display ) ) {
			$legal_display = $this->get( array( 'schema' => true ), array( '\digi\detective_work', '\digi\occupational_health_service', '\digi\address' ) );
		}

		$legal_display = $legal_display[0];

		view_util::exec( 'legal_display', 'form/display', array( 'element_id' => $element->id, 'legal_display' => $legal_display ) );
	}

	/**
	 * Sauvegardes les données de l'affichage légal
	 *
	 * @param  array $data  Les données de l'affichage légal.
	 * @return Legal_Display_Model L'objet généré
	 */
	public function save_data( $data ) {
		return $this->create( $data );
	}
}

Legal_Display_Class::g();
