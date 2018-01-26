<?php
/**
 * Définition du schéma des affichages légaux.
 *
 * @author Evarisk <dev@evarisk.com>
 * @since 6.0.0
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
	 * @since 6.0.0
	 * @version 6.5.0
	 *
	 * @param array $data       Data.
	 * @param mixed $req_method Peut être "GET", "POST", "PUT" ou null.
	 */
	public function __construct( $data = null, $req_method = null ) {
		$this->schema['occupational_health_service_id'] = array(
			'type'      => 'integer',
			'meta_type' => 'multiple',
			'default'   => 0,
		);

		$this->schema['detective_work_id'] = array(
			'type'      => 'integer',
			'meta_type' => 'multiple',
			'default'   => 0,
		);

		$this->schema['emergency_service'] = array(
			'type'      => 'array',
			'meta_type' => 'multiple',
			'child'     => array(),
		);

		$this->schema['emergency_service']['child']['samu'] = array(
			'type'      => 'string',
			'meta_type' => 'multiple',
			'default'   => '15',
		);

		$this->schema['emergency_service']['child']['police'] = array(
			'type'      => 'string',
			'meta_type' => 'multiple',
			'default'   => '17',
		);

		$this->schema['emergency_service']['child']['pompier'] = array(
			'type'      => 'string',
			'meta_type' => 'multiple',
			'default'   => '18',
		);

		$this->schema['emergency_service']['child']['emergency'] = array(
			'type'      => 'string',
			'meta_type' => 'multiple',
			'default'   => '112',
		);

		$this->schema['emergency_service']['child']['right_defender'] = array(
			'type'      => 'string',
			'meta_type' => 'multiple',
			'default'   => 'www.defenseurdesdroits.fr',
		);

		$this->schema['emergency_service']['child']['poison_control_center'] = array(
			'type'      => 'string',
			'meta_type' => 'multiple',
			'default'   => 'www.centres-antipoison.net',
		);

		$this->schema['safety_rule'] = array(
			'meta_type' => 'multiple',
			'type'      => 'array',
			'child'     => array(),
		);

		$this->schema['safety_rule']['child']['responsible_for_preventing'] = array(
			'type'      => 'string',
			'meta_type' => 'multiple',
			'default'   => '',
		);

		$this->schema['safety_rule']['child']['phone'] = array(
			'type'      => 'string',
			'meta_type' => 'multiple',
			'default'   => '',
		);

		$this->schema['safety_rule']['child']['location_of_detailed_instruction'] = array(
			'type'      => 'string',
			'meta_type' => 'multiple',
			'default'   => '',
		);

		$this->schema['working_hour'] = array(
			'meta_type' => 'multiple',
			'type'      => 'array',
			'child'     => array(),
		);

		$this->schema['working_hour']['child']['monday_morning'] = array(
			'type'      => 'string',
			'meta_type' => 'multiple',
			'default'   => '',
		);

		$this->schema['working_hour']['child']['tuesday_morning'] = array(
			'type'      => 'string',
			'meta_type' => 'multiple',
			'default'   => '',
		);

		$this->schema['working_hour']['child']['wednesday_morning'] = array(
			'type'      => 'string',
			'meta_type' => 'multiple',
			'default'   => '',
		);

		$this->schema['working_hour']['child']['thursday_morning'] = array(
			'type'      => 'string',
			'meta_type' => 'multiple',
			'default'   => '',
		);

		$this->schema['working_hour']['child']['friday_morning'] = array(
			'type'      => 'string',
			'meta_type' => 'multiple',
			'default'   => '',
		);

		$this->schema['working_hour']['child']['saturday_morning'] = array(
			'type'      => 'string',
			'meta_type' => 'multiple',
			'default'   => '',
		);

		$this->schema['working_hour']['child']['sunday_morning'] = array(
			'type'      => 'string',
			'meta_type' => 'multiple',
			'default'   => '',
		);

		$this->schema['working_hour']['child']['monday_afternoon'] = array(
			'type'      => 'string',
			'meta_type' => 'multiple',
			'default'   => '',
		);

		$this->schema['working_hour']['child']['tuesday_afternoon'] = array(
			'type'      => 'string',
			'meta_type' => 'multiple',
			'default'   => '',
		);

		$this->schema['working_hour']['child']['wednesday_afternoon'] = array(
			'type'      => 'string',
			'meta_type' => 'multiple',
			'default'   => '',
		);

		$this->schema['working_hour']['child']['thursday_afternoon'] = array(
			'type'      => 'string',
			'meta_type' => 'multiple',
			'default'   => '',
		);

		$this->schema['working_hour']['child']['friday_afternoon'] = array(
			'type'      => 'string',
			'meta_type' => 'multiple',
			'default'   => '',
		);

		$this->schema['working_hour']['child']['saturday_afternoon'] = array(
			'type'      => 'string',
			'meta_type' => 'multiple',
			'default'   => '',
		);

		$this->schema['working_hour']['child']['sunday_afternoon'] = array(
			'type'      => 'string',
			'meta_type' => 'multiple',
			'default'   => '',
		);

		$this->schema['derogation_schedule'] = array(
			'meta_type' => 'multiple',
			'type'      => 'array',
			'child'     => array(),
		);

		$this->schema['derogation_schedule']['child']['permanent'] = array(
			'type'      => 'string',
			'meta_type' => 'multiple',
			'default'   => '',
		);

		$this->schema['derogation_schedule']['child']['occasional'] = array(
			'type'      => 'string',
			'meta_type' => 'multiple',
			'default'   => '',
		);

		$this->schema['collective_agreement'] = array(
			'meta_type' => 'multiple',
			'type'      => 'array',
			'child'     => array(),
		);

		$this->schema['collective_agreement']['child']['title_of_the_applicable_collective_agreement'] = array(
			'type'      => 'string',
			'meta_type' => 'multiple',
			'default'   => '',
		);

		$this->schema['collective_agreement']['child']['location_and_access_terms_of_the_agreement'] = array(
			'type'      => 'string',
			'meta_type' => 'multiple',
			'default'   => '',
		);

		$this->schema['DUER'] = array(
			'meta_type' => 'multiple',
			'type'      => 'array',
			'child'     => array(),
		);

		$this->schema['DUER']['child']['how_access_to_duer'] = array(
			'type'      => 'string',
			'meta_type' => 'multiple',
			'default'   => '',
		);

		$this->schema['rules'] = array(
			'meta_type' => 'multiple',
			'type'      => 'array',
			'child'     => array(),
		);

		$this->schema['rules']['child']['location'] = array(
			'type'      => 'string',
			'meta_type' => 'multiple',
			'default'   => '',
		);

		$this->schema['participation_agreement'] = array(
			'meta_type' => 'multiple',
			'type'      => 'array',
			'child'     => array(),
		);

		$this->schema['participation_agreement']['child']['information_procedures'] = array(
			'type'      => 'string',
			'meta_type' => 'multiple',
			'default'   => '',
		);

		parent::__construct( $data, $req_method );
	}

}
