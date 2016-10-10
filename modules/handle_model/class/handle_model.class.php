<?php namespace digi;

if ( !defined( 'ABSPATH' ) ) exit;
/**
* Fichier de gestion des actions pour le tableau de bord de Digirisk / File for managing Digirisk dashboard
*
* @author Jimmy Latour <dev@evarisk.com>
* @since 6.1.5.5
* @copyright 2015-2016 Evarisk
* @package Digirisk\handle_model
* @subpackage class
*/

/**
* Classe de gestion des actions pour les exports et imports des données de Digirisk / Class for managing export and import for Digirisk datas
*
* @author Jimmy Latour <dev@evarisk.com>
* @since 6.1.5.10
* @copyright 2015-2016 Evarisk
* @package Digirisk\handle_model
* @subpackage class
*/
class handle_model_class extends singleton_util {
	private $index;
	private $data;
	/**
	 * Constructeur de la classe. Doit être présent même si vide pour coller à la définition "abstract" des parents / Class constructor. Must be present even if empty for matchin with "abstract" definition of ancestors
	 */
	function construct() {}

}
