<?php if ( !defined( 'ABSPATH' ) ) exit;
/**
 * Fichier du controlleur pour la gestion des différentes évaluations pour un risque / Main controller file for managing each evaluation for a risk
 *
 * @author Evarisk development team <dev@evarisk.com>
 * @version 6.0
 */

/**
 * Classe du controlleur pour la gestion des différentes évaluations pour un risque / Main controller class for managing each evaluation for a risk
 *
 * @author Evarisk development team <dev@evarisk.com>
 * @version 6.0
 */
class risk_evaluation_comment_model extends comment_model {
	public function __construct( $object, $field_wanted = array() ) {



		parent::__construct( $object, $field_wanted );
	}

}
