<?php if ( !defined( 'ABSPATH' ) ) exit;
/**
 * Fichier du controlleur pour la gestion des evaluateurs / Main controller file for evaluators management
 *
 * @author Evarisk development team <dev@evarisk.com>
 * @version 6.0
 */

/**
 * Classe du controlleur principal pour la gestion des evaluateurs / Main controller class for evaluators management
 *
 * @author Evarisk development team <dev@evarisk.com>
 * @version 6.0
 */

if ( !class_exists( 'wpdigi_evaluator_ctr_01' ) ) {
	class wpdigi_evaluator_ctr_01 extends user_ctr_01 {
		protected $model_name 	= 'wpdigi_user_mdl_01';
		protected $meta_key		= '_wpeo_user_info';

		protected $base 	= 'digirisk/evaluator';
		protected $version 	= '0.1';

		public $limit_evaluator = 5;

		public function __construct() {
			parent::__construct();

			/**	Ajoute les onglets pour les unités de travail / Add tabs for workunit	*/
			add_filter( 'wpdigi_workunit_sheet_tab', array( $this, 'filter_add_sheet_tab_to_element' ), 6, 2 );
			/**	Ajoute le contenu pour les onglets des unités de travail / Add the content for workunit tabs	*/
			add_filter( 'wpdigi_workunit_sheet_content', array( $this, 'filter_display_evaluator_in_element' ), 10, 3 );
			/**	Ajoute les onglets pour les groupements / Add tabs for workunit	*/
			add_filter( 'wpdigi_group_sheet_tab', array( $this, 'filter_add_sheet_tab_to_element' ), 6, 2 );
			/**	Ajoute le contenu pour les onglets des groupements / Add the content for groupement tabs	*/
			add_filter( 'wpdigi_group_sheet_content', array( $this, 'filter_display_evaluator_in_element' ), 10, 3 );

			/** Pour la recherche */
			add_filter( 'wpdigi_search_evaluator_affected', array( $this, 'callback_wpdigi_search_evaluator_affected' ), 10, 3 );
			add_filter( 'wpdigi_search_evaluator_to_assign', array( $this, 'callback_wpdigi_search_evaluator_to_assign' ), 10, 4 );
		}

		/**
		 * Filtrage de la définition des onglets dans les fiches d'un élément / Hook filter allowing to extend tabs into an element sheet
		 *
		 * @param array $tab_list La liste actuelle des onglets à afficher dans la fiche de l'élément / The current tab list to display into element sheet
		 *
		 * @return array Le tableau des onglets a afficher dans la fiche de l'élément avec les onglets spécifiques ajoutés / The tab array to display into element sheet with specific tabs added
		 */
		function filter_add_sheet_tab_to_element( $tab_list, $current_element ) {
			/** Définition de l'onglet permettant l'affichage des utilisateurs pour le type d'élément actuel / Define the tab allowing to display evaluators' tab for current element type	*/
			$tab_list = array_merge( $tab_list, array(
				'evaluator' => array(
					'text'	=> __( 'Evaluators', 'wpdigi-i18n' ),
					'count' => !empty( $current_element->option[ 'user_info' ][ 'affected_id' ][ 'evaluator' ] ) ? count( $current_element->option[ 'user_info' ][ 'affected_id' ][ 'evaluator' ] ) : 0,
				),
			)	);

			return $tab_list;
		}

		/**
		 * Filtrage de l'affichage des utilisateurs dans la fiche d'un élément (unité de travail/groupement/etc) / Filter evaluators' display into a element sheet
		 *
		 * @param string $output Le contenu actuel a afficher, contenu que l'on va agrémenter / The current content to update before return and display
		 * @param JSon_Object $element L'élément sur le quel on se trouve et pour lequel on veut afficher les utilisateurs / Current element we are on and we want to display evaluators' for
		 * @param string $tab_to_display L'onglet sur lequel on se trouve actuellement défini par le filtre principal ( wpdigi-workunit-default-tab ) puis par l'ajax / Current tab we are on defined par main filter ( wpdigi-workunit-default-tab ) and then by ajax
		 *
		 * @return string Le contenu a afficher pour l'onglet et l'élément actuel / The content to display for current tab and element we are one
		 */
		function filter_display_evaluator_in_element( $output, $element, $tab_to_display ) {
			if ( 'evaluator' == $tab_to_display ) {
				ob_start();
				$this->render( $element );
				$output .= ob_get_contents();
				ob_end_clean();
			}

			return $output;
		}

		public function render( $element ) {
			$list_affected_evaluator = $this->get_list_affected_evaluator( $element );

			$current_page = !empty( $_GET['current_page'] ) ? (int)$_GET['current_page'] : 1;
			$args_where_evaluator = array(
				'offset' => ( $current_page - 1 ) * $this->limit_evaluator,
				'exclude' => array( 1 ),
				'number' => $this->limit_evaluator,
				'meta_query' => array(
					'relation' => 'OR',
				),
			);

			$list_evaluator_to_assign = $this->index( $args_where_evaluator );

			// Pour compter le nombre d'utilisateur en enlevant la limit et l'offset
			unset( $args_where_evaluator['offset'] );
			unset( $args_where_evaluator['number'] );
			$args_where_evaluator['fields'] = array( 'ID' );
			$count_evaluator = count( $this->index( $args_where_evaluator ) );

			$number_page = ceil( $count_evaluator / $this->limit_evaluator );

			require_once( wpdigi_utils::get_template_part( WPDIGI_EVALUATOR_DIR, WPDIGI_EVALUATOR_TEMPLATES_MAIN_DIR, 'backend', 'main' ) );
		}

		/**
		 * Récupère la liste des utilisateurs affectés avec ses informations d'affectations à cette unité de travail
		 * Get the list of affected evaluators with assignement information for this workunit
		 *
		 * @param int $id The workunit ID
		 * @return JSON list evaluators affected
		 */
		public function get_list_affected_evaluator( $workunit ) {
			if ( $workunit->id === 0 || empty( $workunit->option['user_info'] ) || empty( $workunit->option['user_info']['affected_id'] ) )
				return false;

			$list_evaluator = array();
			if ( !empty( $workunit->option['user_info']['affected_id']['evaluator'] ) ) {
				foreach ( $workunit->option['user_info']['affected_id']['evaluator'] as $evaluator_id => $array_value ) {
					if ( !empty( $array_value ) ) {
						foreach ( $array_value as $index => $sub_array_value ) {
							if ( !empty( $sub_array_value['status'] ) && $sub_array_value['status'] == 'valid' ) {
								$list_evaluator[ $evaluator_id ][ $index ][ 'user_info' ] = $this->show( $evaluator_id );
								$list_evaluator[ $evaluator_id ][ $index ][ 'affectation_info' ] = $sub_array_value;
								$list_evaluator[ $evaluator_id ][ $index ][ 'affectation_info' ][ 'id' ] = $index;
							}
						}
					}
				}
			}

			$list_evaluator_affected = array();

			foreach ( $list_evaluator as $evaluator_id => $array_evaluator ) {
				if ( !empty( $array_evaluator ) ) {
					foreach( $array_evaluator as $index => $evaluator ) {
						$list_evaluator_affected[$evaluator['affectation_info']['start']['date']][] = $evaluator;
					}
				}
			}

			sort( $list_evaluator_affected );

			return $list_evaluator_affected;
		}

		static public function display_evaluator_affected_in_workunit( $workunit_id, $list_id ) {
			global $wpdigi_evaluator_ctr;
			global $wpdigi_workunit_ctr;

			$workunit = $wpdigi_workunit_ctr->show( $workunit_id );

			if ( empty( $workunit ) )
				wp_send_json_error();

			$list_evaluator = array();
			if ( !empty( $workunit->option['user_info']['affected_id']['evaluator'] ) ) {
				foreach ( $workunit->option['user_info']['affected_id']['evaluator'] as $evaluator_id => $array_value ) {
					if ( !empty( $array_value ) && in_array( $evaluator_id, $list_id ) ) {
						foreach ( $array_value as $index => $sub_array_value ) {
							if ( !empty( $sub_array_value['status'] ) && $sub_array_value['status'] == 'valid' ) {
								$list_evaluator[ $evaluator_id ][ $index ][ 'user_info' ] = $wpdigi_evaluator_ctr->show( $evaluator_id );
								$list_evaluator[ $evaluator_id ][ $index ][ 'affectation_info' ] = $sub_array_value;
								$list_evaluator[ $evaluator_id ][ $index ][ 'affectation_info' ][ 'id' ] = $index;
							}
						}
					}
				}
			}

			$list_affected_evaluator = array();

			foreach ( $list_evaluator as $evaluator_id => $array_evaluator ) {
				if ( !empty( $array_evaluator ) ) {
					foreach( $array_evaluator as $index => $evaluator ) {
						$list_affected_evaluator[$evaluator['affectation_info']['start']['date']][$index] = $evaluator;
					}
				}
			}

			arsort( $list_affected_evaluator );

			ob_start();
			require_once( wpdigi_utils::get_template_part( WPDIGI_EVALUATOR_DIR, WPDIGI_EVALUATOR_TEMPLATES_MAIN_DIR, 'backend', 'list-affected-user' ) );
		 	wp_die( wp_json_encode( array( 'template' => ob_get_clean() ) ) );
		}

		static public function display_evaluator_to_assign( $workunit_id, $list_id, $search ) {
			global $wpdigi_user_ctr;
			global $wpdigi_workunit_ctr;

			$workunit = $wpdigi_workunit_ctr->show( $workunit_id );

			if ( empty( $workunit ) )
				wp_send_json_error();


			if ( !empty( $search ) ) {

				$list_evaluator_to_assign = array();

				if ( !empty( $list_id ) ) {
					foreach ( $list_id as $user_id ) {
						if ( $user_id != 1 )
							$list_evaluator_to_assign[] = $wpdigi_user_ctr->show( $user_id );
					}
				}
			}
			else {
				$current_page = 1;
				$args_where_evaluator = array(
					'offset' => 0,
					'exclude' => array( 1 ),
					'number' => $wpdigi_user_ctr->limit_user,
					'meta_query' => array(
						'relation' => 'OR',
					),
				);

				$list_evaluator_to_assign = $wpdigi_user_ctr->index( $args_where_evaluator );

				// Pour compter le nombre d'utilisateur en enlevant la limit et l'offset
				unset( $args_where_evaluator['offset'] );
				unset( $args_where_evaluator['number'] );
				$args_where_evaluator['fields'] = array( 'ID' );
				$count_evaluator = count( $wpdigi_user_ctr->index( $args_where_evaluator ) );

				$number_page = ceil( $count_evaluator / $wpdigi_user_ctr->limit_user );
			}

			ob_start();
			require_once( wpdigi_utils::get_template_part( WPDIGI_EVALUATOR_DIR, WPDIGI_EVALUATOR_TEMPLATES_MAIN_DIR, 'backend', 'list-user-to-assign' ) );
			wp_die( wp_json_encode( array( 'template' => ob_get_clean() ) ) );
		}

		/**
		 * Calcul de la durée d'affectation d'un utilisateur selon les dates d'affectation et de désaffectation / User assignment duration calculation depending on assignment and decommissioning dates
		 *
		 * @param array $user_affectation_info Les informations d'affectation de l'utilisateur / User assignment informations
		 *
		 * @return string La durée d'affectation en minutes / Assigment duration in minutes
		 */
		public function get_duration( $user_affectation_info ) {
			if ( empty( $user_affectation_info[ 'start' ][ 'date' ] ) || empty( $user_affectation_info[ 'end' ][ 'date' ] ) )
				return 0;

			$start_date = new DateTime( $user_affectation_info[ 'start' ][ 'date' ] );
			$end_date = new DateTime( $user_affectation_info[ 'end' ][ 'date' ] );
			$interval = $start_date->diff( $end_date );

			$minutes = $interval->format( '%h' ) * 60;
			$minutes += $interval->format( '%i' );

			return $minutes;
		}

		public function callback_wpdigi_search_evaluator_affected( $string, $workunit_id, $list_id ) {
			global $wpdigi_evaluator_ctr;
			global $wpdigi_workunit_ctr;

			$workunit = $wpdigi_workunit_ctr->show( $workunit_id );

			if ( empty( $workunit ) )
				wp_send_json_error();

			$list_evaluator = array();
			if ( !empty( $workunit->option['user_info']['affected_id']['evaluator'] ) ) {
				foreach ( $workunit->option['user_info']['affected_id']['evaluator'] as $evaluator_id => $array_value ) {
					if ( !empty( $array_value ) && in_array( $evaluator_id, $list_id ) ) {
						foreach ( $array_value as $index => $sub_array_value ) {
							if ( !empty( $sub_array_value['status'] ) && $sub_array_value['status'] == 'valid' ) {
								$list_evaluator[ $evaluator_id ][ $index ][ 'user_info' ] = $wpdigi_evaluator_ctr->show( $evaluator_id );
								$list_evaluator[ $evaluator_id ][ $index ][ 'affectation_info' ] = $sub_array_value;
								$list_evaluator[ $evaluator_id ][ $index ][ 'affectation_info' ][ 'id' ] = $index;
							}
						}
					}
				}
			}

			$list_affected_evaluator = array();

			foreach ( $list_evaluator as $evaluator_id => $array_evaluator ) {
				if ( !empty( $array_evaluator ) ) {
					foreach( $array_evaluator as $index => $evaluator ) {
						$list_affected_evaluator[$evaluator['affectation_info']['start']['date']][$index] = $evaluator;
					}
				}
			}

			arsort( $list_affected_evaluator );

			ob_start();
			require_once( wpdigi_utils::get_template_part( WPDIGI_EVALUATOR_DIR, WPDIGI_EVALUATOR_TEMPLATES_MAIN_DIR, 'backend', 'list-affected-user' ) );
			$string .= ob_get_clean();
			return $string;
		}

		public function callback_wpdigi_search_evaluator_to_assign( $string, $workunit_id, $list_id, $term ) {
			global $wpdigi_user_ctr;
			global $wpdigi_workunit_ctr;

			$workunit = $wpdigi_workunit_ctr->show( $workunit_id );

			if ( empty( $workunit ) )
				wp_send_json_error();

			if ( !empty( $term ) ) {
				$list_evaluator_to_assign = array();

				if ( !empty( $list_id ) ) {
					foreach ( $list_id as $user_id ) {
						if ( $user_id != 1 )
							$list_evaluator_to_assign[] = $wpdigi_user_ctr->show( $user_id );
					}
				}
			}
			else {
				$current_page = 1;
				$args_where_user = array(
					'offset' => 0,
					'number' => $wpdigi_user_ctr->limit_user,
					'exclude' => array( 1 ),
					'meta_query' => array(
						'relation' => 'OR',
					),
				);

				$list_evaluator_to_assign = $wpdigi_user_ctr->index( $args_where_user );

				// Pour compter le nombre d'utilisateur en enlevant la limit et l'offset
				unset( $args_where_user['offset'] );
				unset( $args_where_user['number'] );
				$args_where_user['fields'] = array( 'ID' );
				$count_user = count( $wpdigi_user_ctr->index( $args_where_user ) );
				$number_page = ceil( $count_user / $wpdigi_user_ctr->limit_user );
			}

			ob_start();
			require_once( wpdigi_utils::get_template_part( WPDIGI_EVALUATOR_DIR, WPDIGI_EVALUATOR_TEMPLATES_MAIN_DIR, 'backend', 'list-affected-user' ) );
			$string .= ob_get_clean();
			return $string;
		}

	}

	global $wpdigi_evaluator_ctr;
	$wpdigi_evaluator_ctr = new wpdigi_evaluator_ctr_01();
}
