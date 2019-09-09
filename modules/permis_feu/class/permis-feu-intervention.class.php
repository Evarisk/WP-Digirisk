<?php
/**
 * La classe gérant les interventions des permis de feu
 *
 * @author    Evarisk <dev@evarisk.com>
 * @since     7.3.0
 * @version   7.3.0
 * @copyright 2019 Evarisk.
 * @package   DigiRisk
 */

namespace digi;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * La classe gérant les causeries
 */
class Permis_Feu_Intervention_Class extends \eoxia\Post_Class {

	/**
	 * Le nom du modèle
	 *
	 * @var string
	 */
	protected $model_name = '\digi\Permis_Feu_Intervention_Model';

	/**
	 * Le post type
	 *
	 * @var string
	 */
	protected $type = 'digi-permisfeu-inter';

	/**
	 * La route pour accéder à l'objet dans la rest API
	 *
	 * @var string
	 */
	protected $base = 'permisfeuintervention';

	/**
	 * La version de l'objet
	 *
	 * @var string
	 */
	protected $version = '0.1';

	/**
	 * La clé principale du modèle
	 *
	 * @var string
	 */
	protected $meta_key = '_wpdigi_permis_feu_intervention';

	/**
	 * Le préfixe de l'objet dans DigiRisk
	 *
	 * @var string
	 */
	public $element_prefix = 'C';


	public function display_intervention_table( $permis_feu_id ){

		$permis_feu = Permis_Feu_Class::g()->get( array( 'id' => $permis_feu_id ), true );
		$interventions = Permis_Feu_Intervention_Class::g()->get( array( 'post_parent' => $permis_feu_id ) );

		\eoxia\View_Util::exec( 'digirisk', 'permis_feu', 'start/step-2-table-intervention-foreach', array(
			'interventions' => $interventions,
			'permis_feu'    => $permis_feu
		) );
	}

	public function return_name_workunit( $id = 0 ){
		$workunit = get_post( $id );
		if( ! empty( $workunit ) ){
			return $workunit->post_title;
		}
		return '';
	}

}

Permis_Feu_Intervention_Class::g();
