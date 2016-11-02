<?php namespace digi;

if ( !defined( 'ABSPATH' ) ) exit;
/**
 * This file is the main file called by wordpress for our plugin use. It define the basic vars and include the different file needed to use the plugin
 * @author Evarisk <dev@evarisk.com>
 * @version 5.0
 * @package Digirisk
 */

/**	Include the different config for the plugin	*/
require_once( PLUGIN_DIGIRISK_PATH . config_util::$init['transfer_data']->path . '/include/config.php' );

/*	CLEAN UP A VAR BEFORE SENDING IT TO OUTPUT OR DATABASE	*/
function IsValid_Variable($MyVar2Test,$DefaultValue='')
{
	$MyVar = (trim(strip_tags(stripslashes($MyVar2Test)))!='') ? trim(strip_tags(stripslashes(($MyVar2Test)))) : $DefaultValue ;
	$MyVar = html_entity_decode(str_replace("&rsquo;", "'", htmlentities($MyVar, ENT_COMPAT, 'UTF-8')), ENT_COMPAT, 'UTF-8');

	return $MyVar;
}
/**
 *	Return the current database version for the plugin
 *
 *	@param string $subOptionName The option we want to get the value for
 *
 *	@return mixed $optionSubValue The value of the option
 */
function getDbOption( $subOptionName )
{
	$optionSubValue = -1;

	/*	Get the db option 	*/
	$optionValue = get_option( 'digirisk_db_option' );

	if($optionValue != ''){
		if(is_array($optionValue)){
			$optionSubValue = $optionValue[$subOptionName];
		}
		elseif(is_string($optionValue)){
			$optionValue = unserialize($optionValue);
			$optionSubValue = $optionValue[$subOptionName];
		}
	}

	/*	Keep the old method to get plugin version because of update	*/
	if($optionSubValue == -1){
		global $wpdb;
		$subOptionName = IsValid_Variable($subOptionName);
		if( $wpdb->get_var("show tables like '" . TABLE_VERSION . "'") == TABLE_VERSION){
			$query = $wpdb->prepare("SELECT version
					FROM " . TABLE_VERSION . "
					WHERE nom = %s", $subOptionName);
			$resultat = $wpdb->get_row($query);
			$optionSubValue = $resultat->version;
		}
	}

	return (int)$optionSubValue;
}

function getOptionValue($optionName, $option = 'digirisk_options'){
	$digirisk_options = get_option($option);
	$option_value='';

	if(!empty($digirisk_options[$optionName]))
		$option_value = $digirisk_options[$optionName];

	return $option_value;
}

/**
 * Récupération des notes et commentaires associés aux éléments / Get notes and comments associated to elements
 *
 * @param unknown_type $tableElement
 * @param unknown_type $idElement
 * @param unknown_type $type
 * @param unknown_type $specific_follow_up
 * @return Ambigous <multitype:, object, NULL, multitype:multitype: , multitype:unknown >
 */
function getSuiviActivite($tableElement, $idElement, $type = 'note', $specific_follow_up = 0) {
	global $wpdb;

	$more_query = '';
	switch ($tableElement) {
		case TABLE_AVOIR_VALEUR:
			$query = $wpdb->prepare("SELECT GROUP_CONCAT(id_evaluation) as risk_eval_list FROM " . TABLE_AVOIR_VALEUR . " WHERE id_risque = (SELECT DISTINCT(id_risque) FROM " . TABLE_AVOIR_VALEUR . " WHERE id_evaluation = %d) GROUP BY id_risque", $idElement);
			$risk_eval_list = $wpdb->get_var($query);
			$request_params = array($tableElement, $type);
			$more_query = "";
			if ( !empty($specific_follow_up) ) {
				$more_query = " AND id = %d";
				$request_params[] = $specific_follow_up;
			}
			$query = $wpdb->prepare(
					"SELECT *
			FROM " . TABLE_ACTIVITE_SUIVI . "
			WHERE id_element IN (" . $risk_eval_list . ")
				AND table_element = '%s'
				AND status = 'valid'
				AND follow_up_type = %s
				" . $more_query . "
			ORDER BY date_ajout DESC",
					$request_params
			);
			break;
		default:
			$request_params = array($idElement, $tableElement, $type);
			$more_query = "";
			if ( !empty($specific_follow_up) ) {
				$more_query = " AND id = %d";
				$request_params[] = $specific_follow_up;
			}
			$query = $wpdb->prepare(
					"SELECT *
					FROM " . TABLE_ACTIVITE_SUIVI . "
					WHERE id_element = '%s'
						AND table_element = '%s'
						AND status = 'valid'
						AND follow_up_type = %s
						" . $more_query . "
					ORDER BY date DESC",
					$request_params
			);
			break;
	}

	return $wpdb->get_results($query);
}

/**
 * Récupère la liste des risques associés à un élément / Get risks associated to an element
 *
 * @param unknown_type $nomTableElement
 * @param unknown_type $idTableElement
 * @param unknown_type $status
 * @param unknown_type $where
 * @param unknown_type $order
 * @param unknown_type $evaluation_status
 * @return Ambigous <multitype:, object, NULL, multitype:multitype: , multitype:unknown >
 */
function getRisques($nomTableElement = 'all', $idTableElement = 'all', $status='all', $where = '1', $order='tableRisque.id ASC', $evaluation_status = "'Valid'") {
	global $wpdb;
	$where = IsValid_Variable($where);
	$order = IsValid_Variable($order);
	if( $status=='all' ){
		$status = '1';
	}
	else{
		$status = "tableRisque.Status = '" . $status . "'";
	}

	$tableElement = $idElement = "1";
	if($nomTableElement != 'all'){
		$tableElement = "tableRisque.nomTableElement='" . ($nomTableElement) . "' ";
	}
	if($idTableElement != 'all'){
		$idElement = "tableRisque.id_element = '" . ($idTableElement) . "' ";
	}

	$query = $wpdb->prepare(
			"SELECT tableRisque.*,
				tableAvoirValeur.idEvaluateur, tableAvoirValeur.id_risque id_risque, tableAvoirValeur.id_variable id_variable, tableAvoirValeur.valeur valeur, tableAvoirValeur.id_evaluation, tableAvoirValeur.Status AS evaluation_status, DATE_FORMAT(tableAvoirValeur.date, %s) AS evaluation_date, tableAvoirValeur.commentaire AS histo_com, tableAvoirValeur.date AS unformatted_evaluation_date,
				tableDanger.nom nomDanger, tableDanger.id idDanger, tableDanger.description descriptionDanger, tableDanger.id_categorie idCategorie
			FROM " . TABLE_RISQUE . " tableRisque
				LEFT JOIN " . TABLE_AVOIR_VALEUR . " tableAvoirValeur ON (tableAvoirValeur.id_risque = tableRisque.id AND tableAvoirValeur.Status IN (" . $evaluation_status . ")),
				" . TABLE_DANGER . " tableDanger
			WHERE " . $tableElement . "
				AND " . $idElement . "
				AND " . $status . "
				AND " . $where . "
				AND tableRisque.id_danger = tableDanger.id
			ORDER BY " . $order, '%Y-%m-%d %r');
	$resultat = $wpdb->get_results( $query );

	return $resultat;
}

function getMethod($id){
	global $wpdb;
	$id = (int) $id;
	$t = TABLE_METHODE;
	return $wpdb->get_row( "SELECT * FROM {$t} WHERE id = " . $id);
}
function getVariablesMethode($id_methode, $date=null){
	global $wpdb;

	if ($date==null) {
		$date=current_time('mysql', 0);
	}
	$id_methode = (int) $id_methode;
	$tav = TABLE_AVOIR_VARIABLE;
	$tv =  TABLE_VARIABLE ;
	return $wpdb->get_results( "SELECT *
			FROM " . $tv . ", " . $tav . " t1
			WHERE t1.id_methode=" . $id_methode . "
			AND t1.date < '" . $date . "'
			AND NOT EXISTS(
				SELECT *
				FROM " . $tav . " t2
				WHERE t2.id_methode=" . $id_methode . "
				AND t2.date < '" . $date . "'
				AND t1.date < t2.date
			)
			AND id_variable=id
			ORDER BY ordre ASC");
}

function getValeurAlternative($idVariable, $valeur, $date = ""){
	global $wpdb;

	if(empty($date)){
		$date = current_time('mysql', 0);
	}

	$sql = "
			SELECT *
			FROM " . TABLE_VALEUR_ALTERNATIVE . " tva1
			WHERE tva1.id_variable = " . $idVariable . "
			AND tva1.valeur = " . $valeur . "
			AND tva1.date < '" . $date . "'
			AND NOT EXISTS
			(
				SELECT *
				FROM " . TABLE_VALEUR_ALTERNATIVE . " tva2
				WHERE tva2.id_variable = " . $idVariable . "
				AND tva2.valeur = " . $valeur . "
				AND tva2.date < '" . $date . "'
				AND tva2.date > tva1.date
			)
			";
	$resultat = $wpdb->get_row($sql);
	if($resultat != null){
		$valeurAlternative = $resultat->valeurAlternative;
	}
	else{
		$valeurAlternative = $valeur;
	}

	return $valeurAlternative;
}

function getOperateursMethode($id_methode, $date = null){
	global $wpdb;

	if($date==null){
		$date = current_time('mysql', 0);
	}
	$id_methode = (int) $id_methode;
	$t = TABLE_AVOIR_OPERATEUR;
	$query = $wpdb->prepare("SELECT *
		FROM " . $t . " t1
		WHERE t1.id_methode = %d
			AND t1.date < %s
      AND t1.Status = 'Valid'
			AND NOT EXISTS
			(
				SELECT *
				FROM " . $t . " t2
				WHERE t2.id_methode = %d
					AND t2.date < %s
					AND t1.date < t2.date
			)
		ORDER BY ordre ASC", $id_methode, $date, $id_methode, $date);
	return $wpdb->get_results($query);
}

function getScoreRisque( $risque, $method_option = '' ) {
	$date_to_take = $risque[0]->date;
	$scoreRisque = 0;
	/*	Add option allowing to modify method behavior */
	if(is_array($method_option)){
		if(isset($method_option['date_to_take']) && ($method_option['date_to_take'] != '')){
			$date_to_take = $method_option['date_to_take'];
		}
	}

	$methode = getMethod( $risque[0]->id_methode );
	if ( !empty( $methode ) ) {
		$listeVariables = getVariablesMethode($methode->id, $date_to_take);
		unset($listeIdVariables);
		$listeIdVariables = array();
		foreach($listeVariables as $ordre => $variable){
			$listeIdVariables['"' . $variable->id . '"'][]=$ordre;
		}
		unset($listeValeurs);
		foreach($risque as $ligneRisque){
			if(!empty($listeIdVariables) && !empty($listeIdVariables['"' . $ligneRisque->id_variable . '"']) && is_array($listeIdVariables['"' . $ligneRisque->id_variable . '"'])){
				foreach($listeIdVariables['"' . $ligneRisque->id_variable . '"'] as $ordre){
					if(isset($method_option['value_to_take']) && ($method_option['value_to_take'] != '')){
						$listeValeurs[$ordre] = getValeurAlternative($ligneRisque->id_variable, $method_option['value_to_take'][$ligneRisque->id_variable], $date_to_take);
					}
					else{
						$listeValeurs[$ordre] = getValeurAlternative($ligneRisque->id_variable, $ligneRisque->valeur, $date_to_take);
					}
				}
			}
		}

		$listeOperateursComplexe = getOperateursMethode($methode->id, $date_to_take);
		unset($listeOperateurs);$listeOperateurs = array();
		foreach ( $listeOperateursComplexe as $operateurComplexe ) {
			$listeOperateurs[] = $operateurComplexe->operateur;
		}
		$listeValeursSimples;
		$listeOperateursSimple;

		//r�solution des op�ration de forte priorit� (i.e. * et /)
		$scoreRisque = !empty($listeValeurs[0]) ? $listeValeurs[0] : 0;
		$numeroValeur = 0;
		if($listeOperateurs != null){
			// invariant de boucle : la valeur $listeValeurs[$numeroValeur] est trait�
			foreach($listeOperateurs as $operateur){
				$numeroValeur = $numeroValeur + 1;
				if ( isset( $listeValeurs[ $numeroValeur ] ) ) {
					switch($operateur){
						case '*' :
							$scoreRisque = $scoreRisque * $listeValeurs[$numeroValeur];
							break;
						case '/' :
							$scoreRisque = $scoreRisque / $listeValeurs[$numeroValeur];
							break;
							//default <=> op�rateur de faible priorit� (i.e. + et -)
						default :
							$listeValeursSimples[] = $scoreRisque;
							$listeOperateursSimples[] = $operateur;
							$scoreRisque = $listeValeurs[$numeroValeur];
							break;
					}
				}
			}
		}
		//Comme il y a une valeur de plus que d'operateur, on la range � la fin
		$listeValeursSimples[] = $scoreRisque;

		//r�solution du score
		$scoreRisque = $listeValeursSimples[0];
		$numeroValeur = 0;
		if(isset($listeOperateursSimples) && ($listeOperateursSimples != null)){
			// invariant de boucle : la valeur $listeValeursSimples[$numeroValeur] est trait�
			foreach($listeOperateursSimples as $operateur){
				$numeroValeur = $numeroValeur + 1;
				switch($operateur){
					case '+' :
						$scoreRisque = $scoreRisque + $listeValeursSimples[$numeroValeur];
						break;
					case '-' :
						$scoreRisque = $scoreRisque - $listeValeursSimples[$numeroValeur];
						break;
					default : break;
				}
			}
		}
	}
	else {
		log_class::g()->exec( 'digirisk-datas-transfert-' . TABLE_RISQUE, '', __( 'Aucune méthode d\'évaluation n\'a été associée au risque', 'wp-digi-dtrans-i18n' ), array( 'object_id' => $risque[ 0 ]->id, 'data' => $risque, ), 2 );
	}

	return $scoreRisque;
}

function getEquivalenceEtalon($idMethode, $score, $date=null) {
	global $wpdb;

	if($date==null){
		$date=current_time('mysql', 0);
	}

	$score = IsValid_Variable($score);
	$idMethode = IsValid_Variable($idMethode);
	$resultat = $wpdb->get_row("SELECT tableEquivalenceEtalon1.id_valeur_etalon equivalenceEtalon
			FROM " . TABLE_EQUIVALENCE_ETALON . " tableEquivalenceEtalon1
			WHERE tableEquivalenceEtalon1.valeurMaxMethode >= " . $score . "
			AND tableEquivalenceEtalon1.id_methode = " . $idMethode . "
			AND tableEquivalenceEtalon1.date <= '" . $date . "'
                        AND tableEquivalenceEtalon1.Status = 'Valid'
			AND NOT EXISTS
			(
				SELECT *
				FROM " . TABLE_EQUIVALENCE_ETALON . " tableEquivalenceEtalon2
				WHERE tableEquivalenceEtalon2.valeurMaxMethode >= " . $score . "
				AND tableEquivalenceEtalon2.id_methode = " . $idMethode . "
				AND tableEquivalenceEtalon2.date <= '" . $date . "'
				AND tableEquivalenceEtalon2.date > tableEquivalenceEtalon1.date
				AND tableEquivalenceEtalon2.id_valeur_etalon < tableEquivalenceEtalon1.id_valeur_etalon
			)");

	return !empty($resultat->equivalenceEtalon) ? $resultat->equivalenceEtalon : '0';
}

function getSeuil($quotation) {
	global $wpdb;

	$quotation = IsValid_Variable($quotation);
	$resultat = $wpdb->get_row( "
			SELECT tableValeurEtalon1.niveauSeuil niveauSeuil
			FROM " . TABLE_VALEUR_ETALON . " tableValeurEtalon1
			WHERE tableValeurEtalon1.valeur <= " . $quotation . "
			AND tableValeurEtalon1.Status = 'Valid'
			AND tableValeurEtalon1.niveauSeuil != 'NULL'
			AND NOT EXISTS
			(
				SELECT *
				FROM " . TABLE_VALEUR_ETALON . " tableValeurEtalon2
				WHERE tableValeurEtalon2.valeur >= " . $quotation . "
				AND tableValeurEtalon2.Status = 'Valid'
				AND tableValeurEtalon2.niveauSeuil != 'NULL'
				AND tableValeurEtalon2.valeur < tableValeurEtalon1.valeur
			)
			ORDER BY tableValeurEtalon1.niveauSeuil DESC
			LIMIT 1"
	);
	$niveauSeuil = !empty($resultat->niveauSeuil) ? (int)$resultat->niveauSeuil : 0;
	return $niveauSeuil;
}

function getPere($table, $element, $where="Status='Valid'") {
	global $wpdb;
	$query = $wpdb->prepare( "
	SELECT *
	FROM " . $table . " table1
	WHERE " . $where . "
	AND table1.limiteGauche < " . $element->limiteGauche . "
	AND table1.limiteDroite > " . $element->limiteDroite . "
	AND NOT
	EXISTS (
		SELECT *
		FROM " . $table . " table2
		WHERE " . $where . "
		AND table2.limiteGauche < " . $element->limiteGauche . "
		AND table2.limiteDroite > " . $element->limiteDroite . "
		AND table1.limiteGauche < table2.limiteGauche
	)", "");
	$resultat = $wpdb->get_row($query);
	return $resultat;
}
