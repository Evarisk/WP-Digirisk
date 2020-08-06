<?php
/**
 * Définition des champs d'un utilisateur DigiRisk.
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
 * Définition des champs d'un utilisateur DigiRisk.
 */
class User_Model extends \eoxia\User_Model {

	/**
	 * Définition des champs d'un utilisateur DigiRisk.
	 *
	 * @since 6.0.0
	 * @version 6.5.0
	 *
	 * @param array $data       Data.
	 * @param mixed $req_method Peut être "GET", "POST", "PUT" ou null.
	 */
	public function __construct( $data = null, $req_method = null ) {
		$this->schema['hiring_date'] = array(
			'type'      => 'string',
			'meta_type' => 'multiple',
			'bydefault' => 'Pas configuré',
			'since'     => '6.0.0',
			'version'   => '6.0.0',
		);

		$this->schema['social_security_number'] = array(
			'type'      => 'string',
			'meta_type' => 'multiple',
			'bydefault' => '',
			'since'     => '6.0.0',
			'version'   => '6.0.0',
		);

		$this->schema['job'] = array(
			'type'      => 'string',
			'meta_type' => 'multiple',
			'bydefault' => '',
			'since'     => '6.0.0',
			'version'   => '6.0.0',
		);

		$this->schema['release_date_of_society'] = array(
			'type'      => 'string',
			'meta_type' => 'multiple',
			'bydefault' => '',
			'since'     => '6.0.0',
			'version'   => '6.0.0',
		);

		$this->schema['professional_qualification'] = array(
			'type'      => 'string',
			'meta_type' => 'multiple',
			'bydefault' => '',
			'since'     => '6.0.0',
			'version'   => '6.0.0',
		);

		$this->schema['sexe'] = array(
			'type'      => 'string',
			'meta_type' => 'multiple',
			'bydefault' => '',
			'since'     => '6.0.0',
			'version'   => '6.0.0',
		);

		$this->schema['nationality'] = array(
			'type'      => 'string',
			'meta_type' => 'multiple',
			'bydefault' => '',
			'since'     => '6.0.0',
			'version'   => '6.0.0',
		);

		$this->schema['insurance_compagny'] = array(
			'type'      => 'string',
			'meta_type' => 'multiple',
			'bydefault' => '',
			'since'     => '6.0.0',
			'version'   => '6.0.0',
		);

		$this->schema['dashboard_compiled_data'] = array(
			'type'      => 'array',
			'meta_type' => 'multiple',
			'since'     => '6.0.0',
			'version'   => '6.0.0',
			'child'     => array(),
		);
		$this->schema['dashboard_compiled_data']['child']['last_evaluation_date'] = array(
			'since'     => '6.0.0',
			'version'   => '6.0.0',
			'type'      => 'string',
			'meta_type' => 'multiple',
			'bydefault' => 'Pas d\'évaluation',
		);

		$this->schema['dashboard_compiled_data']['child']['list_workunit_id'] = array(
			'since'      => '6.0.0',
			'version'    => '6.0.0',
			'type'       => 'array',
			'array_type' => 'integer',
			'meta_type'  => 'multiple',
		);

		$this->schema['dashboard_compiled_data']['child']['list_evaluation_id'] = array(
			'since'      => '6.0.0',
			'version'    => '6.0.0',
			'type'       => 'array',
			'array_type' => 'integer',
			'meta_type'  => 'multiple',
		);

		$this->schema['dashboard_compiled_data']['child']['list_accident_id'] = array(
			'since'      => '6.0.0',
			'version'    => '6.0.0',
			'type'       => 'array',
			'array_type' => 'integer',
			'meta_type'  => 'multiple',
		);

		$this->schema['dashboard_compiled_data']['child']['list_stop_day_id'] = array(
			'since'      => '6.0.0',
			'version'    => '6.0.0',
			'type'       => 'array',
			'array_type' => 'integer',
			'meta_type'  => 'multiple',
		);

		$this->schema['dashboard_compiled_data']['child']['list_chemical_product_id'] = array(
			'since'      => '6.0.0',
			'version'    => '6.0.0',
			'type'       => 'array',
			'array_type' => 'integer',
			'meta_type'  => 'multiple',
		);

		$this->schema['dashboard_compiled_data']['child']['list_epi_id'] = array(
			'since'      => '6.0.0',
			'version'    => '6.0.0',
			'type'       => 'array',
			'array_type' => 'integer',
			'meta_type'  => 'multiple',
		);

		$this->schema['prevention_parent'] = array(
			'type'      => 'integer',
			'meta_type' => 'multiple',
			'bydefault' => '0',
			'since'     => '7.3.0',
			'version'   => '7.3.0',
		);

		parent::__construct( $data, $req_method );
	}
}
