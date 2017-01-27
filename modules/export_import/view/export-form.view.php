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
		<input type="hidden" name="action" value="digi_export_data" />
		<?php /** Crtéation d'un nonce de sécurité pour le formulaire / Create a security nonce for the form */ wp_nonce_field( 'digi_export_data' ); ?>
		<input type="hidden" name="element_id" value="<?php echo $element_id; ?>" />

		<span class="digi-export-explanation" ><?php _e( 'Realise a export of your Digirisk datas. It should be used to import into another instance of the software. You can use it as many times as you like.', 'digirisk' ); ?></span>

		<ul class="hidden">
			<li>
				<label><input type="checkbox" name="type_to_export[]" value="<?php echo group_class::g()->get_post_type(); ?>" checked="true" /><?php _e( 'Groupements', 'digirisk' ); ?></label>
			</li>
			<li>
				<label><input type="checkbox" name="type_to_export[]" value="<?php echo workunit_class::g()->get_post_type(); ?>" checked="true" /><?php _e( 'Work units', 'digirisk' ); ?></label>
			</li>
			<li>
				<label><input type="checkbox" name="type_to_export[]" value="<?php echo risk_class::g()->get_post_type(); ?>" checked="true" /><?php _e( 'Risks', 'digirisk' ); ?></label>
			</li>
		</ul>
	</div>

	<button class="button blue" id="digi-export-button" ><?php _e( 'Export my Digirisk datas', 'digirisk' ); ?></button>
</form>
