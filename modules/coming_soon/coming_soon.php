<?php if ( !defined( 'ABSPATH' ) ) exit;

/**	Ajoute les onglets pour les unités de travail / Add tabs for workunit	*/
add_filter( 'wpdigi_workunit_sheet_tab', 'add_workunit_sheet_coming_soon_tab', 10, 2);

/**
 * Accrochage au filtre de définition des onglets dans les fiches des unités de travail / Hook filter allowing to extend tabs into workunit sheet
 *
 * @param array $tab_list La liste actuelle des onglets à afficher dans la fiche d'unité de travail / The current tab list to display into wirkunit sheet
 *
 * @return array Le tableau des onglets a afficher dans la fiche d'unité de travail avec les onglets spécifiques ajoutés / The tab array to display into workunit sheet with specific tabs added
 */
function add_workunit_sheet_coming_soon_tab( $tab_list, $current_element ) {
	/** Définition de l'onglet permettant l'affichage des fiches d'unités de travail générées / Define the tab allowing to display tab for generated workunit sheet	*/
	$tab_list = array_merge( $tab_list, array(
		'product' => array(
				'text' 				=> __( 'Products', 'digirisk' ),
				'class'				=> 'wp-digi-list-item disabled',
		),
		'ppe' => array(
				'text' 				=> __( 'PPE', 'digirisk' ),
				'class'				=> 'wp-digi-list-item disabled',
		),
		'formation' => array(
				'text' 				=> __( 'Formation', 'digirisk' ),
				'class'				=> 'wp-digi-list-item disabled',
		),
		'accident' => array(
				'text' 				=> __( 'Accidents', 'digirisk' ),
				'class'				=> 'wp-digi-list-item disabled',
		),
// 		'recommendation' => array(
// 				'text' 				=> __( 'Recommendations', 'digirisk' ),
// 				'class'				=> 'wp-digi-list-item disabled',
// 		),
	) );

	return $tab_list;
}
