<?php
namespace digi;
if ( !defined( 'ABSPATH' ) ) exit;
/**
* Database table names
*
* Define the different name of database table
* @author Evarisk <dev@evarisk.com>
* @version 5.0
* @package Digirisk
* @subpackage config
*/

global $wpdb;

/**
* Define the main prefix for the different database table
*/
DEFINE('PREFIXE_EVARISK', $wpdb->prefix . "eva__");
DEFINE('PREFIXE_EVARISK_TRASH', $wpdb->prefix . "evatrash__");

{/*	Etalon	*/
	DEFINE('TABLE_ETALON', PREFIXE_EVARISK . "etalon");
	DEFINE('TABLE_VALEUR_ETALON', PREFIXE_EVARISK . "valeur_etalon");
	DEFINE('TABLE_EQUIVALENCE_ETALON', PREFIXE_EVARISK . "equivalence_etalon");
}

{/*	M�thode	*/
	DEFINE('TABLE_METHODE', PREFIXE_EVARISK . "methode");
	DEFINE('TABLE_OPERATEUR', PREFIXE_EVARISK . "operateur");
	DEFINE('TABLE_VARIABLE', PREFIXE_EVARISK . "variable");
	DEFINE('TABLE_VALEUR_ALTERNATIVE', PREFIXE_EVARISK . "valeur_alternative");
	DEFINE('TABLE_AVOIR_VARIABLE', PREFIXE_EVARISK . "avoir_variable");
	DEFINE('TABLE_AVOIR_OPERATEUR', PREFIXE_EVARISK . "avoir_operateur");
}

{/*	Risque	*/
	DEFINE('TABLE_RISQUE', PREFIXE_EVARISK . "risque");
	DEFINE('TABLE_RISQUE_HISTO', PREFIXE_EVARISK . "risque_histo");
	DEFINE('TABLE_AVOIR_VALEUR', PREFIXE_EVARISK . "risque_evaluation");
}

{/*	Accident	*/
	DEFINE('DIGI_DBT_ACCIDENT', PREFIXE_EVARISK . "accident");
	DEFINE('DIGI_DBT_ACCIDENT_DETAILS', PREFIXE_EVARISK . "accident_details");
	DEFINE('DIGI_DBT_ACCIDENT_LOCATION', PREFIXE_EVARISK . "accident_location");
	DEFINE('DIGI_DBT_ACCIDENT_THIRD_PARTY', PREFIXE_EVARISK . "accident_third_party");
	DEFINE('DIGI_DBT_ACCIDENT_VICTIM', PREFIXE_EVARISK . "accident_victim");
}

{/*	Ged	*/
	DEFINE('TABLE_GED_DOCUMENTS', PREFIXE_EVARISK . "ged_documents");
	DEFINE('TABLE_GED_DOCUMENTS_META', PREFIXE_EVARISK . "ged_documents_meta");
	DEFINE('TABLE_FP', PREFIXE_EVARISK . "ged_documents_fiches");
	DEFINE('TABLE_DUER', PREFIXE_EVARISK . "ged_documents_document_unique");
}

{/*	Diverses	*/
	DEFINE('TABLE_PHOTO', PREFIXE_EVARISK . "photo");
	DEFINE('TABLE_PHOTO_LIAISON', PREFIXE_EVARISK . "liaison_photo_element");
	DEFINE('TABLE_ADRESSE', PREFIXE_EVARISK . "adresse");

	DEFINE('DIGI_DBT_ELEMENT_MODIFICATION', PREFIXE_EVARISK . 'element_modification');
	DEFINE('DIGI_DBT_ELEMENT_NOTIFICATION', PREFIXE_EVARISK . 'element_notification');

	DEFINE('DIGI_DBT_MESSAGES', PREFIXE_EVARISK . 'message');
	DEFINE('DIGI_DBT_HISTORIC', PREFIXE_EVARISK . 'message_histo');

	DEFINE('TABLE_MENU', PREFIXE_EVARISK . 'menu');
}

{/*	Hierarchie	*/
	DEFINE('TABLE_GROUPEMENT', PREFIXE_EVARISK . "groupement");
	DEFINE('TABLE_UNITE_TRAVAIL', PREFIXE_EVARISK . "unite_travail");
}

{/*	Danger	*/
	DEFINE('TABLE_CATEGORIE_DANGER', PREFIXE_EVARISK . "categorie_danger");
	DEFINE('TABLE_DANGER', PREFIXE_EVARISK . "danger");
}

{/*	Actions correctives	*/
	DEFINE('TABLE_TACHE', PREFIXE_EVARISK . "actions_correctives_tache");
	DEFINE('TABLE_ACTIVITE', PREFIXE_EVARISK . "actions_correctives_actions");
	DEFINE('EVA_TRASH_TABLE_ACTIVITE_SUIVI', PREFIXE_EVARISK . "actions_correctives_suivi");
	DEFINE('TABLE_ACTIVITE_SUIVI', PREFIXE_EVARISK . "element_suivi");
	DEFINE('TABLE_ACTIVITE_SUIVI_META', PREFIXE_EVARISK . "element_suivi_meta");
	DEFINE('TABLE_LIAISON_TACHE_ELEMENT', PREFIXE_EVARISK . "liaison_tache_element");
}

{/*	Veille r�f�rencielle	*/
	DEFINE('PREFIXE_VEILLE', PREFIXE_EVARISK . "veille_");
	// Table veille r�f�rencielle
	DEFINE('TABLE_TEXTE_REFERENCIEL', PREFIXE_VEILLE . "texte_referenciel");
	DEFINE('TABLE_CORRESPOND_TEXTE_REFERENCIEL', PREFIXE_VEILLE . "correspond_texte_referenciel");
	DEFINE('TABLE_GROUPE_QUESTION', PREFIXE_VEILLE . "groupe_question");
	DEFINE('TABLE_POSSEDE_QUESTION', PREFIXE_VEILLE . "possede_question");
	DEFINE('TABLE_QUESTION', PREFIXE_VEILLE . "question");
	DEFINE('TABLE_ACCEPTE_REPONSE', PREFIXE_VEILLE . "accepte_reponse");
	DEFINE('TABLE_REPONSE', PREFIXE_VEILLE . "reponse");
	DEFINE('TABLE_REPONSE_QUESTION', PREFIXE_VEILLE . "reponse_question");
	DEFINE('TABLE_CONCERNE_PAR_TEXTE_REFERENCIEL', PREFIXE_VEILLE . "concerne_par_texte_referenciel");

	DEFINE('TABLE_FORMULAIRE_LIAISON', PREFIXE_EVARISK . "liaison_formulaire");
}

{/*	Tables users	*/
	DEFINE('DIGI_DBT_USER', $wpdb->users);
	DEFINE('DIGI_DBT_USER_GROUP', PREFIXE_EVARISK . "utilisateurs_groupes");
	DEFINE('DIGI_DBT_LIAISON_USER_GROUP', PREFIXE_EVARISK . "liaison_utilisateur_groupe_element");

	DEFINE('TABLE_LIAISON_USER_ELEMENT', PREFIXE_EVARISK . "liaison_utilisateur_element");
	DEFINE('DIGI_DBT_LIAISON_USER_NOTIFICATION_ELEMENT', PREFIXE_EVARISK . "liaison_utilisateur_notification");
}

{/*	Pr�conisations	*/
	DEFINE('TABLE_CATEGORIE_PRECONISATION', PREFIXE_EVARISK . "preconisation_categorie");
	DEFINE('TABLE_PRECONISATION', PREFIXE_EVARISK . "preconisation");
	DEFINE('TABLE_LIAISON_PRECONISATION_ELEMENT', PREFIXE_EVARISK . "liaison_preconisation_element");
}

{/*	Produits	*/
	DEFINE('DIGI_DBT_PRODUIT', PREFIXE_EVARISK . "produit");
	DEFINE('DIGI_DBT_LIAISON_PRODUIT_ELEMENT', PREFIXE_EVARISK . "liaison_produit_element");
	DEFINE('DIGI_DBT_PRODUIT_ATTACHEMENT', PREFIXE_EVARISK . "produit_document");
}

{/*	Permissions	*/
	DEFINE('DIGI_DBT_PERMISSION_ROLE', PREFIXE_EVARISK . "permission_role");
}


{/*	Trash table	*/
	//	TABLES PLUS UTILISEES A PARTIR DE LA VERSION > 18
	DEFINE('TABLE_AC_TACHE', PREFIXE_EVARISK . "tache");
	DEFINE('TABLE_AC_ACTIVITE', PREFIXE_EVARISK . "activite");
	DEFINE('TABLE_AC_ACTION', PREFIXE_EVARISK . "actions_correctives_activite");
	DEFINE('TABLE_AVOIR_VALEUR_OLD', PREFIXE_EVARISK . "avoir_valeur");

	//	TABLES PLUS UTILISEES A PARTIR DE LA VERSION > 25
	DEFINE('TABLE_LIAISON_USER_EVALUATION', PREFIXE_EVARISK . "users_evaluation_bind");
	DEFINE('TRASH_DIGI_DBT_LIAISON_USER_EVALUATION', PREFIXE_EVARISK_TRASH . "users_evaluation_bind");

	//	TABLES PLUS UTILISEES A PARTIR DE LA VERSION > 37
	DEFINE('TABLE_DUER_OLD', PREFIXE_EVARISK . "document_unique");
	DEFINE('TABLE_FP_OLD', PREFIXE_EVARISK . "ged_documents_fiche_de_poste");

	//	TABLES PLUS UTILISEES A PARTIR DE LA VERSION > 39
	// Tables EPI
	DEFINE('TABLE_EPI', PREFIXE_EVARISK . "ppe");
	DEFINE('TRASH_DIGI_DBT_EPI', PREFIXE_EVARISK_TRASH . "ppe");
	DEFINE('TABLE_UTILISE_EPI', PREFIXE_EVARISK . "use_ppe");
	DEFINE('TRASH_DIGI_DBT_UTILISE_EPI', PREFIXE_EVARISK_TRASH . "use_ppe");

	//	TABLES PLUS UTILISEES A PARTIR DE LA VERSION > 44
	DEFINE('TABLE_EVA_USER_GROUP', PREFIXE_EVARISK . "users_group");
	DEFINE('TRASH_DIGI_DBT_USER_GROUP', PREFIXE_EVARISK_TRASH . "users_group");
	DEFINE('TABLE_EVA_EVALUATOR_GROUP', PREFIXE_EVARISK . "evaluators_group");
	DEFINE('TRASH_DIGI_DBT_EVALUATOR_GROUP', PREFIXE_EVARISK_TRASH . "evaluators_group");

	DEFINE('TABLE_LIAISON_USER_GROUPS', PREFIXE_EVARISK . "users_group_bind");
	DEFINE('TRASH_DIGI_DBT_LIAISON_USER_GROUPS', PREFIXE_EVARISK_TRASH . "users_group_bind");
	DEFINE('TABLE_EVA_EVALUATOR_GROUP_BIND', PREFIXE_EVARISK . "evaluators_group_bind");
	DEFINE('TRASH_DIGI_DBT_EVALUATOR_GROUP_BIND', PREFIXE_EVARISK_TRASH . "evaluators_group_bind");

	DEFINE('TABLE_EVA_USER_GROUP_DETAILS', PREFIXE_EVARISK . "users_group_details");
	DEFINE('TRASH_DIGI_DBT_USER_GROUP_DETAILS', PREFIXE_EVARISK_TRASH . "users_group_details");
	DEFINE('TABLE_EVA_EVALUATOR_GROUP_DETAILS', PREFIXE_EVARISK . "evaluators_group_details");
	DEFINE('TRASH_DIGI_DBT_EVALUATOR_GROUP_DETAILS', PREFIXE_EVARISK_TRASH . "evaluators_group_details");

	DEFINE('TABLE_EAV_USER_DATETIME', PREFIXE_EVARISK . "users_entity_datetime");
	DEFINE('TRASH_DIGI_DBT_EAV_USER_DATETIME', PREFIXE_EVARISK_TRASH . "users_entity_datetime");
	DEFINE('TABLE_EAV_USER_DECIMAL', PREFIXE_EVARISK . "users_entity_decimal");
	DEFINE('TRASH_DIGI_DBT_EAV_USER_DECIMAL', PREFIXE_EVARISK_TRASH . "users_entity_decimal");
	DEFINE('TABLE_EAV_USER_INT', PREFIXE_EVARISK . "users_entity_int");
	DEFINE('TABLE_TABLE_EAV_USER_INT', PREFIXE_EVARISK_TRASH . "users_entity_int");
	DEFINE('TABLE_EAV_USER_TEXT', PREFIXE_EVARISK . "users_entity_text");
	DEFINE('TRASH_DIGI_DBT_EAV_USER_TEXT', PREFIXE_EVARISK_TRASH . "users_entity_text");
	DEFINE('TABLE_EAV_USER_VARCHAR', PREFIXE_EVARISK . "users_entity_varchar");
	DEFINE('TRASH_DIGI_DBT_EAV_USER_VARCHAR', PREFIXE_EVARISK_TRASH . "users_entity_varchar");

	DEFINE('TABLE_EVA_ROLES', PREFIXE_EVARISK . "roles");
	DEFINE('TRASH_DIGI_DBT_EVA_ROLES', PREFIXE_EVARISK_TRASH . "roles");
	DEFINE('TABLE_EVA_USER_GROUP_ROLES_DETAILS', PREFIXE_EVARISK . "users_group_roles_details");
	DEFINE('TRASH_DIGI_DBT_EVA_USER_GROUP_ROLES_DETAILS', PREFIXE_EVARISK_TRASH . "users_group_roles_details");

	// Modele EAV
	DEFINE('PREFIXE_EAV', $wpdb->prefix . "eav__");
	// Table entit�s
	DEFINE('TABLE_ENTITY', PREFIXE_EAV . "entity_type");
	DEFINE('TRASH_DIGI_DBT_ENTITY', PREFIXE_EVARISK_TRASH . "eav__entity_type");
	// Table liaison entit�s / attributs
	DEFINE('TABLE_ENTITY_ATTRIBUTE_LINK', PREFIXE_EAV . "entity_attribute_link");
	DEFINE('TRASH_DIGI_DBT_ENTITY_ATTRIBUTE_LINK', PREFIXE_EVARISK_TRASH . "eav__entity_attribute_link");
	// Table attributes set
	DEFINE('TABLE_ATTRIBUTE_SET', PREFIXE_EAV . "attribute_set");
	DEFINE('TRASH_DIGI_DBT_ATTRIBUTE_SET', PREFIXE_EVARISK_TRASH . "eav__attribute_set");
	// Table attributs
	DEFINE('TABLE_ATTRIBUTE', PREFIXE_EAV . "attribute");
	DEFINE('TRASH_DIGI_DBT_ATTRIBUTE', PREFIXE_EVARISK_TRASH . "eav__attribute");
	// Table groupes attributs
	DEFINE('TABLE_ATTRIBUTE_GROUP', PREFIXE_EAV . "attribute_group");
	DEFINE('TRASH_DIGI_DBT_ATTRIBUTE_GROUP', PREFIXE_EVARISK_TRASH . "eav__attribute_group");
	// Table attributs option
	DEFINE('TABLE_ATTRIBUTE_OPTION', PREFIXE_EAV . "attribute_option");
	DEFINE('TRASH_DIGI_DBT_ATTRIBUTE_OPTION', PREFIXE_EVARISK_TRASH . "eav__attribute_option");
	// Table attributs option value
	DEFINE('TABLE_ATTRIBUTE_OPTION_VALUE', PREFIXE_EAV . "attribute_option_value");
	DEFINE('TRASH_DIGI_DBT_ATTRIBUTE_OPTION_VALUE', PREFIXE_EVARISK_TRASH . "eav__attribute_option_value");
	// Table attributs value
	DEFINE('TABLE_ATTRIBUTE_VALUE', PREFIXE_EVARISK . "%sentity_%s");

	DEFINE('TABLE_PERSONNE', PREFIXE_EVARISK . "personne");
	DEFINE('TRASH_DIGI_DBT_PERSONNE', PREFIXE_EVARISK_TRASH . "personne");


	DEFINE('TABLE_OPTION', PREFIXE_EVARISK . "option");
	DEFINE('TRASH_DIGI_DBT_OPTION', PREFIXE_EVARISK_TRASH . "option");
	DEFINE('TABLE_VERSION', PREFIXE_EVARISK . "version");
	DEFINE('TRASH_DIGI_DBT_VERSION', PREFIXE_EVARISK_TRASH . "version");

	//	TABLES PLUS UTILISEES A PARTIR DE LA VERSION > 60
	DEFINE('DIGI_DBT_PERMISSION', PREFIXE_EVARISK . "permission");
	DEFINE('TRASH_DIGI_DBT_PERMISSION', PREFIXE_EVARISK_TRASH . "permission");
}

?>
