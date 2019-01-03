<?php
/**
 * Classe gérant les listing des risques.
 *
 * @author    Evarisk <dev@evarisk.com>
 * @copyright (c) 2006 2018 Evarisk <dev@evarisk.com>.
 *
 * @license   AGPLv3 <https://spdx.org/licenses/AGPL-3.0-or-later.html>
 *
 * @package   DigiRisk\Classes
 *
 * @since     6.5.0
 */

namespace digi;

defined( 'ABSPATH' ) || exit;

/**
 * Lsting Risk Filter class.
 */
class Listing_Risk_Corrective_Task_Class extends Document_Class {

	/**
	 * Le nom du modèle
	 *
	 * @var string
	 */

	protected $model_name = '\digi\Listing_Risk_Corrective_Task_Model';
	/**
	 * Le post type
	 *
	 * @var string
	 */

	protected $type = 'listing_risk_action';

	/**
	 * Le type du document
	 *
	 * @var string
	 */
	public $attached_taxonomy_type = 'attachment_category';

	/**
	 * La clé principale du modèle
	 *
	 * @var string
	 */
	protected $meta_key = '_wpdigi_document';

	/**
	 * La route pour accéder à l'objet dans la rest API
	 *
	 * @var string
	 */
	protected $base = 'listing-risk-action';

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
	public $element_prefix = 'LRA';

	/**
	 * Le nom pour le resgister post type
	 *
	 * @var string
	 */
	protected $post_type_name = 'Listing des risques';

	/**
	 * Le nom de l'ODT sans l'extension; exemple: document_unique
	 *
	 * @var string
	 */
	protected $odt_name = 'liste_des_risques_actions';

	/**
	 * Affichage principale
	 *
	 * @since 7.0.0
	 *
	 * @param integer $parent_id [description]
	 */
	public function display( $parent_id, $types, $can_add = true ) {
		$documents = array();

		if ( ! empty( $types ) ) {
			foreach ( $types as $type ) {
				$documents = wp_parse_args( $documents, $type::g()->get( array(
					'post_parent' => $parent_id,
					'post_status' => array( 'publish', 'inherit' ),
				) ) );
			}
		}

		\eoxia\View_Util::exec( 'digirisk', 'listing-risk', 'main', array(
			'element_id' => $parent_id,
			'documents'  => $documents,
			'type'       => 'corrective-task',
		) );
	}
}

new Listing_Risk_Corrective_Task_Class();
