<?php
/**
 * Classe gérant les unités de travail.
 *
 * @author Evarisk <dev@evarisk.com>
 * @since 6.0.0
 * @version 7.0.0
 * @copyright 2015-2018 Evarisk
 * @package DigiRisk
 */

namespace digi;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Classe gérant les unités de travail
 */
class Workunit_Class extends \eoxia\Post_Class {

	/**
	 * Le préfixe de l'objet dans DigiRisk
	 *
	 * @var string
	 */
	public $element_prefix = 'UT';

	/**
	 * Le nom du modèle
	 *
	 * @var string
	 */
	protected $model_name = '\digi\workunit_model';

	/**
	 * Le post type
	 *
	 * @var string
	 */
	protected $type = 'digi-workunit';

	/**
	 * La clé principale du modèle
	 *
	 * @var string
	 */
	protected $meta_key = '_wpdigi_society';

	/**
	 * La route pour accéder à l'objet dans la rest API
	 *
	 * @var string
	 */
	protected $base = 'workunit';

	/**
	 * La version de l'objet
	 *
	 * @var string
	 */
	protected $version = '0.1';

	/**
	 * Le nom pour le resgister post type
	 *
	 * @var string
	 */
	protected $post_type_name = 'Unité de travail';

}

Workunit_Class::g();
