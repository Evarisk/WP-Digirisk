<?php

namespace digi;
if ( !defined( 'ABSPATH' ) ) exit;
require_once('databaseTable.php');

{/*	Define the different path for the plugin	*/
DEFINE('EVA_HOME_URL', WP_PLUGIN_URL . '/evarisk/');
DEFINE('EVA_HOME_DIR', WP_PLUGIN_DIR . '/evarisk/');

$upload_dir = wp_upload_dir();
DEFINE('EVA_GENERATED_DOC_DIR', $upload_dir['basedir'] . '/evarisk/');
DEFINE('EVA_GENERATED_DOC_URL', $upload_dir['baseurl'] . '/evarisk/');

DEFINE('EVA_INC_PLUGIN_DIR', EVA_HOME_DIR . 'include/');
DEFINE('EVA_INC_PLUGIN_URL', EVA_HOME_URL . 'include/');

DEFINE('EVA_LIB_PLUGIN_DIR', EVA_INC_PLUGIN_DIR . 'lib/');
DEFINE('EVA_MODULES_PLUGIN_DIR', EVA_INC_PLUGIN_DIR . 'modules/');
DEFINE('EVA_METABOXES_PLUGIN_DIR', EVA_MODULES_PLUGIN_DIR . 'metaBoxes/');
DEFINE('EVA_TEMPLATES_PLUGIN_DIR', EVA_HOME_DIR . 'templates/');

DEFINE('EVA_IMG_PLUGIN_URL', EVA_HOME_URL . 'medias/images/');
DEFINE('EVA_IMG_ICONES_PLUGIN_URL', EVA_IMG_PLUGIN_URL . 'Icones/');
DEFINE('EVA_IMG_DIVERS_PLUGIN_URL', EVA_IMG_ICONES_PLUGIN_URL . 'Divers/');
DEFINE('EVA_IMG_PICTOS_PLUGIN_URL', EVA_IMG_PLUGIN_URL . 'Pictos/');
DEFINE('EVA_IMG_GOOGLEMAPS_PLUGIN_URL', EVA_IMG_PLUGIN_URL . 'GoogleMapIcons/');
DEFINE('EVA_LIB_PLUGIN_URL', EVA_INC_PLUGIN_URL . 'lib/');

DEFINE('EVA_UPLOADS_PLUGIN_DIR', EVA_GENERATED_DOC_DIR . 'uploads/');
DEFINE('EVA_UPLOADS_PLUGIN_URL', EVA_GENERATED_DOC_URL . 'uploads/');
DEFINE('EVA_PHOTO_UPLOADS_PLUGIN_URL', EVA_UPLOADS_PLUGIN_URL . 'photos/');
DEFINE('EVA_TEXTE_VEILLE_UPLOADS_PLUGIN_URL', EVA_UPLOADS_PLUGIN_URL . 'veilleReglementaire/');

DEFINE('EVA_RESULTATS_PLUGIN_URL', EVA_GENERATED_DOC_URL . 'results/');
DEFINE('EVA_RESULTATS_PLUGIN_DIR', EVA_GENERATED_DOC_DIR . 'results/');
DEFINE('EVA_MODELES_PLUGIN_DIR', EVA_UPLOADS_PLUGIN_DIR . 'modeles/');
DEFINE('EVA_MODELES_PLUGIN_URL', EVA_UPLOADS_PLUGIN_URL . 'modeles/');
DEFINE('EVA_NOTES_PLUGIN_DIR', EVA_RESULTATS_PLUGIN_DIR . 'notes/');
DEFINE('EVA_NOTES_PLUGIN_URL', EVA_RESULTATS_PLUGIN_URL . 'notes/');

/*	Do not delete even if old sufix has been added!!! Used to check if directory are well created on each plugin loading	*/
DEFINE('EVA_UPLOADS_PLUGIN_OLD_DIR', EVA_HOME_DIR . 'medias/uploads/');
DEFINE('EVA_RESULTATS_PLUGIN_OLD_DIR', EVA_HOME_DIR . 'medias/results/');
}

{/*	Define the risk level information	*/
DEFINE('EVA_RISQUE_SEUIL_1_NOM', __('Risque Faible', 'evarisk'));
DEFINE('EVA_RISQUE_SEUIL_2_NOM', __('Risque &agrave; planifier', 'evarisk'));
DEFINE('EVA_RISQUE_SEUIL_3_NOM', __('Risque &agrave; traiter', 'evarisk'));
DEFINE('EVA_RISQUE_SEUIL_4_NOM', __('Risque Inacceptable', 'evarisk'));

DEFINE('SEUIL_BAS_INACCEPTABLE', '80');
DEFINE('SEUIL_HAUT_INACCEPTABLE', '100');
DEFINE('SEUIL_BAS_ATRAITER', '51');
DEFINE('SEUIL_HAUT_ATRAITER', '79');
DEFINE('SEUIL_BAS_APLANIFIER', '48');
DEFINE('SEUIL_HAUT_APLANIFIER', '50');
DEFINE('SEUIL_BAS_FAIBLE', '0');
DEFINE('SEUIL_HAUT_FAIBLE', '47');

DEFINE('COULEUR_RISQUE_INACCEPTABLE', '#000000');
DEFINE('COULEUR_TEXTE_RISQUE_INACCEPTABLE', '#FFFFFF');
DEFINE('COULEUR_RISQUE_ATRAITER', '#FF0100');
DEFINE('COULEUR_TEXTE_RISQUE_ATRAITER', '#000000');
DEFINE('COULEUR_RISQUE_APLANIFIER', '#FFCD00');
DEFINE('COULEUR_TEXTE_RISQUE_APLANIFIER', '#000000');
DEFINE('COULEUR_RISQUE_FAIBLE', '#FFFFFF');
DEFINE('COULEUR_TEXTE_RISQUE_FAIBLE', '#000000');

$typeRisque = array();
$typeRisque['risq80'] = SEUIL_BAS_INACCEPTABLE;
$typeRisque['risq51'] = SEUIL_BAS_ATRAITER;
$typeRisque['risq48'] = SEUIL_BAS_APLANIFIER;
$typeRisque['risq'] = SEUIL_BAS_FAIBLE;

$typeRisquePA = array();
$typeRisquePA['risqPA80'] = SEUIL_BAS_INACCEPTABLE;
$typeRisquePA['risqPA51'] = SEUIL_BAS_ATRAITER;
$typeRisquePA['risqPA48'] = SEUIL_BAS_APLANIFIER;
$typeRisquePA['risqPA'] = SEUIL_BAS_FAIBLE;

$typeRisquePlanAction = array();
$typeRisquePlanAction['planDactionRisq80'] = SEUIL_BAS_INACCEPTABLE;
$typeRisquePlanAction['planDactionRisq51'] = SEUIL_BAS_ATRAITER;
$typeRisquePlanAction['planDactionRisq48'] = SEUIL_BAS_APLANIFIER;
$typeRisquePlanAction['planDactionRisq'] = SEUIL_BAS_FAIBLE;

$type_prevention = array();
$type_prevention['organisationnelles'] = __('Organisationnelles', 'evarisk');
$type_prevention['collectives'] = __('Collectives', 'evarisk');
$type_prevention['individuelles'] = __('Individuelles', 'evarisk');
DEFINE('DIGI_TYPE_PREVENTION', serialize($type_prevention));


}

DEFINE('DIGI_DEBUG_MODE', false);
DEFINE('DIGI_DEBUG_MODE_ALLOWED_IP', serialize( array('127.0.0.1') ));

DEFINE('DIGI_ALLOW_RISK_CATEGORY_CHANGE', false);

{/*	Define url	*/
DEFINE('DIGI_URL_SLUG_USER_GROUP', 'digirisk_users_group');
DEFINE('DIGI_URL_SLUG_MAIN_OPTION', 'digirisk_options');
DEFINE('DIGI_URL_SLUG_CONFIG', 'digirisk_configuration');
DEFINE('DIGI_URL_SLUG_USER_RIGHT', 'digirisk_user_right');
}

/**
 * Others variables
 */
DEFINE('EVA_PARAM_FORMULE_MAX', 20);
DEFINE('EVA_MAX_LONGUEUR_OBSERVATIONS', 30000);
DEFINE('LARGEUR_GAUCHE', 49);
DEFINE('NOMBRE_ELEMENTS_AFFICHAGE_GRILLE_EVAL_RISQUES', 3);
DEFINE('NOMBRE_ELEMENTS_AFFICHAGE_GRILLE_DANGERS', 3);
DEFINE('DAY_BEFORE_TODAY_GANTT', 14);
DEFINE('DAY_AFTER_TODAY_GANTT', DAY_BEFORE_TODAY_GANTT);
DEFINE('LARGEUR_INDENTATION_GANTT_EN_EM', 1.5);

$linkToDownloadOpenOffice = 'http://www.openoffice.org/fr/Telecharger';
DEFINE('LINK_TO_DOWNLOAD_OPEN_OFFICE', $linkToDownloadOpenOffice);

/**
 *	Define the option possible value
*/
$optionYesNoList = array();
$optionYesNoList['oui'] = __('Oui', 'evarisk');
$optionYesNoList['non'] = __('Non', 'evarisk');

/**
 *	Define the option possible value
*/
$optionUserGender = array();
$optionUserGender['F'] = __('Femme', 'evarisk');
$optionUserGender['H'] = __('Homme', 'evarisk');

/**
 *	Define the option possible value
*/
$optionUserNationality = array();
$optionUserNationality['FR'] = __('Fran&ccedil;aise', 'evarisk');
$optionUserNationality['CEE'] = __('C.E.E', 'evarisk');
$optionUserNationality['OTHER'] = __('Autre', 'evarisk');

/**
 *	Define the option possible value
*/
$optionAccidentDeclarationType = array();
$optionAccidentDeclarationType['found'] = __('constat&eacute;', 'evarisk');
$optionAccidentDeclarationType['known'] = __('connu', 'evarisk');
$optionAccidentDeclarationType['registered'] = __('Inscrit au registre d\'infirmerie', 'evarisk');
$optionAccidentDeclarationBy = array();
$optionAccidentDeclarationBy['employer'] = __('par l\'employeur', 'evarisk');
$optionAccidentDeclarationBy['attendants'] = __('par ses pr&eacute;pos&eacute;s', 'evarisk');
$optionAccidentDeclarationBy['victim'] = __('D&eacute;crit par la victime', 'evarisk');
/**
 *	Define the option possible value
*/
$optionAciddentConsequence = array();
$optionAciddentConsequence['without_work_stop'] = __('Sans arr&ecirc;t de travail', 'evarisk');
$optionAciddentConsequence['with_work_stop'] = __('Avec arr&ecirc;t de travail', 'evarisk');
$optionAciddentConsequence['death'] = __('D&eacute;c&egrave;s', 'evarisk');
/**
 *	Define information about the work accident document
*/
DEFINE('CERFA_ACCIDENT_TRAVAIL_IDENTIFIER', '50261#01');
DEFINE('CERFA_ACCIDENT_TRAVAIL_LINK', 'http://www.ameli.fr/fileadmin/user_upload/formulaires/S6200.pdf');

/**
 *	Define the option possible value
*/
$optionExistingTreeElementList = array();
$optionExistingTreeElementList['recreate'] = __('Cr&eacute;er un nouveau', 'evarisk');
$optionExistingTreeElementList['reactiv'] = __('R&eacute;-activer', 'evarisk');

/**
 *	Define the list of hour and minute
*/
$digi_hour = $digi_minute = array();
for($i=0;$i<24;$i++){
	$digi_hour[$i] = sprintf('%02d', $i);
}
for($i=0;$i<60;$i++){
	$digi_minute[$i] = sprintf('%02d', $i);
}


/**
 *	Define the different mandatory field for user to ve valid for work accident
 */
$userWorkAccidentMandatoryFields = array('user_imatriculation', 'user_imatriculation_key', 'user_birthday', 'user_gender', 'user_nationnality', 'user_adress', /* 'user_adress_2', */ 'digi_hiring_date', 'digi_unhiring_date', 'user_profession', 'user_professional_qualification');

/**
 *	Define the different element available for evaluation method
*/
$evaluation_main_vars = array();
$evaluation_main_vars[] = array('nom' => __('Gravite', 'evarisk'), 'min' => 0, 'max' => 4, 'annotation' => __('0 : Pas de blessure possible\n1 : Blessure l&eacute;g&egrave;re\n2 : ITT<5 jours ou effet r&eacute;versible\n3 : ITT>5jours ou effet irr&eacute;versible\n4 : Menace sur la vie', 'evarisk'));
$evaluation_main_vars[] = array('nom' => __('Exposition', 'evarisk'), 'min' => 0, 'max' => 4, 'annotation' => __('0 : Jamais en contact\n1 : Rare, 1 fois par an\n2 : Inhabituelle, 1 fois par mois\n3 : Occasionnelle, 1 fois par semaine\n4 : Fr&eacute;quente, 1 fois par jour', 'evarisk'));
$evaluation_main_vars[] = array('nom' => __('Occurence', 'evarisk'), 'min' => 1, 'max' => 4, 'annotation' => __('1 : Jamais arriv&eacute;\n2 : Est d&eacute;j&agrave; arriv&eacute; dans des circonstances exeptionnelles\n3 : D&eacute;j&agrave; produit 2 fois\n4 : Se produit tous les mois', 'evarisk'));
$evaluation_main_vars[] = array('nom' => __('Formation', 'evarisk'), 'min' => 1, 'max' => 4, 'annotation' => __('1 : Pr&eacute;vention r&eacute;guli&egrave;re\n2 : Formation individuelle obligatoire\n3 : Formation obligatoire non r&eacute;alis&eacute;e\n4 : Pas de formation ni de pr&eacute;vention', 'evarisk'));
$evaluation_main_vars[] = array('nom' => __('Protection', 'evarisk'), 'min' => 1, 'max' => 4, 'annotation' => __('1 : Intrins&egrave;que\n2 : Collective\n3 : Individuelle\n4 : Rien', 'evarisk'));

$evaluation_method_operator = array();
$evaluation_method_operator[] = array('symbole' => '*');
$evaluation_method_operator[] = array('symbole' => '/');
$evaluation_method_operator[] = array('symbole' => '+');
$evaluation_method_operator[] = array('symbole' => '-');

$evaluation_method_evarisk__etalon = array();
$evaluation_method_evarisk__etalon[] = array('id_valeur_etalon' => 0, 'valeurMaxMethode' => 0);
$evaluation_method_evarisk__etalon[] = array('id_valeur_etalon' => 1, 'valeurMaxMethode' => 1);
$evaluation_method_evarisk__etalon[] = array('id_valeur_etalon' => 2, 'valeurMaxMethode' => 2);
$evaluation_method_evarisk__etalon[] = array('id_valeur_etalon' => 3, 'valeurMaxMethode' => 3);
$evaluation_method_evarisk__etalon[] = array('id_valeur_etalon' => 4, 'valeurMaxMethode' => 4);
$evaluation_method_evarisk__etalon[] = array('id_valeur_etalon' => 5, 'valeurMaxMethode' => 5);
$evaluation_method_evarisk__etalon[] = array('id_valeur_etalon' => 6, 'valeurMaxMethode' => 6);
$evaluation_method_evarisk__etalon[] = array('id_valeur_etalon' => 7, 'valeurMaxMethode' => 8);
$evaluation_method_evarisk__etalon[] = array('id_valeur_etalon' => 8, 'valeurMaxMethode' => 9);
$evaluation_method_evarisk__etalon[] = array('id_valeur_etalon' => 10, 'valeurMaxMethode' => 12);
$evaluation_method_evarisk__etalon[] = array('id_valeur_etalon' => 12, 'valeurMaxMethode' => 16);
$evaluation_method_evarisk__etalon[] = array('id_valeur_etalon' => 14, 'valeurMaxMethode' => 18);
$evaluation_method_evarisk__etalon[] = array('id_valeur_etalon' => 17, 'valeurMaxMethode' => 24);
$evaluation_method_evarisk__etalon[] = array('id_valeur_etalon' => 20, 'valeurMaxMethode' => 27);
$evaluation_method_evarisk__etalon[] = array('id_valeur_etalon' => 25, 'valeurMaxMethode' => 32);
$evaluation_method_evarisk__etalon[] = array('id_valeur_etalon' => 27, 'valeurMaxMethode' => 36);
$evaluation_method_evarisk__etalon[] = array('id_valeur_etalon' => 31, 'valeurMaxMethode' => 48);
$evaluation_method_evarisk__etalon[] = array('id_valeur_etalon' => 35, 'valeurMaxMethode' => 54);
$evaluation_method_evarisk__etalon[] = array('id_valeur_etalon' => 40, 'valeurMaxMethode' => 64);
$evaluation_method_evarisk__etalon[] = array('id_valeur_etalon' => 42, 'valeurMaxMethode' => 72);
$evaluation_method_evarisk__etalon[] = array('id_valeur_etalon' => 44, 'valeurMaxMethode' => 81);
$evaluation_method_evarisk__etalon[] = array('id_valeur_etalon' => 46, 'valeurMaxMethode' => 96);
$evaluation_method_evarisk__etalon[] = array('id_valeur_etalon' => 48, 'valeurMaxMethode' => 108);
$evaluation_method_evarisk__etalon[] = array('id_valeur_etalon' => 50, 'valeurMaxMethode' => 128);
$evaluation_method_evarisk__etalon[] = array('id_valeur_etalon' => 55, 'valeurMaxMethode' => 144);
$evaluation_method_evarisk__etalon[] = array('id_valeur_etalon' => 60, 'valeurMaxMethode' => 162);
$evaluation_method_evarisk__etalon[] = array('id_valeur_etalon' => 66, 'valeurMaxMethode' => 192);
$evaluation_method_evarisk__etalon[] = array('id_valeur_etalon' => 70, 'valeurMaxMethode' => 216);
$evaluation_method_evarisk__etalon[] = array('id_valeur_etalon' => 77, 'valeurMaxMethode' => 243);
$evaluation_method_evarisk__etalon[] = array('id_valeur_etalon' => 80, 'valeurMaxMethode' => 256);
$evaluation_method_evarisk__etalon[] = array('id_valeur_etalon' => 84, 'valeurMaxMethode' => 288);
$evaluation_method_evarisk__etalon[] = array('id_valeur_etalon' => 87, 'valeurMaxMethode' => 324);
$evaluation_method_evarisk__etalon[] = array('id_valeur_etalon' => 90, 'valeurMaxMethode' => 384);
$evaluation_method_evarisk__etalon[] = array('id_valeur_etalon' => 92, 'valeurMaxMethode' => 432);
$evaluation_method_evarisk__etalon[] = array('id_valeur_etalon' => 95, 'valeurMaxMethode' => 512);
$evaluation_method_evarisk__etalon[] = array('id_valeur_etalon' => 96, 'valeurMaxMethode' => 576);
$evaluation_method_evarisk__etalon[] = array('id_valeur_etalon' => 98, 'valeurMaxMethode' => 768);
$evaluation_method_evarisk__etalon[] = array('id_valeur_etalon' => 100, 'valeurMaxMethode' => 1024);

/**	Define the danger list	*/
$inrs_danger_categories = array();
$inrs_danger_categories[] = array('nom' => __('Accident de plain-pied', 'evarisk'), 'picture' => 'medias/images/Pictos/categorieDangers/chutePP_PictoCategorie.png', 'position' => 1);
$inrs_danger_categories[] = array('nom' => __('Chute de hauteur', 'evarisk'), 'picture' => 'medias/images/Pictos/categorieDangers/chuteH_PictoCategorie.png', 'position' => 2);
$inrs_danger_categories[] = array('nom' => __('Activit&eacute; physique', 'evarisk'), 'picture' => 'medias/images/Pictos/categorieDangers/activitePhysique.png', 'risks' => array(__('Travail sur &eacute;cran', 'evarisk')), 'position' => 5);
$inrs_danger_categories[] = array('nom' => __('Manutention m&eacute;canique', 'evarisk'), 'picture' => 'medias/images/Pictos/categorieDangers/manutentionMe_PictoCategorie.png', 'position' => 6);
$inrs_danger_categories[] = array('nom' => __('Circulation, d&eacute;placements', 'evarisk'), 'picture' => 'medias/images/Pictos/categorieDangers/circulation_PictoCategorie.png', 'position' => 4);
$inrs_danger_categories[] = array('nom' => __('Effondrements, chute d\'objet', 'evarisk'), 'picture' => 'medias/images/Pictos/categorieDangers/effondrement_PictoCategorie.png', 'position' => 10);
$inrs_danger_categories[] = array('nom' => __('&Eacute;quipements de travail', 'evarisk'), 'picture' => 'medias/images/Pictos/categorieDangers/machine_PictoCategorie.png', 'position' => 9);
$inrs_danger_categories[] = array('nom' => __('Nuisances sonores', 'evarisk'), 'picture' => 'medias/images/Pictos/categorieDangers/nuisances_PictoCategorie.png', 'position' => 11);
$inrs_danger_categories[] = array('nom' => __('Produits, &eacute;missions et d&eacute;chets', 'evarisk'), 'picture' => 'medias/images/Pictos/categorieDangers/produitsC_PictoCategorie.png', 'position' => 7);
$inrs_danger_categories[] = array('nom' => __('Incendie, explosion', 'evarisk'), 'picture' => 'medias/images/Pictos/categorieDangers/incendies_PictoCategorie.png', 'position' => 13);
$inrs_danger_categories[] = array('nom' => __('Electricit&eacute;', 'evarisk'), 'picture' => 'medias/images/Pictos/categorieDangers/electricite_PictoCategorie.png', 'position' => 14);
$inrs_danger_categories[] = array('nom' => __('Eclairage', 'evarisk'), 'picture' => 'medias/images/Pictos/categorieDangers/eclairage_PictoCategorie.png', 'position' => 15);
$inrs_danger_categories[] = array('nom' => __('Ambiances climatiques', 'evarisk'), 'picture' => 'medias/images/Pictos/categorieDangers/climat_PictoCategorie.png', 'position' => 12);
$inrs_danger_categories[] = array('nom' => __('Agents biologique', 'evarisk'), 'picture' => 'medias/images/Pictos/categorieDangers/manqueHygiene_PictoCategorie.png', 'position' => 8);

$inrs_danger_categories[] = array('version' => 71, 'nom' => __('Circulations internes', 'evarisk'), 'picture' => 'medias/images/Pictos/categorieDangers/circulation.png', 'position' => 3);
$inrs_danger_categories[] = array('version' => 71, 'nom' => __('Rayonnements', 'evarisk'), 'picture' => 'medias/images/Pictos/categorieDangers/rayonnement.png', 'position' => 16);
$inrs_danger_categories[] = array('version' => 71, 'nom' => __('Risques psychosociaux', 'evarisk'), 'picture' => 'medias/images/Pictos/categorieDangers/rps.png', 'position' => 17);

$inrs_danger_categories[] = array('version' => 73, 'nom' => __('Manutention manuelle', 'evarisk'), 'picture' => 'medias/images/Pictos/categorieDangers/manutentionMa_PictoCategorie.png', 'position' => 19);
$inrs_danger_categories[] = array('version' => 73, 'nom' => __('Postures penibles', 'evarisk'), 'picture' => 'medias/images/Pictos/categorieDangers/posturePenible.png', 'position' => 20);
$inrs_danger_categories[] = array('version' => 73, 'nom' => __('Vibrations', 'evarisk'), 'picture' => 'medias/images/Pictos/categorieDangers/vibrations.png', 'position' => 21);

$inrs_danger_categories[] = array('version' => 89, 'nom' => __('Amiante', 'evarisk'), 'picture' => 'medias/images/Pictos/categorieDangers/amiante.png', 'position' => 22);

$inrs_danger_categories[] = array('nom' => __('Autres', 'evarisk'), 'picture' => 'medias/images/Pictos/categorieDangers/autre_PictoCategorie.png', 'risks' => array(__('Manque de formation', 'evarisk'), __('Soci&eacute;t&eacute; ext&eacute;rieure', 'evarisk')), 'position' => 18);

DEFINE('DIGI_INRS_DANGER_LIST', serialize($inrs_danger_categories));

/*	Define the char for correctiv actions into DUER 	*/
DEFINE('DIGI_TASK_SEP', '_');
DEFINE('DIGI_SUBTASK_SEP', '+');

$available_fields_for_csv_export = array(
		'user_identifier' => __('Identifiant de l\'utilisateur', 'evarisk'), 'user_lastname' => __('Nom utilisateur', 'evarisk'), 'user_firstname' => __('Pr&eacute;nom utilisateur', 'evarisk'),
		'ref_elt' => __('R&eacute;f. &eacute;l&eacute;ment', 'evarisk'), 'name_elt' => __('Nom &eacute;l&eacute;ment', 'evarisk'),
		'affectation_date' => __('Date affectation &agrave; l\'&eacute;l&eacute;ment', 'evarisk'), 'unaffectation_date' => __('Date de d&eacute;saffectation &agrave; l\'&eacute;l&eacute;ment', 'evarisk'),
		//'ref_danger' => __('R&eacute;f. danger', 'evarisk'), 'name_danger' => __('Intitul&eacute; danger', 'evarisk'),
		'ref_risk' => __('R&eacute;f. risque', 'evarisk'), 'risk_cotation' => __('Cotation du risque', 'evarisk'), 'risk_comment' => __('Commentaire risque', 'evarisk'), 'risk_status' => __('P&eacute;nible (oui/non)', 'evarisk'),
);
DEFINE('DIGI_AVAILABLE_FIELDS_FOR_EXPORT', serialize( $available_fields_for_csv_export ));

/**
 *	Define the different existing element type
*/
$treeElementList = array(__('Cat&eacute;gories de pr&eacute;conisations', 'evarisk') => 'CP', __('Pr&eacute;conisations', 'evarisk') => 'P', __('M&eacute;thodes d\'&eacute;valuation', 'evarisk') => 'ME', __('Cat&eacute;gories de dangers', 'evarisk') => 'CD', __('Dangers', 'evarisk') => 'D', __('Groupements', 'evarisk') => 'GP', __('Unit&eacute;s de travail', 'evarisk') => 'UT', __('Actions correctives', 'evarisk') => 'T', __('Sous-actions correctives', 'evarisk') => 'ST', __('Risques', 'evarisk') => 'R', __('&Eacute;valuation', 'evarisk') => 'E', __('Utilisateurs', 'evarisk') => 'U', __('Groupes d\'utilisateurs', 'evarisk') => 'GPU', __('R&ocirc;les des utilisateurs', 'evarisk') => 'UR', __('Groupes de questions', 'evarisk') => 'GQ', __('Questions', 'evarisk') => 'Q', __('Produits', 'evarisk') => 'PDT', __('Cat&eacute;gorie de produits', 'evarisk') => 'CPDT', __('Documents unique', 'evarisk') => 'DU', __('Fiches de groupement', 'evarisk') => 'FGP', __('Groupes de fiches de groupement', 'evarisk') => 'GFGP', __('Fiches de poste', 'evarisk') => 'FP', __('Groupes de fiches de poste', 'evarisk') => 'GFP', __('Accident de travail', 'evarisk') => 'AT', __('Documents', 'evarisk') => 'DOC', __('Photos', 'evarisk') => 'PIC', __('Variable des m&eacute;thodes d\'&eacute;valuation', 'evarisk') => 'V', __('Synsth&egrave;se des risques du groupement', 'evarisk') => 'FSGP', __('Synsth&egrave;se des risques de l\'unit&eacute; de travail', 'evarisk') => 'FSUT', __('Pr&eacute;conisation affect&eaucte;e', 'evarisk') => 'PA', __('Fiche de p&eacute;nibilit&eacute;', 'evarisk') => 'FEP', __('Groupement de fiche de p&eacute;nibilit&eacute;', 'evarisk') => 'ZFEP', __('Lots de fiches de p&eacute;nibilit&eacute;', 'evarisk') => 'GFEP', __('Commentaires et notes', 'evarisk') => 'C', __('R&eacute;sum&eacute; pour les utilisateurs', 'evarisk') => 'US', __('Regroupement de r&eacute;sum&eacute; pour les utilisateurs', 'evarisk') => 'GUS', __('Export des utilisateurs au format csv', 'evarisk') => 'GUE');
$digirisk_tree_options = get_option('digirisk_tree_options');
$identifierList = (!empty($digirisk_tree_options['digi_tree_element_identifier']) ? unserialize($digirisk_tree_options['digi_tree_element_identifier']) : array());
foreach ( $treeElementList as $elementName => $elementDefault ) {
	$optionValue = $elementDefault;
	if ( isset($identifierList[$elementDefault]) && (trim($identifierList[$elementDefault]) != '') ) {
		$optionValue = $identifierList[$elementDefault];
	}
	DEFINE('ELEMENT_IDENTIFIER_' . $elementDefault, $optionValue);
}


/*	Define if we output a name or a picture into the column header for the right management	*/
DEFINE('SHOW_PICTURE_FOR_RIGHT_HEADER_COLUMN', true);
DEFINE('SHOW_PICTURE_FOR_RIGHT_HEADER_MASS_SELECTOR_COLUMN', true);

/*	Define the path to wp-shop plugin	*/
DEFINE('DIGI_WPSHOP_PLUGIN_MAINFILE', 'wpshop/wpshop.php');

/**
 *	Vars to delete when sure that the corresponding version is passed
*/
//version 35
DEFINE('EVA_RESULTATS_PLUGIN_OLD_URL', EVA_HOME_URL . 'medias/results/');
DEFINE('EVA_UPLOADS_PLUGIN_OLD_URL', EVA_HOME_URL . 'medias/uploads/');
DEFINE('EVA_MODELES_PLUGIN_OLD_DIR', EVA_UPLOADS_PLUGIN_OLD_DIR . 'modeles/');

DEFINE('DIGI_DTRANS_NB_ELMT_PER_PAGE', 10);
