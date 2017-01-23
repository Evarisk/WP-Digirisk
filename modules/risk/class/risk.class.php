<?php
/**
 * Classe gérant les risques
 *
 * @author Jimmy Latour <jimmy@evarisk.com>
 * @since 0.1
 * @version 6.2.4.0
 * @copyright 2015-2017 Evarisk
 * @package risk
 * @subpackage class
 */

namespace digi;

if ( ! defined( 'ABSPATH' ) ) {	exit; }

/**
 * Classe gérant les risques
 */
class Risk_Class extends Post_Class {

	/**
	 * Le nom du modèle
	 *
	 * @var string
	 */
	protected $model_name = '\digi\risk_model';

	/**
	 * Le post type
	 *
	 * @var string
	 */
	protected $post_type = 'digi-risk';

	/**
	 * La clé principale du modèle
	 *
	 * @var string
	 */
	protected $meta_key = '_wpdigi_risk';

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
	protected $after_get_function = array( '\digi\get_identifier', '\digi\get_full_risk' );

	/**
	 * La route pour accéder à l'objet dans la rest API
	 *
	 * @var string
	 */
	protected $base = 'digirisk/risk';

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
	public $element_prefix = 'R';

	/**
	 * La limite des risques a afficher par page
	 *
	 * @var integer
	 */
	protected $limit_risk = -1;

	/**
	 * Le nom pour le resgister post type
	 *
	 * @var string
	 */
	protected $post_type_name = 'Risques';

	/**
	 * Constructeur
	 *
	 * @return void
	 *
	 * @since 0.1
	 * @version 6.2.3.0
	 */
	protected function construct() {
		parent::construct();
	}

	/**
	 * Charges la liste des risques même ceux des enfants. Et appelle le template pour les afficher.
	 * Récupères le schéma d'un risque pour l'entrée d'ajout de risque dans le tableau.
	 *
	 * @param  integer $society_id L'ID de la société.
	 * @return void
	 *
	 * @since 0.1
	 * @version 6.2.3.0
	 * @todo Doit charger les risques des enfants
	 */
	public function display( $society_id ) {
		$society = Society_Class::g()->show_by_type( $society_id );

		$risk_schema = $this->get( array( 'schema' => true ) );
		$risk_schema = $risk_schema[0];

		$risks = $this->get( array( 'post_parent' => $society_id ) );

		if ( count( $risks ) > 1 ) {
			usort( $risks, function( $a, $b ) {
				if ( $a->evaluation->risk_level['equivalence'] === $b->evaluation->risk_level['equivalence'] ) {
					return 0;
				}
				return ( $a->evaluation->risk_level['equivalence'] > $b->evaluation->risk_level['equivalence'] ) ? -1 : 1;
			} );
		}

		View_Util::exec( 'risk', 'main', array( 'society' => $society, 'society_id' => $society_id, 'risks' => $risks, 'risk_schema' => $risk_schema ) );
	}
}

Risk_Class::g();
