<?php
/**
 * Classe gérant les types de travaux
 *
 * @author Evarisk <dev@evarisk.com>
 * @since 7.3.3
 * @version 7.3.3
 * @copyright 2019 Evarisk
 * @package DigiRisk
 */

namespace digi;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Classe gérant les unités de travail
 */
class Worktype_Class extends \eoxia\Post_Class {

	/**
	 * Le préfixe de l'objet dans DigiRisk
	 *
	 * @var string
	 */
	public $element_prefix = 'W';

	/**
	 * Le nom du modèle
	 *
	 * @var string
	 */
	protected $model_name = '\digi\Worktype_Model';

	/**
	 * Le post type
	 *
	 * @var string
	 */
	protected $type = 'digi-worktype';

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
	protected $base = 'worktype';

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
	protected $post_type_name = 'Types de travaux';

}

Worktype_Class::g();
