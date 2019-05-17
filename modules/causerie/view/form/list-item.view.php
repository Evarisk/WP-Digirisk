<?php
/**
 * Affichage d'une causerie dans l'onglet "Ajouter une causerie".
 *
 * @author    Evarisk <dev@evarisk.com>
 * @since     6.6.0
 * @version   6.6.0
 * @copyright 2018 Evarisk.
 * @package   DigiRisk
 */

namespace digi;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
} ?>

<tr class="causerie-row" data-id="<?php echo esc_attr( $causerie->data['id'] ); ?>">
	<td data-title="Ref." class="padding">
		<span>
			<strong><?php echo esc_html( $causerie->data['unique_identifier'] ); ?></strong>
		</span>
	</td>
	<td data-title="Photo" class="padding">
		<?php echo do_shortcode( '[wpeo_upload id="' . $causerie->data['id'] . '" model_name="/digi/Causerie_Class" mode="view" single="false" field_name="image" ]' ); ?>
	</td>
	<td data-title="Catégorie" class="padding">
		<?php
		if ( isset( $causerie->data['risk_category'] ) ) :
			do_shortcode( '[digi_dropdown_categories_risk id="' . $causerie->data['id'] . '" type="causerie" display="view" category_risk_id="' . $causerie->data['risk_category']->data['id'] . '"]' );
		else :
			?>C<?php
		endif;
		?>
	</td>
	<td data-title="Titre et description" class="padding">
		<span class="row-title"><?php echo esc_html( $causerie->data['title'] ); ?></span>
		<span class="row-subtitle"><?php echo nl2br( $causerie->data['content'] ); ?></span>
	</td>
	<td class="w150">
		<div class="action wpeo-gridlayout grid-gap-0 grid-3">
			<?php if ( $causerie->data['sheet'] && $causerie->data['sheet']->data['file_generated'] ) : ?>
				<a class="wpeo-button button-purple button-square-50" href="<?php echo esc_attr( $causerie->data['sheet']->data['link'] ); ?>">
					<i class="fas fa-download icon" aria-hidden="true"></i>
				</a>
			<?php else : ?>
				<span class="action-attribute wpeo-button button-grey button-square-50 wpeo-tooltip-event"
					data-id="<?php echo esc_attr( $causerie->data['id'] ); ?>"
					data-model="<?php echo esc_attr( $causerie->get_class() ); ?>"
					data-action="generate_document"
					data-color="red"
					data-direction="left"
					aria-label="<?php echo esc_attr_e( 'Corrompu. Cliquer pour regénérer.', 'digirisk' ); ?>">
					<i class="fas fa-times icon" aria-hidden="true"></i>
				</span>
			<?php endif; ?>

			<!-- Editer un causerie -->
			<div 	class="wpeo-button light button-square-50 edit action-attribute"
						data-id="<?php echo esc_attr( $causerie->data['id'] ); ?>"
						data-nonce="<?php echo esc_attr( wp_create_nonce( 'ajax_load_edit_causerie' ) ); ?>"
						data-loader="causerie-row"
						data-action="load_edit_causerie"><i class="icon fa fa-pencil-alt"></i></div>

			<div 	class="wpeo-button light button-square-50 delete action-delete button-transparent"
						data-id="<?php echo esc_attr( $causerie->data['id'] ); ?>"
						data-nonce="<?php echo esc_attr( wp_create_nonce( 'ajax_delete_causerie' ) ); ?>"
						data-message-delete="<?php echo esc_attr_e( 'Supprimer cette causerie ?', 'digirisk' ); ?>"
						data-action="delete_causerie"><i class="icon fa fa-times"></i></div>
		</div>
	</td>
</tr>
