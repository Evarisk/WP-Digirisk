<?php
/**
 * Définition du schéma des affichages légaux.
 *
 * @author Evarisk <dev@evarisk.com>
 * @since 6.1.3
 * @version 6.5.0
 * @copyright 2015-2018 Evarisk
 * @package DigiRisk
 */

namespace digi;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Définition du schéma des affichages légaux.
 */
class Legal_Display_Model extends \eoxia\Post_Model {

	/**
	 * Définition du schéma des affichages légaux.
	 *
	 * @since 6.1.3
	 * @version 6.1.5
	 *
	 * @param array $data       Data.
	 * @param mixed $req_method Peut être "GET", "POST", "PUT" ou null.
	 */
	public function __construct( $data = null, $req_method = null ) {
		$this->schema['occupational_health_service_id'] = array(
			'since'     => '6.1.3',
			'version'   => '6.1.3',
			'type'      => 'integer',
			'meta_type' => 'multiple',
			'default'   => 0,
		);

		$this->schema['detective_work_id'] = array(
			'since'     => '6.1.3',
			'version'   => '6.1.3',
			'type'      => 'integer',
			'meta_type' => 'multiple',
			'default'   => 0,
		);

		$this->schema['emergency_service'] = array(
			'since'     => '6.1.3',
			'version'   => '6.1.3',
			'type'      => 'array',
			'meta_type' => 'multiple',
			'child'     => array(),
		);

		$this->schema['emergency_service']['child']['samu'] = array(
			'since'     => '6.1.3',
			'version'   => '6.1.3',
			'type'      => 'string',
			'meta_type' => 'multiple',
			'default'   => '15',
		);

		$this->schema['emergency_service']['child']['police'] = array(
			'since'     => '6.1.3',
			'version'   => '6.1.3',
			'type'      => 'string',
			'meta_type' => 'multiple',
			'default'   => '17',
		);

		$this->schema['emergency_service']['child']['pompier'] = array(
			'since'     => '6.1.3',
			'version'   => '6.1.3',
			'type'      => 'string',
			'meta_type' => 'multiple',
			'default'   => '18',
		);

		$this->schema['emergency_service']['child']['emergency'] = array(
			'since'     => '6.1.3',
			'version'   => '6.1.3',
			'type'      => 'string',
			'meta_type' => 'multiple',
			'default'   => '112',
		);

		$this->schema['emergency_service']['child']['right_defender'] = array(
			'since'     => '6.1.3',
			'version'   => '6.1.3',
			'type'      => 'string',
			'meta_type' => 'multiple',
			'default'   => 'www.defenseurdesdroits.fr',
		);

		$this->schema['emergency_service']['child']['poison_control_center'] = array(
			'since'     => '6.1.3',
			'version'   => '6.1.3',
			'type'      => 'string',
			'meta_type' => 'multiple',
			'default'   => 'www.centres-antipoison.net',
		);

		$this->schema['safety_rule'] = array(
			'since'     => '6.1.3',
			'version'   => '6.1.3',
			'meta_type' => 'multiple',
			'type'      => 'array',
			'child'     => array(),
		);

		$this->schema['safety_rule']['child']['responsible_for_preventing'] = array(
			'since'     => '6.1.3',
			'version'   => '6.1.3',
			'type'      => 'string',
			'meta_type' => 'multiple',
			'default'   => '',
		);

		$this->schema['safety_rule']['child']['phone'] = array(
			'since'     => '6.1.3',
			'version'   => '6.1.3',
			'type'      => 'string',
			'meta_type' => 'multiple',
			'default'   => '',
		);

		$this->schema['safety_rule']['child']['location_of_detailed_instruction'] = array(
			'since'     => '6.1.3',
			'version'   => '6.1.3',
			'type'      => 'string',
			'meta_type' => 'multiple',
			'default'   => '',
		);

		$this->schema['working_hour'] = array(
			'since'     => '6.1.5',
			'version'   => '6.1.5',
			'meta_type' => 'multiple',
			'type'      => 'array',
			'child'     => array(),
		);

		$this->schema['working_hour']['child']['monday_morning'] = array(
			'since'     => '6.1.5',
			'version'   => '6.1.5',
			'type'      => 'string',
			'meta_type' => 'multiple',
			'default'   => '',
		);

		$this->schema['working_hour']['child']['tuesday_morning'] = array(
			'since'     => '6.1.5',
			'version'   => '6.1.5',
			'type'      => 'string',
			'meta_type' => 'multiple',
			'default'   => '',
		);

		$this->schema['working_hour']['child']['wednesday_morning'] = array(
			'since'     => '6.1.5',
			'version'   => '6.1.5',
			'type'      => 'string',
			'meta_type' => 'multiple',
			'default'   => '',
		);

		$this->schema['working_hour']['child']['thursday_morning'] = array(
			'since'     => '6.1.5',
			'version'   => '6.1.5',
			'type'      => 'string',
			'meta_type' => 'multiple',
			'default'   => '',
		);

		$this->schema['working_hour']['child']['friday_morning'] = array(
			'since'     => '6.1.5',
			'version'   => '6.1.5',
			'type'      => 'string',
			'meta_type' => 'multiple',
			'default'   => '',
		);

		$this->schema['working_hour']['child']['saturday_morning'] = array(
			'since'     => '6.1.5',
			'version'   => '6.1.5',
			'type'      => 'string',
			'meta_type' => 'multiple',
			'default'   => '',
		);

		$this->schema['working_hour']['child']['sunday_morning'] = array(
			'since'     => '6.1.5',
			'version'   => '6.1.5',
			'type'      => 'string',
			'meta_type' => 'multiple',
			'default'   => '',
		);

		$this->schema['working_hour']['child']['monday_afternoon'] = array(
			'since'     => '6.1.5',
			'version'   => '6.1.5',
			'type'      => 'string',
			'meta_type' => 'multiple',
			'default'   => '',
		);

		$this->schema['working_hour']['child']['tuesday_afternoon'] = array(
			'since'     => '6.1.5',
			'version'   => '6.1.5',
			'type'      => 'string',
			'meta_type' => 'multiple',
			'default'   => '',
		);

		$this->schema['working_hour']['child']['wednesday_afternoon'] = array(
			'since'     => '6.1.5',
			'version'   => '6.1.5',
			'type'      => 'string',
			'meta_type' => 'multiple',
			'default'   => '',
		);

		$this->schema['working_hour']['child']['thursday_afternoon'] = array(
			'since'     => '6.1.5',
			'version'   => '6.1.5',
			'type'      => 'string',
			'meta_type' => 'multiple',
			'default'   => '',
		);

		$this->schema['working_hour']['child']['friday_afternoon'] = array(
			'since'     => '6.1.5',
			'version'   => '6.1.5',
			'type'      => 'string',
			'meta_type' => 'multiple',
			'default'   => '',
		);

		$this->schema['working_hour']['child']['saturday_afternoon'] = array(
			'since'     => '6.1.5',
			'version'   => '6.1.5',
			'type'      => 'string',
			'meta_type' => 'multiple',
			'default'   => '',
		);

		$this->schema['working_hour']['child']['sunday_afternoon'] = array(
			'since'     => '6.1.5',
			'version'   => '6.1.5',
			'type'      => 'string',
			'meta_type' => 'multiple',
			'default'   => '',
		);

		$this->schema['derogation_schedule'] = array(
			'since'     => '6.1.3',
			'version'   => '6.1.3',
			'meta_type' => 'multiple',
			'type'      => 'array',
			'child'     => array(),
		);

		$this->schema['derogation_schedule']['child']['permanent'] = array(
			'since'     => '6.1.3',
			'version'   => '6.1.3',
			'type'      => 'string',
			'meta_type' => 'multiple',
			'default'   => '',
		);

		$this->schema['derogation_schedule']['child']['occasional'] = array(
			'since'     => '6.1.3',
			'version'   => '6.1.3',
			'type'      => 'string',
			'meta_type' => 'multiple',
			'default'   => '',
		);

		$this->schema['collective_agreement'] = array(
			'since'     => '6.1.5',
			'version'   => '6.1.5',
			'meta_type' => 'multiple',
			'type'      => 'array',
			'child'     => array(),
		);

		$this->schema['collective_agreement']['child']['title_of_the_applicable_collective_agreement'] = array(
			'since'     => '6.1.5',
			'version'   => '6.1.5',
			'type'      => 'string',
			'meta_type' => 'multiple',
			'default'   => '',
		);

		$this->schema['collective_agreement']['child']['location_and_access_terms_of_the_agreement'] = array(
			'since'     => '6.1.5',
			'version'   => '6.1.5',
			'type'      => 'string',
			'meta_type' => 'multiple',
			'default'   => '',
		);

		$this->schema['DUER'] = array(
			'since'     => '6.1.5',
			'version'   => '6.1.5',
			'meta_type' => 'multiple',
			'type'      => 'array',
			'child'     => array(),
		);

		$this->schema['DUER']['child']['how_access_to_duer'] = array(
			'since'     => '6.1.5',
			'version'   => '6.1.5',
			'type'      => 'string',
			'meta_type' => 'multiple',
			'default'   => '',
		);

		$this->schema['rules'] = array(
			'since'     => '6.1.5',
			'version'   => '6.1.5',
			'meta_type' => 'multiple',
			'type'      => 'array',
			'child'     => array(),
		);

		$this->schema['rules']['child']['location'] = array(
			'since'     => '6.1.5',
			'version'   => '6.1.5',
			'type'      => 'string',
			'meta_type' => 'multiple',
			'default'   => '',
		);

		$this->schema['participation_agreement'] = array(
			'since'     => '6.1.5',
			'version'   => '6.1.5',
			'meta_type' => 'multiple',
			'type'      => 'array',
			'child'     => array(),
		);

		$this->schema['participation_agreement']['child']['information_procedures'] = array(
			'since'     => '6.1.5',
			'version'   => '6.1.5',
			'type'      => 'string',
			'meta_type' => 'multiple',
			'default'   => '',
		);

		parent::__construct( $data, $req_method );
	}

}
