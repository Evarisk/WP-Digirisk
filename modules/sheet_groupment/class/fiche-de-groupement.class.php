<?php
/**
 * Gères la génération de la fiche de groupement
 *
 * @package Evarisk\Plugin
 *
 * @since 0.1
 * @version 6.2.6.0
 */

namespace digi;

if ( ! defined( 'ABSPATH' ) ) {	exit; }

/**
 * Gères la génération de la fiche de groupement
 */
class Fiche_De_Groupement_Class extends Post_Class {

	/**
	 * Le nom du modèle
	 *
	 * @var string
	 */
	protected $model_name   				= '\digi\Fiche_De_Groupement_Model';

	/**
	 * Le post type
	 *
	 * @var string
	 */
	protected $post_type    				= 'fiche_de_groupement';

	/**
	 * Le type du document
	 *
	 * @var string
	 */
	public $attached_taxonomy_type  = 'attachment_category';

	/**
	 * La clé principale du modèle
	 *
	 * @var string
	 */
	protected $meta_key    					= '_wpdigi_document';

	/**
	 * La route pour accéder à l'objet dans la rest API
	 *
	 * @var string
	 */
	protected $base 								= 'digirisk/fiche-de-groupement';

	/**
	 * La version de l'objet
	 *
	 * @var string
	 */
	protected $version 							= '0.1';

	/**
	 * Le préfixe de l'objet dans DigiRisk
	 *
	 * @var string
	 */
	public $element_prefix 					= 'FGP';

	/**
	 * La fonction appelée automatiquement avant la création de l'objet dans la base de donnée
	 *
	 * @var array
	 */
	protected $before_put_function = array( '\digi\construct_identifier' );

	/**
	 * La fonction appelée automatiquement après la récupération de l'objet dans la base de donnée
	 *
	 * @var array
	 */
	protected $after_get_function = array( '\digi\get_identifier' );

	/**
	 * Le nom pour le resgister post type
	 *
	 * @var string
	 */
	protected $post_type_name = 'Fiche de groupement';

	/**
	 * Le constructeur obligatoire pour hériter de la classe Document_Class
	 * Appelle le constructeur parent pour initialiser le post type
	 *
	 * @return void
	 *
	 * @since 0.1
	 * @version 6.2.5.0
	 */
	protected function construct() {
		parent::construct();
		add_filter( 'json_endpoints', array( $this, 'callback_register_route' ) );
	}

	/**
	 * Appelle le template main.view.php dans le dossier /view/
	 *
	 * @param  integer $element_id L'ID de l'élement.
	 * @return void
	 *
	 * @since 0.1
	 * @version 6.2.6.0
	 */
	public function display( $element_id ) {
		$element = $this->get( array(
			'schema' => true,
		) );

		$element = $element[0];

		View_Util::exec( 'sheet_groupment', 'main', array(
			'element' => $element,
			'element_id' => $element_id,
		) );
	}

	/**
	 * Appelle le template list.view.php dans le dossier /view/
	 *
	 * @param  int $element_id L'ID de l'élement.
	 * @return void
	 *
	 * @since 0.1
	 * @version 6.2.5.0
	 */
	public function display_document_list( $element_id ) {
		$list_document = $this->get( array( 'post_parent' => $element_id, 'post_status' => array( 'publish', 'inherit' ) ), array( 'category' ) );
		view_util::exec( 'sheet_groupment', 'list', array( 'list_document' => $list_document ) );
	}

	/**
	 * Cette méthode génère la fiche de groupement
	 *
	 * @param  int $society_id L'ID de la société.
	 *
	 * @return bool
	 *
	 * @since 0.1
	 * @version 6.2.5.0
	 */
	public function generate( $society_id ) {
		$society = group_class::g()->get( array( 'post__in' => array( $society_id ) ) );

		if ( empty( $society[0] ) ) {
			return false;
		}

		$society = $society[0];

		$society_infos = $this->get_infos( $society );

		$sheet_details = array(
			'reference'			=> $society->unique_identifier,
			'nom'						=> $society->title,
			'description'		=> $society->content,
			'adresse'				=> $society_infos['adresse'],
			'telephone'			=> ! empty( $society->contact['phone'] ) ? max( $society->contact['phone'] ) : '',
			'codePostal'		=> $society_infos['codePostal'],
			'ville'					=> $society_infos['ville'],
		);

		$sheet_details['photoDefault'] = $this->set_picture( $society );
		$sheet_details = wp_parse_args( $sheet_details, $this->set_users( $society ) );
		$sheet_details = wp_parse_args( $sheet_details, $this->set_evaluators( $society ) );
		$sheet_details = wp_parse_args( $sheet_details, $this->set_risks( $society ) );

		$document_creation_response = document_class::g()->create_document( $society, array( 'fiche_de_groupement' ), $sheet_details );
		if ( ! empty( $document_creation_response['id'] ) ) {
			$society->associated_document_id['document'][] = $document_creation_response['id'];
			$society = group_class::g()->update( $society );
		}

		return array( 'creation_response' => $document_creation_response, 'element' => $society, 'success' => true );
	}

	/**
	 * Récupères les informations comme l'adresse, le code postal, la ville et les renvoies dans un tableau.
	 *
	 * @param Group_Model $society L'objet groupement.
	 * @return array
	 *
	 * @since 6.2.1.2
	 * @version 6.2.1.2
	 */
	public function get_infos( $society ) {
		$infos = array( 'adresse' => '', 'codePostal' => '', 'ville' => '' );

		$address = Society_Class::g()->get_address( $society );
		$address = $address[0];

		$infos['adresse'] = $address->address . ' ' . $address->additional_address;
		$infos['codePostal'] = $address->postcode;
		$infos['ville'] = $address->town;

		return $infos;
	}

	/**
	 * Définie l'image du document
	 *
	 * @param Group_Model $society L'objet groupement.
	 *
	 * @return string|false|array
	 *
	 * @since 0.1
	 * @version 6.2.5.0
	 */
	public function set_picture( $society ) {
		$picture = __( 'No picture defined', 'digirisk' );

		if ( ! empty( $society->thumbnail_id ) ) {
			$picture_definition = wp_get_attachment_image_src( $society->thumbnail_id, 'medium' );
			$picture_path = str_replace( site_url( '/' ), ABSPATH, $picture_definition[0] );

			if ( is_file( $picture_path ) ) {
				$picture = array(
					'type'		=> 'picture',
					'value'		=> str_replace( site_url( '/' ), ABSPATH, $picture_definition[0] ),
					'option'	=> array(
						'size' => 9,
					),
				);
			}
		}

		return $picture;
	}

	/**
	 * Récupères les utilisateurs affectés et désaffectés de la société
	 *
	 * @param Group_Model $society L'objet groupement.
	 *
	 * @return array La liste des utilisateurs affectés et désaffectés à la société
	 *
	 * @since 0.1
	 * @version 6.2.5.0
	 */
	public function set_users( $society ) {
		$users = array(
			'utilisateursAffectes' => array( 'type' => 'segment', 'value' => array() ),
			'utilisateursDesaffectes' => array( 'type' => 'segment', 'value' => array() ),
		);

		if ( ! empty( $society->user_info['affected_id']['user'] ) ) {
			$user_affectation_for_export = user_digi_class::g()->build_list_for_document_export( $society->user_info['affected_id']['user'] );
			if ( null !== $user_affectation_for_export ) {
				$users['utilisateursAffectes'] = array(
					'type'	=> 'segment',
					'value'	=> $user_affectation_for_export['affected'],
				);
				$users['utilisateursDesaffectes'] = array(
					'type'	=> 'segment',
					'value'	=> $user_affectation_for_export['unaffected'],
				);
			}
		}

		return $users;
	}

	/**
	 * Récupères les évaluateurs affectés à la société
	 *
	 * @param Group_Model $society L'objet groupement.
	 *
	 * @return array La liste des évéluateurs affectés à la société
	 *
	 * @since 0.1
	 * @version 6.2.5.0
	 */
	public function set_evaluators( $society ) {
		$evaluators = array( 'utilisateursPresents' => array( 'type' => 'segment', 'value' => array() ) );
		$affected_evaluators = array();

		if ( ! empty( $society->user_info['affected_id']['evaluator'] ) ) {
			/**	Récupération de la liste des personnes présentes lors de l'évaluation / Get list of user who were present for evaluation	*/
			$list_affected_evaluator = evaluator_class::g()->get_list_affected_evaluator( $society );
			if ( ! empty( $list_affected_evaluator ) ) {
				foreach ( $list_affected_evaluator as $evaluator_id => $evaluator_affectation_info ) {
					foreach ( $evaluator_affectation_info as $evaluator_affectation_info ) {
						if ( 'valid' === $evaluator_affectation_info['affectation_info']['status'] ) {
							$affected_evaluators[] = array(
								'idUtilisateur'								=> evaluator_class::g()->element_prefix . $evaluator_affectation_info['user_info']->id,
								'nomUtilisateur'							=> $evaluator_affectation_info['user_info']->lastname,
								'prenomUtilisateur'						=> $evaluator_affectation_info['user_info']->firstname,
								'dateAffectationUtilisateur'	=> mysql2date( 'd/m/Y H:i', $evaluator_affectation_info['affectation_info']['start']['date'], true ),
								'dureeEntretien'							=> evaluator_class::g()->get_duration( $evaluator_affectation_info['affectation_info'] ),
							);
						}
					}
				}

				$evaluators['utilisateursPresents'] = array(
					'type'	=> 'segment',
					'value'	=> $affected_evaluators,
				);
			}
		}

		return $evaluators;
	}

	/**
	 * Récupères les risques dans la société
	 *
	 * @param Group_Model $society L'objet groupement.
	 *
	 * @return array Les risques dans la société
	 *
	 * @since 0.1
	 * @version 6.2.5.0
	 */
	public function set_risks( $society ) {
		$risks = Risk_Class::g()->get( array( 'post_parent' => $society->id ) );

		$risk_details = array(
			'risq80' => array( 'type' => 'segment', 'value' => array() ),
			'risq51' => array( 'type' => 'segment', 'value' => array() ),
			'risq48' => array( 'type' => 'segment', 'value' => array() ),
			'risq' => array( 'type' => 'segment', 'value' => array() ),
		);

		$risk_list_to_order = array();
		if ( ! empty( $risks ) ) {
			foreach ( $risks as $risk ) {
				$comment_list = '';
				if ( ! empty( $risk->comment ) ) :
					foreach ( $risk->comment as $comment ) :
						$comment_list .= mysql2date( 'd/m/y H:i', $comment->date ) . ' : ' . $comment->content . "
			";
					endforeach;
				endif;

				$risk_list_to_order[ $risk->evaluation->scale ][] = array(
					'nomDanger'					=> $risk->danger->name,
					'identifiantRisque'	=> $risk->unique_identifier . '-' . $risk->evaluation->unique_identifier,
					'quotationRisque'		=> $risk->evaluation->risk_level['equivalence'],
					'commentaireRisque'	=> $comment_list,
				);
			}
		}
		krsort( $risk_list_to_order );

		if ( ! empty( $risk_list_to_order ) ) {
			$result_treshold = Scale_Util::get_scale( 'score' );
			foreach ( $risk_list_to_order as $risk_level => $risk_for_export ) {
				$final_level = ! empty( Evaluation_Method_Class::g()->list_scale[ $risk_level ] ) ? Evaluation_Method_Class::g()->list_scale[ $risk_level ] : '';
				$risk_details[ 'risq' . $final_level ]['value'] = $risk_for_export;
			}
		}

		return $risk_details;
	}
}

Fiche_De_Groupement_Class::g();
