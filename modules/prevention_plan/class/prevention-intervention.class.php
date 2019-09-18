<?php
/**
 * La classe gérant les préventions des plans de prévention.
 *
 * @author    Evarisk <dev@evarisk.com>
 * @since     6.6.0
 * @version   6.6.0
 * @copyright 2019 Evarisk.
 * @package   DigiRisk
 */

namespace digi;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Causerie Intevention Class.
 */
class Prevention_Intervention_Class extends \eoxia\Post_Class {

	/**
	 * Le nom du modèle
	 *
	 * @var string
	 */
	protected $model_name = '\digi\Prevention_Intervention_Model';

	/**
	 * Le post type
	 *
	 * @var string
	 */
	protected $type = 'digi-prev-interv';

	/**
	 * La route pour accéder à l'objet dans la rest API
	 *
	 * @var string
	 */
	protected $base = 'prevention-intervention';

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
	protected $meta_key = '_wpdigi_prevention_intervention';

	/**
	 * Le préfixe de l'objet dans DigiRisk
	 *
	 * @var string
	 */
	public $element_prefix = 'F';

	/**
	 * Le nom pour le resgister post type
	 *
	 * @var string
	 */
	protected $post_type_name = 'Prevention_Intervention';

	public function display_table( $prevention_id, $edit = true ){
		$parentid = $prevention_id;

		$prevention = Prevention_Class::g()->get( array( 'id' => $prevention_id ), true );
		$interventions = Prevention_Intervention_Class::g()->get( array( 'post_parent' => $parentid ) );

		foreach( $interventions as $key => $intervention ){
			$id = $intervention->data[ 'unite_travail' ];
			$target = "digi-fiche-de-poste";
			$title  = esc_html__( 'Les fiches de poste', 'digirisk' );

			$tab        = new \stdClass();
			$tab->title = $title;
			$tab->slug  = $target;

			$element = Society_Class::g()->show_by_type( $id );
			$tab = Tab_Class::g()->build_tab_to_display( $element, $tab );

			$interventions[ $key ]->data[ 'unite_travail_tab' ] = $tab;
		}

		\eoxia\View_Util::exec( 'digirisk', 'prevention_plan', 'start/step-2-table-intervention-foreach', array(
			'interventions' => $interventions,
			'prevention' => $prevention,
			'edit' => $edit
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

Prevention_Intervention_Class::g();
