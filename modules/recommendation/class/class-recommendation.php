<?php
/**
 * Gestion des signalisations
 *
 * @author    Evarisk <dev@evarisk.com>
 * @copyright (c) 2006-2018 Evarisk <dev@evarisk.com>.
 *
 * @license   AGPLv3 <https://spdx.org/licenses/AGPL-3.0-only.html>
 *
 * @package   DigiRisk\Classes
 *
 * @since     6.1.5
 * @version   7.0.0
 */

namespace digi;

defined( 'ABSPATH' ) || exit;

/**
 * Recommendation class.
 */
class Recommendation extends \eoxia\Post_Class {

	/**
	 * Le modèle utilisé par cet objet.
	 *
	 * @since 6.1.5
	 * @var string
	 */
	protected $model_name = '\digi\Recommendation_Model';

	/**
	 * Le slug du CPT.
	 *
	 * @since 6.1.5
	 * @var string
	 */
	protected $type = 'digi-recommendation';

	/**
	 * Le nom du CPT.
	 *
	 * @since 6.1.5
	 * @var string
	 */
	protected $post_type_name = 'Recommandations';

	/**
	 * La clée principale pour les métadonnées.
	 *
	 * @since 6.1.5
	 * @var string
	 */
	protected $meta_key = '_wpdigi_recommendation';

	/**
	 * La route pour accéder à l'objet dans la rest API
	 *
	 * @since 6.1.5
	 * @var string
	 */
	protected $base = 'recommendation';

	/**
	 * La version de l'objet
	 *
	 * @since 6.1.5
	 * @var string
	 */
	protected $version = '0.1';

	/**
	 * Le préfixe de l'objet dans DigiRisk
	 *
	 * @since 6.1.5
	 * @var string
	 */
	public $element_prefix = 'PA';

	/**
	 * Charges la liste des préconisations. Et appelle le template pour les afficher.
	 * Récupères le schéma d'une préconisations pour l'entrée d'ajout d'une préconisation dans le tableau.
	 *
	 * @since   6.1.5
	 * @version 6.5.0
	 *
	 * @param  integer $society_id L'ID de la société.
	 * @return void
	 */
	public function display( $society_id ) {
		$recommendation_schema = $this->get( array( 'schema' => true ), true );
		$recommendations       = $this->get( array( 'post_parent' =>  $society_id) );

		$update_recommendations = get_option('update_recommendations', 0);

		if ( \eoxia\Config_Util::$init['digirisk']->version == '7.7.2' && $update_recommendations <= 2) {
			$terms = get_terms( array(
				'taxonomy' => 'digi-recommendation-category',
				'fields' => 'ids',
				'hide_empty' => false
			) );

			foreach( $terms as $term_id ) {
				wp_delete_term( $term_id, 'digi-recommendation-category' );
			}

			Recommendation_Default_Data_Class::g()->create();
			update_option('update_recommendations',3);
		}

		\eoxia\View_Util::exec( 'digirisk', 'recommendation', 'list', array(
			'society_id'            => $society_id,
			'recommendations'       => $recommendations,
			'recommendation_schema' => $recommendation_schema,
		) );
	}
}

Recommendation::g();
