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
class risk_evaluation_comment_model extends comment_model {
	public function __construct( $object ) {
		$this->model = array_merge( $this->model, array(
			'export'	=> array(
				'type'			=> 'boolean',
				'bydefault'	=> true,
				'meta_type'	=> 'multiple',
				'description'	=> 'Permet de définir si on souhaite exporter le commentaire dans le DUER ou juste l\'afficher dans l\'interface',
			),
		) );

		parent::__construct( $object );
	}

}
