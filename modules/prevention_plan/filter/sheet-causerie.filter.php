<?php
/**
 * Classe gérant les filtres des fiches de groupement.
 *
 * @author    Evarisk <dev@evarisk.com>
 * @copyright (c) 2006-2018 Evarisk <dev@evarisk.com>.
 *
 * @license   AGPLv3 <https://spdx.org/licenses/AGPL-3.0-or-later.html>
 *
 * @package   DigiRisk\Classes
 *
 * @since     6.2.4
 */

namespace digi;

defined( 'ABSPATH' ) || exit;

/**
 * Sheet Groupement Filter class.
 */
class Sheet_Causerie_Filter extends Identifier_Filter {

	/**
	 * Ajoutes le filtres
	 *
	 * @since 6.2.4
	 */
	public function __construct() {
		parent::__construct();

		add_filter( 'eo_model_digi-sheet-causerie_before_post', array( $this, 'before_save_doc' ), 10, 2 );
		add_filter( 'digi_digi-sheet-causerie_document_data', array( $this, 'callback_digi_document_data' ), 9, 2 );
		add_filter( 'digi_sheet-causerie-inter_document_data', array( $this, 'callback_digi_document_data' ), 9, 2 );
	}

	/**
	 * Ajoutes le titre du document ainsi que le GUID et le chemin vers celui-ci.
	 *
	 * Cette méthode est appelée avant l'ajout du document en base de donnée.
	 *
	 * @since 7.0.0
	 *
	 * @param  array $data Les données du document.
	 * @param  array $args Les données de la requête.
	 *
	 * @return mixed
	 */
	public function before_save_doc( $data, $args ) {
		$upload_dir = wp_upload_dir();

		$data['title']  = current_time( 'Ymd' ) . '_';
		$data['title'] .= '_fiche_causerie_';
		$data['title'] .= $data['parent']->data['unique_identifier'];
		$data['title']  = str_replace( '-', '_', $data['title'] );

		$data['guid'] = $upload_dir['baseurl'] . '/digirisk/0/' . sanitize_title( $data['title'] ) . '.odt';
		$data['path'] = $upload_dir['basedir'] . '/digirisk/0/' . sanitize_title( $data['title'] ) . '.odt';
		$data['path'] = str_replace( '\\', '/', $data['path'] );

		$data['_wp_attached_file'] = '/digirisk/0/' . sanitize_title( $data['title'] ) . '.odt';

		return $data;
	}

	/**
	 * Ajoutes toutes les données nécessaire pour le registre des AT bénins.
	 *
	 * @since 7.0.0
	 *
	 * @param  array         $data    Les données pour le registre des AT bénins.
	 * @param  Society_Model $society Les données de la société.
	 *
	 * @return array                  Les données pour le registre des AT bénins modifié.
	 */
	public function callback_digi_document_data( $data, $args ) {
		$causerie = $args['parent'];

		if ( isset( $args['causerie'] ) ) {
			$causerie              = $args['causerie'];
			$causerie_intervention = $args['parent'];
		}

		$data = array(
			'cleCauserie'         => (string) $causerie->data['unique_key'],
			'cleFinalCauserie'    => __( 'N/A', 'digirisk' ),
			'titreCauserie'       => $causerie->data['title'],
			'categorieINRS'       => $causerie->data['risk_category']->data['name'],
			'descriptionCauserie' => $causerie->data['content'],
			'formateur'           => __( 'N/A', 'digirisk' ),
			'formateurSignature'  => __( 'N/A', 'digirisk' ),
			'dateDebutCauserie'   => __( 'N/A', 'digirisk' ),
			'dateClotureCauserie' => __( 'N/A', 'digirisk' ),
			'nombreCauserie'      => 0,
			'dateCreation'        => $causerie->data['date']['rendered']['date_human_readable'],
			'nombreFormateur'     => 0,
			'nombreUtilisateur'   => 0,
			'titreTache'          => '',
			'points'              => array(
				'type'  => 'segment',
				'value' => array(),
			),
		);

		$data = wp_parse_args( $data, $this->set_medias( $causerie ) );
		$data = wp_parse_args( $data, $this->set_users( $causerie ) );

		if ( isset( $args['causerie'] ) ) {
			$taskmanager_data = $this->check_if_this_causerie_have_task_enable( $causerie_intervention->data[ 'id' ] );
			$data['cleFinalCauserie']    = (string) $causerie_intervention->data['second_unique_key'];
			$data['formateur']           = $causerie_intervention->data['former']['rendered']->data['displayname'];
			$data['formateurSignature']  = $this->set_picture( $causerie_intervention->data['former']['signature_id'], 5 );
			$data['dateDebutCauserie']   = $causerie_intervention->data['date_start']['rendered']['date_human_readable'];
			$data['dateClotureCauserie'] = $causerie_intervention->data['date_end']['rendered']['date_human_readable'];
			$data['nombreCauserie']      = $causerie->data['number_time_realized'];
			$data['nombreFormateur']     = $causerie->data['number_formers'];
			$data['nombreUtilisateur']   = $causerie->data['number_participants'];
			$data['titreTache']          = $taskmanager_data[ 'title' ];
			$data['points']               = $taskmanager_data[ 'points' ];
			$data = wp_parse_args(  $this->set_users( $causerie_intervention ), $data );
		}

		return $data;
	}


	/**
	 * Remplis les données des médias.
	 *
	 * @since   6.6.0
	 * @version 6.6.0
	 *
	 * @param Causerie_Model $causerie Le modèle de la causerie.
	 *
	 * @return array {
	 *    @type integer nombreMedia       Le nombre de média
	 *    @type string  nomsMediaCauserie Le noms des médias.
	 *    @type array   mediasCauserie    Les images des médias.
	 * }
	 */
	public function set_medias( $causerie ) {
		$data = array(
			'nombreMedia'       => 0,
			'nomsMediaCauserie' => '',
			'mediasCauserie'    => array(
				'type'  => 'segment',
				'value' => array(),
			),
		);

		if ( ! empty( $causerie->data['associated_document_id']['image'] ) ) {
			foreach ( $causerie->data['associated_document_id']['image'] as $image_id ) {
				$data['mediasCauserie']['value'][] = array(
					'mediaCauserie' => $this->set_picture( $image_id ),
				);

				$data['nombreMedia']++;
				$data['nomsMediaCauserie'] .= get_the_title( $image_id ) . ', ';
			}
		} else {
			$data['mediasCauserie']['value'][] = array(
				'mediaCauserie' => '',
			);
		}

		if ( ! empty( $data['nomsMediaCauserie'] ) ) {
			$data['nomsMediaCauserie'] = substr( $data['nomsMediaCauserie'], 0, -2 );
		}

		return $data;
	}

	/**
	 * Remplis les données des médias.
	 *
	 * @since   6.6.0
	 * @version 6.6.0
	 *
	 * @param Causerie_Model $causerie Le modèle de la causerie.
	 *
	 * @return array {
	 *    @type integer nombreMedia       Le nombre de média
	 *    @type string  nomsMediaCauserie Le noms des médias.
	 *    @type array   mediasCauserie    Les images des médias.
	 * }
	 */
	public function set_users( $causerie ) {
		$data = array(
			'utilisateurs' => array(
				'type'  => 'segment',
				'value' => array(),
			),
		);

		if ( ! empty( $causerie->data['participants'] ) ) {
			foreach ( $causerie->data['participants'] as $participant ) {
				$participant['rendered'] = (array) $participant['rendered'];

				$data['utilisateurs']['value'][] = array(
					'nomUtilisateur'    => $participant['rendered']['data']['lastname'],
					'prenomUtilisateur' => $participant['rendered']['data']['firstname'],
					'dateSignature'     => \eoxia\Date_Util::g()->mysqldate2wordpress( $participant['signature_date'] ),
					'signature'         => $this->set_picture( $participant['signature_id'], 5 ),
				);
			}
		}

		return $data;
	}

	/**
	 * Définie l'image du document
	 *
	 * @since   6.6.0
	 * @version 6.6.0
	 *
	 * @param integer $id   L'ID du média.
	 * @param integer $size La taille en CM du media.
	 *
	 * @return string|false|array {
	 *         @type string type   Le type du noeud pour l'ODT.
	 *         @type string value  Le lien vers le media.
	 *         @type array  option {
	 *               @type integer size La taille en CM du media.
	 *         }
	 * }
	 */
	public function set_picture( $id, $size = 9 ) {
		$picture = __( 'No picture defined', 'digirisk' );

		if ( ! empty( $id ) ) {
			$picture_definition = wp_get_attachment_image_src( $id, 'medium' );
			$picture_path       = str_replace( site_url( '/' ), ABSPATH, $picture_definition[0] );

			if ( is_file( $picture_path ) ) {
				$picture = array(
					'type'   => 'picture',
					'value'  => str_replace( site_url( '/' ), ABSPATH, $picture_definition[0] ),
					'option' => array(
						'size' => $size,
					),
				);
			}
		}

		return $picture;
	}

	public function check_if_this_causerie_have_task_enable( $id ){
		$title                = '';
		$points_task          = array();
		$points_task['type']  = 'segment';
		$points_task['value'] = array();

		if( class_exists( 'task_manager\Task_Class' ) ){
			$task = \task_manager\Task_Class::g()->get( array( 'post_parent' => $id ), true );
			if( ! empty( $task ) ){
				$title = $task->data[ 'title' ];
				if( $task->data[ 'count_all_points' ] > 0 ){
					$points = \task_manager\Point_Class::g()->get( array( 'post_id' => $task->data[ 'id' ] ) );
					foreach( $points as $key => $point ){
						$points_task[ 'value' ][] = array( 'pointtext' => $point->data[ 'content' ] );
					}
				}
			}
		}

		return array( 'title' => $title, 'points' => $points_task );
	}
}

new Sheet_Causerie_Filter();
