<?php
/**
 * Classe gérant les tiers
 *
 * @author Evarisk <dev@evarisk.com>
 * @since 6.1.3
 * @version 7.0.0
 * @copyright 2015-2018 Evarisk
 * @package DigiRisk
 */

namespace digi;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Classe gérant les tiers
 */
class Third_Class extends \eoxia\Post_Class {

	/**
	 * Le nom du modèle
	 *
	 * @var string
	 */
	protected $model_name = '\digi\third_model';

	/**
	 * Le post type
	 *
	 * @var string
	 */
	protected $type = 'third-display';

	/**
	 * La clé principale du modèle
	 *
	 * @var string
	 */
	protected $meta_key = 'third_display';

	/**
	 * La route pour accéder à l'objet dans la rest API
	 *
	 * @var string
	 */
	protected $base = 'third';

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
	public $element_prefix = 'T';

	/**
	 * Créer un tier
	 *
	 * @param array $data Les données du tier.
	 *
	 * @return object L'objet tier
	 *
	 * @todo: security, check data in $data.
	 */
	public function save_data( $data ) {
		return $this->create( $data );
	}
}

Third_Class::g();
