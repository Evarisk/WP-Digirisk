<?php
/**
 * La classe gérant les accidents "stopping days"
 *
 * @author Evarisk <dev@evarisk.com>
 * @since 6.4.0
 * @version 7.0.0
 * @copyright 2015-2018 Evarisk
 * @package DigiRisk
 */

namespace digi;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * La classe gérant les accidents "stopping days"
 */
class Accident_Travail_Stopping_Day_Class extends \eoxia\Post_Class {

	/**
	 * Le nom du modèle
	 *
	 * @var string
	 */
	protected $model_name = '\digi\Accident_Travail_Stopping_Day_Model';

	/**
	 * Le post type
	 *
	 * @var string
	 */
	protected $type = 'digi-accident-day';

	/**
	 * La route pour accéder à l'objet dans la rest API
	 *
	 * @var string
	 */
	protected $base = 'accident-day';

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
	protected $meta_key = '_wpdigi_accident_day';

	/**
	 * Le préfixe de l'objet dans DigiRisk
	 *
	 * @var string
	 */
	public $element_prefix = 'AD';

	/**
	 * Le nom pour le resgister post type
	 *
	 * @var string
	 */
	protected $post_type_name = 'Accidents Stopping Day';

	/**
	 * Enregistres les nombres de jour d'arrêt.
	 *
	 * @since 6.4.0
	 * @version 6.4.4
	 *
	 * @param  array $data Les données contenant le nombre de jour d'arrêt.
	 * @return void
	 */
	public function save_stopping_day( $data ) {
		if ( ! empty( $data ) ) {
			foreach ( $data as $stopping_day_data ) {
				if ( ! empty( $stopping_day_data['content'] ) && strlen( 0 < $stopping_day_data['content'] ) ) {
					$stopping_day_data['parent_id'] = (int) $stopping_day_data['parent_id'];
					$stopping_day_data['id']        = ! empty( $stopping_day_data['id'] ) ? (int) $stopping_day_data['id'] : 0;
					$stopping_day                   = $this->update( $stopping_day_data );

					$associate_file_args = array(
						'id'         => (int) $stopping_day->data['id'],
						'field_name' => 'document',
						//'file_id'    => $_POST['document'], // WPCS: CSRF ok.
						'model_name' => '\digi\Accident_Travail_Stopping_Day_Class',
					);

					if ( ! empty( $_POST['document'] ) ) { // WPCS: CSRF ok.
						\eoxia\WPEO_Upload_Class::g()->associate_file( $associate_file_args );
					}
				}
			}
		}
	}
}

Accident_Travail_Stopping_Day_Class::g();
