<?php namespace digi;

if ( !defined( 'ABSPATH' ) ) exit;
/**
 * Fichier du squelette du formulaire permettant de lancer l'export des données / Template file for the form allowing to export datas
 *
 * @author Alexandre Techer <dev@evarisk.com>
 * @version 6.1.5.5
 * @copyright 2015-2016 Evarisk
 * @package export_import
 * @subpackage view
 */
?>
<form action="<?php echo admin_url( 'admin-ajax.php' ); ?>" method="POST" id="digi-export-form" >
	<h3><?php _e( 'Export', 'digirisk' ); ?></h3>

	<div class="content">
		<?php esc_html_e( 'Indisponible', 'digirisk' ); ?>
	</div>

</form>
