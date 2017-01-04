<?php
/**
 * Affiches le titre de l'onglet risque et appelle la vue list.view du module risk
 *
 * @author Jimmy Latour <jimmy@evarisk.com>
 * @since 6.2.3.0
 * @version 6.2.3.0
 * @copyright 2015-2017 Evarisk
 * @package risk
 * @subpackage view
 */

namespace digi;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
?>

<h1><?php echo esc_html( 'Les risques de ' . $society->unique_identifier . ' - ' . $society->title ); ?></h1>

<?php view_util::exec( 'risk', 'list', array( 'society_id' => $society_id, 'risks' => $risks, 'risk_schema' => $risk_schema ) ); ?>
