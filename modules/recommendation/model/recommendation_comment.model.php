<?php namespace digi;

if ( !defined( 'ABSPATH' ) ) exit;
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
class recommendation_comment_model extends comment_model {
	public function __construct( $object ) {
		parent::__construct( $object );
	}

}
