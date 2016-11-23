<?php
/**
 * Affiches le titre du l'unique identifiant et le titre de la societé
 * Appelle le template pour afficher la liste des risques
 *
 * @package Evarisk\Plugin
 */

namespace digi;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
?>

<h2><?php echo esc_html( 'Les risques de ' . $society->unique_identifier . ' - ' . $society->title ); ?></h2>

<?php view_util::exec( 'risk', 'list', array( 'society' => $society, 'risks' => $society->list_risk, 'risk_schema' => $risk_schema ) ); ?>
