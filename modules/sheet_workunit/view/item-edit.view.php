<?php
/**
 * Gestion du formulaire pour générer une fiche de groupement
 *
 * @author Jimmy Latour <jimmy@evarisk.com>
 * @version 6.2.1.0
 * @copyright 2015-2016 Evarisk
 * @package sheet_groupment
 * @subpackage view
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

?>

<li class='wp-digi-list-item wp-digi-risk-item'>
	<input type="hidden" name="action" value="generate_fiche_de_poste" />
	<?php wp_nonce_field( 'ajax_generate_fiche_de_poste' ); ?>
	<input type="hidden" name="element_id" value="<?php echo esc_attr( $element_id ); ?>" />
	<span></span>
	<span><?php esc_html_e( 'Générer une nouvelle fiche de poste', 'digirisk' ); ?></span>

	<span class="wp-digi-action">
		<a href="#" class="wp-digi-action wp-digi-action-edit dashicons dashicons-plus" ></a>
	</span>
</li>
